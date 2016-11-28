<?php

namespace CodeFin\Listeners;

use CodeFin\Events\BankStoredEvent;
use CodeFin\Models\Bank;
use CodeFin\Repositories\BankRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BankLogoUploadListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BankRepository $bankRepository)
    {
        $this->repository = $bankRepository;
    }

    /**
     * Handle the event.
     *
     * @param  BankStoredEvent  $event
     * @return void
     */
    public function handle(BankStoredEvent $event)
    {
        $bank = $event->getBank();
        $logo = $event->getLogo();
        if ($logo) {
            $name = $bank->created_at != $bank->update_at ? $bank->logo : md5(time()).'.'.$logo->guessExtension();
            $destFile = Bank::logosDir();

            \Storage::disk('public')->putFileAs($destFile, $logo, $name);

            if ($bank->created_at == $bank->update_at) {
                $this->repository->update(['logo' => $name], $bank->id);
            }
        }
    }
}
