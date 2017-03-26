<?php

namespace CodeFin\Repositories;

use CodeFin\Presenters\BillReceivePresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFin\Models\BillReceive;

/**
 * Class BillReceivesRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class BillReceivesRepositoryEloquent extends BaseRepository implements BillReceivesRepository
{
    use BillRepositoryTrait;

    protected $fieldSearchable = [
        'name' => 'like'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BillReceive::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return BillReceivePresenter::class;
    }
}
