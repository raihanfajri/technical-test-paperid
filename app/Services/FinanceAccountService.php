<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use App\Repositories\FinanceAccountRepositoryInterface as FinanceAccountRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FinanceAccountService
{
    protected $financeAccount;

	public function __construct(FinanceAccountRepository $financeAccount)
	{
		$this->financeAccount = $financeAccount;
    }
    
    public function create($params)
    {
        return $this->financeAccount->create(
            $params
        );
    }

    public function update($id, $params)
    {
        $financeAccount = $this->detail($id);

        $financeAccount->update(
            $params
        );

        return  $financeAccount;
    }

    public function delete($id)
    {
        $financeAccount = $this->detail($id);

        return $financeAccount->delete();
    }

    public function list($params)
    {
        $page = $params['page'] ?? 1;
        $limit = $params['limit'] ?? 10;

        $offset = ($page - 1) * $limit;
        $q = $params['q'] ?? "";

        return $this->financeAccount->list($offset, $limit, $q);
    }

    public function detail($id)
    {
        $financeAccount = $this->financeAccount->find($id);

        if (!$financeAccount)
        {
            throw new NotFoundHttpException("Finance Account not found!");
        }

        return  $financeAccount;
    }
}