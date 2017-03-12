<?php

namespace CodeFin\Repositories;

use CodeFin\Criteria\LockTableCriteria;
use CodeFin\Presenters\BankAccountPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFin\Models\BankAccount;

/**
 * Class BankAccountRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class BankAccountRepositoryEloquent extends BaseRepository implements BankAccountRepository
{

    protected $fieldSearchable = [
        'name' => 'like',
        'agency' => 'like',
        'account' => 'like',
        'bank.name' => 'like',
    ];

    public function addBalance($id, $value)
    {
        $skipPresenter = $this->skipPresenter();
        $this->skipPresenter(true);

        \DB::beginTransaction();
        $this->pushCriteria(new LockTableCriteria());
        $model = $this->find($id);
        $model->balance = $model->balance + $value;
        $model->save();
        \DB::commit();
        $this->popCriteria(LockTableCriteria::class);

        $this->skipPresenter = $skipPresenter;
        return $this->parserResult($model);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BankAccount::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Get Presenter
     *
     * @return string
     */
    public function presenter()
    {
        return BankAccountPresenter::class;
    }
}
