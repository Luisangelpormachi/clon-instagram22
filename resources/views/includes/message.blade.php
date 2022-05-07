@if(session('message'))
<div class="alert alert-success">
    {{session('message')}}
</div>
@endif

@if(session('message-error'))
<div class="alert alert-danger">
    {{session('message-error')}}
</div>
@endif