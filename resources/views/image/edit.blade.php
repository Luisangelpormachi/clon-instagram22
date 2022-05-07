@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @include('includes/message')

            <div class="card">
                <div class="card-header">Editar imagen</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('image.update') }}" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="image_id" value="{{ $image->id }}">

                        <div class="form-group row">
                            <label for="image_path" class="col-md-3 col-form-label text-md-right">Imagen</label>
                            
                            <div class="col-md-7">
                                <div class="conf-avatar">
                                    @if($image)
                                        <img src="{{ route('image.file', ['filename' => $image->image_path]) }}" alt="" class="user-avatar">
                                    @endif
                                </div>
                                <input type="file" id="image_path" name="image_path" class="form-control{{ $errors->has('image_path') ? ' is-invalid' : '' }}">
                                @if($errors->has('image_path'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('image_path') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="image_path" class="col-md-3 col-form-label text-md-right">Descripcion</label>
                            <div class="col-md-7">
                                <textarea id="description" name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ $image->description }}</textarea>
 
                                @if($errors->has('description'))
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif

                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-3">
                                <input type="submit"  class="btn btn-primary" value="Actualizar imagen">    
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection