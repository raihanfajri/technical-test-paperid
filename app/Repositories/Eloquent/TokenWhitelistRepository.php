<?php

namespace App\Repositories\Eloquent;

use App\Models\TokenWhitelist;
use App\Repositories\TokenWhitelistRepositoryInterface;
use Illuminate\Support\Collection;

class TokenWhitelistRepository extends BaseRepository implements TokenWhitelistRepositoryInterface
{

   public function __construct(TokenWhitelist $model)
   {
       parent::__construct($model);
   }

   public function findOneActiveByToken($token)
   {
        return $this->isActive()->where('token', $token)
            ->first();
   }

   protected function isActive()
   {
       return $this->model->where('expired_at', '>', date('Y-m-d H:i:s'));
   }
}