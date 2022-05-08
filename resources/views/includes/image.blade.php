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
        <a href="{{ route('user.profile', [$item->user->id]) }}" class="nombres-pub">
            {{ $item->user->name.' '.$item->user->surname}}
            <span class="nickname">{{'| @'.$item->user->nick}}</span>
        </a>
    </div>

    <div class="card-body">
        <a href="{{ route('image.detail', ['id' => $item->id]) }}" class="img-pub">
            <img src="{{ route('image.file', ['filename' => $item->image_path]) }}" alt="">
        </a>
        <div class="img-description">
            <span class="nickname">{{'@'.$item->user->nick}}</span>
            <span class="nickname datetime">{{'| '.FormatTime::LongTimeFilter($item->created_at) }}</span>
            <p>{{ $item->description }}</p>
        </div>
        <div class="box-like">

            <?php $like_user = false ?>

            @foreach($item->likes as $user)
            @if($user->user_id == Auth::user()->id)
            <?php $like_user = true ?>
            @endif
            @endforeach

            @if($like_user)
            <img src="{{ asset('img/icons/heart-red.png') }}" class="btn-dislike" data-id="{{ $item->id }}" alt="">
            @else
            <img src="{{ asset('img/icons/heart-grey.png') }}" class="btn-like" data-id="{{ $item->id }}" alt="">
            @endif

        </div>
        <div class="count-likes">
            ({{count($item->likes)}})
        </div>
        <div class="box-comment">
            <a href="{{ route('image.detail', [$item->id]) }}" class="btn btn-sm btn-warning">Comentario ({{ count($item->comments) }}) </a>
        </div>
    </div>
</div>