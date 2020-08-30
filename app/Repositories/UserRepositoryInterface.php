<?php
namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
   public function all(): Collection;
   public function findOneByEmail($email);
}