<?php

namespace CodeFin\Repositories;

use CodeFin\Events\BankStoredEvent;
use Illuminate\Http\UploadedFile;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFin\Models\Bank;

/**
 * Class BankRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class BankRepositoryEloquent extends BaseRepository implements BankRepository
{
    public function create(array $attributes)
    {
        $logo = $attributes['logo'];
        $attributes['logo'] = "semimagem.jpeg";
        $model = parent::create($attributes);
        $event = new BankStoredEvent($model, $logo);
        event($event);

        return $model;
    }

    public function update(array $attributes, $id)
    {
        $logo = null;
        if (isset($attributes['logo']) && $attributes['logo'] instanceof UploadedFile) {
            $logo = $attributes['logo'];
            unset($attributes['logo']);
        }
        $model =  parent::update($attributes, $id);
        $event = new BankStoredEvent($model, $logo);
        event($event);

        return $model;
    }


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Bank::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
