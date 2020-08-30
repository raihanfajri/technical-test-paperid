<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
* Interface EloquentRepositoryInterface
* @package App\Repositories
*/
interface EloquentRepositoryInterface
{
   /**
    * @param array $attributes
    * @return Model
    */
   public function create(array $attributes): Model;

   public function update(array $attributes): Bool;

   public function delete(): bool;

   /**
    * @param $id
    * @return Model
    */
   public function find($id);

   public function all(): Collection;

   public function list($offset, $limit, $q): Collection;
}