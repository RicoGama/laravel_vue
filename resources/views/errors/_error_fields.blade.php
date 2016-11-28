@if($errors->any())
    <ul class="collection">
        <li class="collection-item red white-text"><strong>Foram encontrados os seguintes erros:</strong></li>
        @foreach($errors->all() as $error)
            <li class="collection-item red white-text">{{$error}}</li>
        @endforeach
    </ul>
@endif