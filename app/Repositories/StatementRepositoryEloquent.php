<?php

namespace CodeFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFin\Repositories\StatementRepository;
use CodeFin\Models\Statement;
use CodeFin\Validators\StatementValidator;

/**
 * Class StatementRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class StatementRepositoryEloquent extends BaseRepository implements StatementRepository
{
    public function create(array $attributes)
    {
        $statementable = $attributes['statementable'];
        return $statementable->statements()->create(array_except($attributes, 'statementable'));
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Statement::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
