<?php

namespace CodeFin\Listeners;

use CodeFin\Events\BillStoredEvent;
use CodeFin\Models\BillPay;
use CodeFin\Repositories\BankAccountRepository;
use CodeFin\Repositories\StatementRepository;
use Prettus\Repository\Events\RepositoryEventBase;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class BankAccountUpdateBalanceListener
 * @package CodeFin\Listeners
 */
class BankAccountUpdateBalanceListener
{
    /**
     * @var BankAccountRepository
     */
    private $bankAccountRepository;
    /**
     * @var StatementRepository
     */
    private $statementRepository;

    /**
     * Create the event listener.
     *
     * @param BankAccountRepository $repository
     * @return void
     */
    public function __construct(BankAccountRepository $bankAccountRepository, StatementRepository $statementRepository)
    {

        $this->bankAccountRepository = $bankAccountRepository;
        $this->bankAccountRepository->skipPresenter(true);
        $this->statementRepository = $statementRepository;
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEventBase  $event
     * @return void
     */
    public function handle(BillStoredEvent $event)
    {
        $model = $event->getModel();
        $bankAccountId = $model->bank_account_id;
        $value = $this->getValue($event);
        if ($value) {
            $bankAccount = $this->bankAccountRepository->addBalance($bankAccountId, $value);
            $this->statementRepository->create([
                'statementable' => $model,
                'value' => $value,
                'balance' => $bankAccount->balance,
                'bank_account_id' => $bankAccount->id
            ]);
        }
    }

    protected function getValue(BillStoredEvent $event)
    {
        $model = $event->getModel();
        $modelOld = $event->getModelOld();

        $value = $model->value;
        $valueOld = $modelOld ? $modelOld->value : $model->value;
        $doneOld = $modelOld ? $modelOld->done : false;

        if ($value != $valueOld) { // valor do conta alterado
            if ($model->done == $modelOld->done && $model->done) { // conta continua paga
                return $model instanceof BillPay ? $valueOld - $value : $value - $valueOld;
            }
        }

        if ($model->done != $doneOld) {
            if ($model->done) {
                return $model instanceof BillPay ? -$value : $value;
            } else {
                return $model instanceof BillPay ? $valueOld : -$valueOld;
            }
        }
        return 0;
    }
}