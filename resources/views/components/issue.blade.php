<div class="pb-1 flex">
    <div class="flex flex-col justify-between">
        @auth
            @if (auth()->user()->hasVoted($data->id) == 0)
                <x-button icon="o-chevron-up" wire:click="upvote('{{ $data->id }}')" tooltip="upvote"
                    class="btn-circle btn-sm mb-1" />
                <x-button icon="o-fire" wire:click="fire('{{ $data->id }}')" tooltip="hot🔥"
                    class="btn-circle btn-sm mb-1" />
                <x-button icon="o-chevron-down" wire:click="downvote('{{ $data->id }}')" tooltip="downvote"
                    class="btn-circle btn-sm mb-1" />
            @else
                <div class="flex flex-col">
                    <span class="transform rotate-90 origin-left">V</span>
                    <span class="transform rotate-90 origin-left">O</span>
                    <span class="transform rotate-90 origin-left">T</span>
                    <span class="transform rotate-90 origin-left">E</span>
                    <span class="transform rotate-90 origin-left">D</span>
                </div>
            @endif
        @endauth
    </div>
    <div class="flex-grow
                flex-row">
        <x-card title="{{ $data->title }}" shadow class="flex flex-col">
            @foreach ($data->tags as $tag)
                <x-button label="{{ $tag->label }}" class="btn-sm" style="background-color: {{ $tag->color }};" />
            @endforeach
            <div class="pt-1 pb-1 flex-grow">
                {!! Str::limit($data->description, 200) !!}
            </div>
            @if ($data->target_date)
                <div class="pt-1">
                    <x-button label="Target Date : {{ $data->target_date }}" class="btn-sm" />
                </div>
            @endif
        </x-card>
    </div>
    <div class="flex flex-col justify-between">
        <x-button tooltip="votes" label="{{ $data->votes->count() }}+" class="btn-circle btn-sm mb-1" />
        <x-button icon="o-chat-bubble-left-right" link="{{ route('comments', $data->id) }}" tooltip="comments"
            class="btn-circle btn-sm mb-1" />
        <x-button icon="o-clipboard-document-list" wire:click="showTimeline('{{ $data->id }}')" tooltip="Timeline"
            class="btn-circle btn-sm mb-1" />
    </div>
</div>
