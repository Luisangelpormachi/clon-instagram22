@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes/message')

            @foreach($images as $item)
            <div class="card container-image-pub">
                <div class="card-header">
                    @if($item->user->image)
                        <div class="perfil-avatar">
                            <img src="{{ route('user.avatar', ['filename' => $item->user->image]) }}" class="user-avatar" alt="">
                        </div>
                    @else  
                        <div class="perfil-avatar">
                            <img src="{{ route('user.avatar', ['filename' => 'perfil_men.jpg']) }}" class="user-avatar" alt="">
                        </div>
                    @endif
                    <a href="{{ route('image.detail', [$item->id]) }}" class="nombres-pub">
                        {{ $item->user->name.' '.$item->user->lastname}}
                        <span class="nickname">{{'| @'.$item->user->nick}}</span>
                    </a>
                </div>

                <div class="card-body">
                    <div class="img-pub">
                        <img src="{{ route('image.file', ['filename' => $item->image_path]) }}" alt="">
                    </div>
                    <div class="img-description">
                        <span class="nickname">{{'@'.$item->user->nick}}</span>
                        <span class="nickname datetime">{{'| '.FormatTime::LongTimeFilter($item->created_at) }}</span>
                        <p>{{ $item->description }}</p>
                    </div>
                    <div class="box-like">
                        <img src="{{ asset('img/icons/heart-grey.png') }}" alt="">
                    </div>
                    <div class="box-comment">
                        <a href="{{ route('image.detail', [$item->id]) }}" class="btn btn-sm btn-warning">Comentario ({{ count($item->comments) }}) </a>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="paginate">
            {{ $images->links() }}
        </div>
    </div>
</div>
@endsection