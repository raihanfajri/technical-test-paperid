<?php

namespace App\Repositories\Eloquent;

use App\Models\FinanceTransaction;
use App\Repositories\FinanceTransactionRepositoryInterface;
use Illuminate\Support\Collection;

class FinanceTransactionRepository extends BaseRepository implements FinanceTransactionRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param User $model
    */
   public function __construct(FinanceTransaction $model)
   {
       parent::__construct($model);
   }

   protected function searchByQ($query, $q)
   {
        return $query->where(
            function ($queryExt) use ($q)
            {
                $queryExt->where('title', 'like', "$q%")
                    ->orWhere('description', 'like', "$q%");
            }        
        );
   }

   protected function withRelations($query)
   {
       return $query->with(['account']);
   }
}