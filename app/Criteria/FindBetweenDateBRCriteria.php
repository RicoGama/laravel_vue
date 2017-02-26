<?php

namespace CodeFin\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindBetweenDateBRCriteria
 * @package namespace CodeFin\Criteria;
 */
class FindBetweenDateBRCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $dateInString;

    /**
     * FindBetweenDateBRCriteria constructor
     * @param $dateInString
     */
    public function __construct($dateInString)
    {
        $this->dateInString = $dateInString;
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
        $dates = explode('-', $this->dateInString);
        if (count($dates) > 1) {
            $formatBr = 'd/m/Y';
            $format = 'Y-m-d';
            list($dateStart, $dateEnd) = $dates;
            $dateStart = \DateTime::createFromFormat($formatBr, trim($dateStart));
            $dateEnd = \DateTime::createFromFormat($formatBr, trim($dateEnd));
            if ($dateStart && $dateEnd) {
                $model = $model->orWhere(function ($query) use ($dateStart, $dateEnd, $format) {
                    $query->whereBetween('date_due', [
                        $dateStart->format($format),
                        $dateEnd->format($format)
                    ]);
                });
            }
        }
        return $model;
    }
}
