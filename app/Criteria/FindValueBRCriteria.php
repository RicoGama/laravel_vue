<?php

namespace CodeFin\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindValueBRCriteria
 * @package namespace CodeFin\Criteria;
 */
class FindValueBRCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $number;

    /**
     * FindValueBRCriteria constructor.
     * @param $number
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $numberFormatter = new \NumberFormatter('pt-BR', \NumberFormatter::DECIMAL);
        $numberFormatter->setAttribute(\NumberFormatter::MAX_FRACTION_DIGITS, 2);
        $number = $numberFormatter->parse($this->number);
        if ($number !== false) {
            $model = $model->orWhere('value', $number);
        }
        return $model;
    }
}
