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

   protected function searchByQ($query, $q)
   {
        return $query->where(
            function ($queryExt) use ($q)
            {
                $queryExt->where('name', 'like', "$q%")
                    ->orWhere('description', 'like', "$q%")
                    ->orWhere('type', 'like', "$q%");
            }        
        );
   }
}