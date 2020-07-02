<reply :attributes="{{ $reply }}" inline-template v-cloak>

    <div id="reply-{{$reply->id}}" class="card mb-2">
        <div class="card-body">
            <div class="card-header">
                <div class="level">
                    <h5 class="flex">
                        <a href="{{ route('profile', $reply->owner) }}">
                            {{ $reply->owner->name }}
                        </a> said {{ $reply->created_at->diffForHumans() }}...
                    </h5>
                    <div>
                        <form method="POST" action="/replies/{{$reply->id}}/favorites">
                            @csrf
                            <button type="submit" class="btn btn-danger" {{ $reply->isFavorited() ? 'disabled' :  '' }}>
                                {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count ) }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div v-if="editing">
                    <div class="form-group">
                        <label>
                            <textarea class="form-control" v-model="body"></textarea>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary" @click="update">Update</button>
                    <button class="btn btn-sm btn-link" @click="editing=false">Cancel</button>
                </div>

                <div v-else v-text="body"></div>
            </div>
            @can('update', $reply)
                <div class="card-footer level">
                    <button class="btn btn-sm btn-secondary mr-1" @click="editing=true">Edit</button>

                    <form method="POST" action="/replies/{{ $reply->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-dark btn-sm">Delete Reply</button>
                    </form>
                </div>
            @endcan
        </div>
    </div>
</reply>

