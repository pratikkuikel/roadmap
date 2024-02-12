<div>
    <x-header title="We need your feedbacks and suggestions !" separator progress-indicator>
    </x-header>
    <x-card title="ISSUE : {{ $issue->title }}" shadow separator>
        <div>
            {!! $issue->description !!}
        </div>
        @foreach ($issue->comments as $comment)
            <div class="rounded-lg shadow-md p-4">
                <div class="flex flex-col">
                    <div class="flex mr-2">
                        {{ $comment->user->name }}
                    </div>
                    <div class="flex text-sm">
                        {{ $comment->content }}
                    </div>
                </div>
            </div>
        @endforeach
    </x-card>
    @auth
        <x-form wire:submit="save_comment">
            <x-textarea label="Comment" wire:model="new_comment" rows="3" hint="Max 500 chars" />
            <x-slot:actions>
                <x-button label="Comment" class="btn-primary" type="submit" spinner="save" />
            </x-slot:actions>
        </x-form>
    @endauth
</div>
