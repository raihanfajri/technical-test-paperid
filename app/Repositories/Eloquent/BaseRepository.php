<?php   

namespace App\Repositories\Eloquent;   

use App\Repositories\EloquentRepositoryInterface; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BaseRepository implements EloquentRepositoryInterface 
{     
    /**      
     * @var Model      
     */     
     protected $model;       

    /**      
     * BaseRepository constructor.      
     *      
     * @param Model $model      
     */     
    public function __construct(Model $model)     
    {         
        $this->model = $model;
    }
 
    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function update(array $attributes): Bool
    {
        return $this->model->update($attributes);
    }

    public function delete(): bool
    {
        return $this->model->delete();
    }
 
    /**
    * @param $id
    * @return Model
    */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
    * @return Collection
    */
    public function all(): Collection
    {
        return $this->model->all();    
    }

    /**
    * @return Collection
    */
    public function list($offset, $limit, $q): Collection
    {
        return $this->searchByQ($q)
            ->offset($offset)
            ->limit($limit)
            ->get();    
    }

    protected function searchByQ($q)
    {
        return $this->model;
    }
}