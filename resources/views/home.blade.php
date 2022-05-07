@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes/message')

            @foreach($images as $item)
                @include('includes/image')
            @endforeach

        </div>
        <div class="paginate">
            {{ $images->links() }}
        </div>
    </div>
</div>
@endsection