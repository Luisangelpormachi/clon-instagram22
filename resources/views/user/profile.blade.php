@extends('layouts.app')

@section('content')

<div class="box-profile-user">

    @include('includes/message')

    <div class="profile-image">
        @if($user->image)
            <img src="{{ route('user.avatar', ['filename' => $user->image]) }}" alt="" class="user-avatar">
        @else
            <img src="{{ route('user.avatar', ['filename' => 'perfil_men.jpg']) }}" class="user-avatar" alt="">
        @endif
    </div>


    <div class="profile-user-info">
        <div class="">
            <h1>{{ '@'.$user->nick }}</h1>
            <h2>{{ $user->name }} {{ $user->surname }}</h2>
            <p>Se unió {{ FormatTime::LongTimeFilter($user->created_at) }}</p>
        </div>
    </div>
    
</div>

<div class="clear-fix"></div>

<div class="container">
    <div class="row justify-content-center">

        <div class="profile-images">
            @include('includes/message')

            @foreach($user->images as $item)
                @include('includes/image')
            @endforeach
        </div>

    </div>
</div>
@endsection