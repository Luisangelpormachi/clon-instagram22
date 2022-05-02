@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <h2 class="text-center">Me encanta</h2>
            <hr>
            @foreach($likes as $item)
                @include('includes/image', ['item' => $item->image])
            @endforeach

        </div>
        <div class="paginate">
            {{ $likes->links() }}
        </div>
    </div>
</div>
@endsection