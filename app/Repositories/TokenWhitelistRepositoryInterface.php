<?php
namespace App\Repositories;

use App\Models\TokenWhitelist;
use Illuminate\Support\Collection;

interface TokenWhitelistRepositoryInterface
{
   public function findOneActiveByToken($token);
}