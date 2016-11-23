@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h4>Listagem de bancos</h4>
            <a href="{{route('admin.banks.create')}}" class="btn waves-effect">Novo banco</a>
            <div class="col s12">
                <table class="bordered striped highlight centered responsive-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($banks as $bank)
                        <tr>
                            <td>{{ $bank->id }}</td>
                            <td>{{ $bank->name }}</td>
                            <td>
                                <a href="{{ route('admin.banks.edit', ['bank' => $bank->id]) }}">Editar</a>
                                <a href="#" v-on:click.prevent="deleteBank(<?php echo $bank->id ?>)">Excluir</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!! $banks->links() !!}
            </div>
        </div>
    </div>
@endsection