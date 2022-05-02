@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include('includes/message')

            <div class="card container-image-pub">
                <div class="card-header">
                    @if($image->user->image)
                    <div class="perfil-avatar">
                        <img src="{{ route('user.avatar', ['filename' => $image->user->image]) }}" class="user-avatar" alt="">
                    </div>
                    @else
                    <div class="perfil-avatar">
                        <img src="{{ route('user.avatar', ['filename' => 'perfil_men.jpg']) }}" class="user-avatar" alt="">
                    </div>
                    @endif
                    <div class="nombres-pub">
                        {{ $image->user->name.' '.$image->user->lastname}}
                        <span class="nickname">{{'| @'.$image->user->nick}}</span>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-lg-7">

                            <div class="col-lg-12">
                                <div class="img-pub">
                                    <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" alt="">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="img-description">
                                    <span class="nickname">{{'@'.$image->user->nick}}</span>
                                    <span class="nickname datetime">{{'| '.FormatTime::LongTimeFilter($image->created_at) }}</span>

                                    <p>{{ $image->description }}</p>
                                </div>
                                <div class="box-like">
                                    <img src="{{ asset('img/icons/heart-grey.png') }}" alt="">
                                </div>
                            </div>
                            <div class="col-lg-12 mt-5 mb-5">
                                <h3>Comentario ({{ count($image->comments) }})</h3>

                                <form action="{{ route('comment.image.save') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="image_id" value="{{$image->id}}">
                                    <textarea name="content" class="form-control mt-2 mb-2{{ $errors->has('content') ? ' is-invalid' : '' }}"></textarea>

                                    @if ($errors->has('content'))
                                    <span class="invalid-feedback mb-2" role="alert">
                                        <strong>{{ $errors->first('content') }}</strong>
                                    </span>
                                    @endif

                                    <button type="submit" class="btn btn-success">Comentar</button>
                                </form>


                            </div>


                        </div>
                        <div class="col-lg-5 detail-comments">

                            @foreach($image->comments as $item)
                            <div class="col-lg-12">
                                <div class="img-description">
                                    <span class="nickname">{{'@'.$item->user->nick}}</span>
                                    <span class="nickname datetime">{{'| '.FormatTime::LongTimeFilter($item->created_at) }}</span>

                                    <p class="m-0">
                                    {{ $item->content }}
                                    </p>
                                    @if(Auth::user() &&  ($item->user_id == Auth::user()->id || $item->image->user_id == Auth::user()->id))
                                        <a href="{{ route('comment.image.delete', ['id' => $item->id]) }}" class="btn btn-sm btn-danger p-1">Eliminar</a>
                                    @endif
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection