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
        $query = $this->model;

        $query = $this->withRelations($query);

        return $query->find($id);
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
        $query = $this->initQuery();

        $query = $this->searchByQ($query, $q);

        $query = $this->withRelations($query);

        return $query->offset($offset)
            ->limit($limit)
            ->get();    
    }

    protected function searchByQ($query, $q)
    {
        return $query;
    }

    protected function withRelations($query)
    {
        return $query;
    }

    protected function initQuery()
    {
        return $this->model;
    }
}