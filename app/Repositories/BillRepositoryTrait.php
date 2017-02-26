<?php

namespace CodeFin\Repositories;

trait BillRepositoryTrait
{
    protected function repeatBill(array $attributes)
    {
        $repeat = filter_var($attributes['repeat'], FILTER_VALIDATE_BOOLEAN);
        if ($repeat) {
            $repeatNumber = (int) $attributes['repeat_number'];
            $repeatType = (int) $attributes['repeat_type'];
            $dateDue = $attributes['date_due'];
            foreach (range(1, $repeatNumber) as $value) {
                $dateNew = $this->model->addDate($dateDue, $value, $repeatType);
                $attributesNew = array_merge($attributes, ['date_due' => $dateNew->format('Y-m-d')]);
                parent::create($attributesNew);
            }
        }
    }
}