<?php

namespace CodeFin\Presenters;

use CodeFin\Transformers\BillReceiveTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class BillReceivePresenter
 *
 * @package namespace CodeFin\Presenters;
 */
class BillReceivePresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BillReceiveTransformer();
    }
}
