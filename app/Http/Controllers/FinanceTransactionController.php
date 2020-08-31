<?php

namespace App\Http\Controllers;

use App\Services\FinanceTransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FinanceTransactionController extends Controller
{
    protected $financeTransactionService;

    public function __construct(FinanceTransactionService $financeTransactionService)
    {
        $this->financeTransactionService = $financeTransactionService;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'string',
            'amount' => 'required|numeric',
            'finance_name' => 'required|string|max:255',
            'account.id' => 'required_with:account|numeric'
        ]);

        if ($validator->fails()) {
            throw new BadRequestHttpException(implode(" | ", $validator->errors()->all()));
        }

        $financeAccount = $this->financeTransactionService->create(
            $request->only(
                [
                    'title', 'description', 'amount',
                    'finance_name', 'account'
                ]
            )
        );

        return response([
            'message' => trans('transaction.success_create'),
            'data' => $financeAccount
        ], 201);
    }

    public function list(Request $request)
    {
        $financeAccounts = $this->financeTransactionService->list(
            $request->all()
        );

        return response([
            'data' => $financeAccounts->all()
        ], 200);
    }

    public function detail(Request $request, $id)
    {
        $financeAccounts = $this->financeTransactionService->detail(
            $id
        );

        return response([
            'data' => $financeAccounts
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'description' => 'string',
            'amount' => 'numeric',
            'finance_name' => 'string|max:255',
            'account.id' => 'required_with:account|numeric'
        ]);

        if ($validator->fails()) {
            throw new BadRequestHttpException(implode(" | ", $validator->errors()->all()));
        }

        $financeAccount = $this->financeTransactionService->update(
            $id,
            $request->only(
                [
                    'title', 'description', 'amount',
                    'finance_name', 'account'
                ]
            )
        );

        return response([
            'message' => trans('transaction.success_update'),
            'data' => $financeAccount
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $this->financeTransactionService->delete($id);

        return response([
            'message' => trans('transaction.success_delete')
        ], 200);
    }
}
