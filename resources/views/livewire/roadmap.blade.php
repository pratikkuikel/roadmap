<div>
    <x-header title="We need your feedbacks and suggestions !" separator progress-indicator>
    </x-header>
    <x-drawer wire:model="timelineDrawer" right class="lg:w-1/3">

        @if ($timeline != null)
            @foreach ($timeline as $step)
                <x-timeline-item title="{{ $step->event }}" subtitle="{{ $step->created_at->format('Y-M-d') }}" />
            @endforeach
        @endif

    </x-drawer>
    <x-tabs selected="{{ $selectedTab }}">
        @foreach ($tabs as $tab)
            <x-tab name="{{ $tab->label }}" label="{{ $tab->label }}">
                @foreach ($tab->issues as $issue)
                    <div> <x-issue :data="$issue" /> </div>
                @endforeach
            </x-tab>
        @endforeach
    </x-tabs>
</div>
