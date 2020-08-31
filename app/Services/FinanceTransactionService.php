<?php

namespace App\Services;

use App\Repositories\FinanceTransactionRepositoryInterface as FinanceTransactionRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FinanceTransactionService
{
    protected $financeTransaction;

    protected $financeAccountService;

    public function __construct(
        FinanceTransactionRepository $financeTransaction,
        FinanceAccountService $financeAccountService
    )
	{
        $this->financeTransaction = $financeTransaction;
        
        $this->financeAccountService = $financeAccountService;
    }
    
    public function create($params)
    {
        $financeAccID = $params['account']['id'] ?? 0;

        if (!empty($financeAccID))
        {
            $financeAcc = $this->financeAccountService->detail($financeAccID);

            $params['finance_account_id'] = $financeAcc->id;
        }

        $financeAcc = $this->financeAccountService->detail($financeAccID);

        $params['finance_account_id'] = $financeAcc->id;

        return $this->financeTransaction->create(
            $params
        );
    }

    public function update($id, $params)
    {
        $financeAccID = $params['account']['id'] ?? 0;

        $financeTransaction = $this->detail($id);

        if (!empty($financeAccID))
        {
            $financeAcc = $this->financeAccountService->detail($financeAccID);

            $params['finance_account_id'] = $financeAcc->id;
        }

        $financeTransaction->update(
            $params
        );

        return  $financeTransaction;
    }

    public function delete($id)
    {
        $financeTransaction = $this->detail($id);

        return $financeTransaction->delete();
    }

    public function list($params)
    {
        $page = $params['page'] ?? 1;
        $limit = $params['limit'] ?? 10;

        $offset = ($page - 1) * $limit;
        $q = $params['q'] ?? "";

        return $this->financeTransaction->list($offset, $limit, $q);
    }

    public function detail($id)
    {
        $financeTransaction = $this->financeTransaction->find($id);

        if (!$financeTransaction)
        {
            throw new NotFoundHttpException(trans('transaction.not_found'));
        }

        return  $financeTransaction;
    }
}