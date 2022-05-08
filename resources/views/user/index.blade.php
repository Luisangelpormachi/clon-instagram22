@extends('layouts.app')

@section('content')
<div class="container  mt-5 mb-5">
<div class="row justify-content-center">
    <div class="col-md-8">

        <form method="GET" action="{{ route('user.index') }}" id="buscador">
            <div class="row pl-3 pr-3">
                <div class="form-group mr-1">
                    <input type="text" id="search" class="form-control" placeholder="">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="Buscar">   
                </div>
            </div>
        </form>

        <div class="card">

            <div class="card-header text-center"><h2>Lista de usuarios</h2></div>
            <div class="card-body">
                <div class="box-list-user">

                    @foreach ($users as $item)
                    <div class="list-user-info">
                        
                        <div class="list-img">
                            @if($item->image)
                                <img src="{{ route('user.avatar', ['filename' => $item->image]) }}" alt="" class="user-avatar">
                            @else
                                <img src="{{ route('user.avatar', ['filename' => 'perfil_men.jpg']) }}" class="user-avatar" alt="">
                            @endif
                        </div>

                        <div class="list-description">
                            <h1>{{ '@'.$item->nick }}</h1>
                            <h2>{{ $item->name }} {{ $item->surname }}</h2>
                            <p>Se unió {{ FormatTime::LongTimeFilter($item->created_at) }}</p>
                            <a href="{{ route('user.profile', ['id' => $item->id]) }}" class="btn btn-sm btn-success color-white">Ver perfil</a>
                        </div>

                    </div>
                    <hr>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
    <div class="paginate">
        {{ $users->links() }}
    </div>
</div>
</div>

@endsection