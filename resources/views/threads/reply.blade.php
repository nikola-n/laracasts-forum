<div class="card">
    <div class="card-body">
        <div class="card-header">
            <a href="#">
                {{ $reply->owner->name }}
            </a> said {{ $reply->created_at->diffForHumans() }}...

        </div>
        {{ $reply->body }}
    </div>
</div>
