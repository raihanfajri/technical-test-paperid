<?php

namespace App\Repositories\Eloquent;

use App\Models\FinanceAccount;
use App\Repositories\FinanceAccountRepositoryInterface;
use Illuminate\Support\Collection;

class FinanceAccountRepository extends BaseRepository implements FinanceAccountRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param User $model
    */
   public function __construct(FinanceAccount $model)
   {
       parent::__construct($model);
   }

   /**
    * @return Collection
    */
   public function all(): Collection
   {
       return $this->model->all();    
   }
}