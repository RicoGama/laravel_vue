<?php

namespace CodeFin\Repositories;

trait GetClientsTrait {

    private function getClients()
    {
        /** @var \CodeFin\Repositories\ClientRepository $repository */
        $repository = app(\CodeFin\Repositories\ClientRepository::class);
        $repository->skipPresenter(true);
        return $repository->all();
    }

}