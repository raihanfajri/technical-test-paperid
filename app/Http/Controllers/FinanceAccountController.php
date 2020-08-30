<?php

namespace App\Http\Controllers;

use App\Services\FinanceAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FinanceAccountController extends Controller
{
    protected $financeAccountService;

    public function __construct(FinanceAccountService $financeAccountService)
    {
        $this->financeAccountService = $financeAccountService;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'string',
            'type' => 'string|max:20',
        ]);

        if ($validator->fails()) {
            throw new BadRequestHttpException(implode(" | ", $validator->errors()->all()));
        }

        $financeAccount = $this->financeAccountService->create(
            $request->only(
                ['name', 'description', 'type']
            )
        );

        return response([
            'message' => "Successfully create a finance account",
            'data' => $financeAccount
        ], 201);
    }

    public function list(Request $request)
    {
        $financeAccounts = $this->financeAccountService->list(
            $request->all()
        );

        return response([
            'data' => $financeAccounts->all()
        ], 200);
    }

    public function detail(Request $request, $id)
    {
        $financeAccounts = $this->financeAccountService->detail(
            $id
        );

        return response([
            'data' => $financeAccounts
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'description' => 'string',
            'type' => 'string|max:20',
        ]);

        if ($validator->fails()) {
            throw new BadRequestHttpException(implode(" | ", $validator->errors()->all()));
        }

        $financeAccount = $this->financeAccountService->update(
            $id,
            $request->only(
                ['name', 'description', 'type']
            )
        );

        return response([
            'message' => "Successfully update finance account",
            'data' => $financeAccount
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        $this->financeAccountService->delete($id);

        return response([
            'message' => "Successfully delete finance account"
        ], 200);
    }
}
