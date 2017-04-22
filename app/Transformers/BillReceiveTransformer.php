<?php

namespace CodeFin\Transformers;

use League\Fractal\TransformerAbstract;
use CodeFin\Models\BillReceive;

/**
 * Class BillReceiveTransformer
 * @package namespace CodeFin\Transformers;
 */
class BillReceiveTransformer extends TransformerAbstract
{

    /**
     * Transform the \BillReceive entity
     * @param \BillReceive $model
     *
     * @return array
     */
    public function transform(BillReceive $model)
    {
        return [
            'id'         => (int) $model->id,
            'date_due'   => $model->date_due,
            'name'       => $model->name,
            'value'      => $model->value,
            'done'       => $model->done,
            'category_id' => (int) $model->category_id,
            'bank_account_id' => (int) $model->bank_account_id,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeCategory(BillReceive $model)
    {
        $transformer = new CategoryTransformer();
        $transformer->setDefaultIncludes([]);
        return $this->item($model->bankAccount, new BankAccountTransformer());
    }

    public function includeBankAccount(BillReceive $model)
    {
        return $this->item($model->bankAccount, new BankAccountTransformer());
    }
}
