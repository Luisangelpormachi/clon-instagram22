@extends('layouts.app')

@section('content')
<div class="container  mt-5">
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
                    <a href="{{ route('user.profile', ['id' => $image->user->id]) }}" class="nombres-pub">
                        {{ $image->user->name.' '.$image->user->lastname}}
                        <span class="nickname">{{'| @'.$image->user->nick}}</span>
                    </a>
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
                                {{--<div class="box-like">
                                    <img src="{{ asset('img/icons/heart-grey.png') }}" alt="">
                                </div>--}}

                                <div class="box-like">

                                    <?php $like_user = false ?>
                                    
                                    @foreach($image->likes as $user)
                                        @if($image->user_id == Auth::user()->id)
                                            <?php $like_user = true ?>
                                        @endif
                                    @endforeach

                                    @if($like_user)
                                        <img src="{{ asset('img/icons/heart-red.png') }}" class="btn-dislike" data-id="{{ $image->id }}" alt="">
                                    @else
                                        <img src="{{ asset('img/icons/heart-grey.png') }}" class="btn-like" data-id="{{ $image->id }}" alt="">
                                    @endif
                                    
                                </div>
                                
                                <div class="count-likes">
                                    ({{count($image->likes)}})
                                </div>

                                @if($image->user_id == Auth::user()->id)
                                    <a  href="{{ route('image.edit',  ['id' => $image->id]) }}" class="btn btn-sm btn-warning">Editar</a>
                                    <a  class="btn btn-sm btn-danger text-white" data-toggle="modal" data-target="#modal-eliminar-img">Eliminar</a>
                                @endif
                                
                                <!-- Modal -->
                                <div class="modal fade" id="modal-eliminar-img" tabindex="-1" role="dialog" aria-labelledby="modalImageDelete" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalImageDelete">¿Esta seguro?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Si Elimina la imagen se borrara permanentamente, y no se podra revertir.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-dismiss="modal">Cancelar</button>
                                        <a href="{{ route('image.delete', ['id' => $image->id]) }}" class="btn btn-danger">Eliminar</a>
                                    </div>
                                    </div>
                                </div>
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