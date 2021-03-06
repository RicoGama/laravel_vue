@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <h4>Editar banco</h4>
            {!! Form::model($bank, [
                'route' => ['admin.banks.update', 'bank' => $bank->id],
                'method' => 'PUT',
                'files' => true,
                ]) !!}
                @include('admin.banks._form')
                <div class="row">
                    {!! Form::submit('Salvar banco', ['class' => 'btn waves-effect']) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection