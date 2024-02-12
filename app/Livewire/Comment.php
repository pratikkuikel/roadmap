<?php

namespace App\Livewire;

use App\Models\Comment as commentModel;
use App\Models\Issue;
use Livewire\Component;
use Mary\Traits\Toast;

class Comment extends Component
{
    use Toast;

    public $issue;
    public $issue_id;
    public $new_comment;

    public function mount($issue_id = null)
    {
        $this->issue = Issue::with('comments')->findOrFail($issue_id);
    }

    public function save_comment()
    {
        if (auth()->check()) {
            $this->validate([
                'new_comment' => 'required|string|max:500',
            ]);

            commentModel::create([
                'content' => $this->new_comment,
                'issue_id' => $this->issue_id
            ]);

            $this->success('Commented Successfully !');
        }
        $this->js('window.location.reload()');
    }

    public function render()
    {
        return view('livewire.comment');
    }
}
