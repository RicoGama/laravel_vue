<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBanksData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** @var \CodeFin\Repositories\BankRepository $repository */
        $repository = app(\CodeFin\Repositories\BankRepository::class);
        foreach ($this->getData() as $bankArray) {
            $repository->create($bankArray);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

    public function getData()
    {
        return [
            [
                'name' => 'Caixa',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/banks/logos/caixa.png'),
                    'caixa.png'
                )
            ],
            [
                'name' => 'Bradesco',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/banks/logos/bradesco.png'),
                    'bradesco.png'
                )
            ],
            [
                'name' => 'Itaú',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/banks/logos/itau.png'),
                    'itau.png'
                )
            ],
            [
                'name' => 'Banco do Brasil',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/banks/logos/banco-do-brasil.png'),
                    'banco-do-brasil.png'
                )
            ],
            [
                'name' => 'Santander',
                'logo' => new \Illuminate\Http\UploadedFile(
                    storage_path('app/files/banks/logos/santander.png'),
                    'santander.png'
                )
            ]
        ];
    }
}