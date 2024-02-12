<?php

namespace App\Livewire;

use App\Models\Issue;
use App\Models\Tab;
use App\Models\Timeline;
use App\Models\Vote;
use Livewire\Component;
use Mary\Traits\Toast;

class Roadmap extends Component
{
    use Toast;

    public $tabs;
    public $issue;
    public $timeline;
    public $selectedTab;
    public bool $timelineDrawer = false;

    public function mount()
    {
        $this->tabs = Tab::with('issues')->get();
        $this->selectedTab = $this->tabs->first()?->label;
    }

    public function showTimeline($issue)
    {
        $this->timeline = Timeline::where('issue_id', $issue)->get();
        $this->timelineDrawer = true;
    }

    public function upvote($issue)
    {
        $issue = Issue::find($issue);
        $issue->upvotes_count = $issue->upvotes_count++;
        $issue->save();
        Vote::create([
            'issue_id' => $issue,
            'user_id' => auth()->user()->id,
            'type' => 'upvote'
        ]);
        $this->success('Thanks for the upvote 😊 !');
    }

    public function downvote($issue)
    {
        $issue = Issue::find($issue);
        $issue->downvotes_count = $issue->downvotes_count++;
        $issue->save();
        Vote::create([
            'issue_id' => $issue,
            'user_id' => auth()->user()->id,
            'type' => 'downvote'
        ]);
        $this->success('Downvote successfull! 🙁');
    }

    public function fire($issue)
    {
        $issue = Issue::find($issue);
        $issue->fire_count = $issue->fire_count++;
        $issue->save();
        Vote::create([
            'issue_id' => $issue,
            'user_id' => auth()->user()->id,
            'type' => 'fire'
        ]);
        $this->success('🔥🔥🔥🔥🔥🔥🔥🔥🔥');
    }

    public function render()
    {
        return view('livewire.roadmap');
    }
}
