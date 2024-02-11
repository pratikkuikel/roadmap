<div>
    <x-header title="Roadmap" separator progress-indicator>
    </x-header>
    <x-tabs selected="users-tab">
        <x-tab name="users-tab" label="Users" icon="o-users">
            @php
                $users = App\Models\User::take(10)->get();
            @endphp

            @foreach ($users as $user)
                <x-item :data="$user" />
            @endforeach
        </x-tab>
        <x-tab name="tricks-tab" label="Tricks" icon="o-sparkles">
            <div>Tricks</div>
        </x-tab>
        <x-tab name="musics-tab" label="Musics" icon="o-musical-note">
            <div>Musics</div>
        </x-tab>
    </x-tabs>
</div>
