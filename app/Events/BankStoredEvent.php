<?php

namespace CodeFin\Events;


use CodeFin\Models\Bank;
use Illuminate\Http\UploadedFile;

class BankStoredEvent
{

    private $bank;
    private $logo;

    /**
     * Create a new event instance.
     *
     * @param Bank $bank
     * @param UploadedFile $logo
     */
    public function __construct(Bank $bank, UploadedFile $logo)
    {
        $this->bank = $bank;
        $this->logo = $logo;
    }

    /**
     * @return Bank
     */
    public function getBank()
    {
        return $this->bank;
    }

    /**
     * @return UploadedFile
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Handle the event
     *
     * @param BankStoredEvent $event
     * @return void
     */
    public function handle(BankStoredEvent $event)
    {

    }
}
