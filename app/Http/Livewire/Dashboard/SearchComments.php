<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Rating;
use App\Models\Fatura;
use App\Models\Status;
use Livewire\WithPagination;

class SearchComments extends Component
{
    use WithPagination;

    public $initial_date;
    public $final_date;
    public $comments;
    public $statuses;
    public $comment;
    public $search_status;
    public $fill_color;
    
    public function mount()
    {
        $this->statuses = Status::all();

    }


    public function search()
    {
        //dd($this->search_status);

        $this->comments = Rating::with('relFaturas')
        ->join('faturas', 'faturas.rating_id', '=', 'ratings.id')
        ->whereBetween('ratings.data_req', [$this->initial_date, $this->final_date])
        ->whereNotNull('ratings.comentario') 
        ->whereIn('ratings.status_comentario_id', $this->search_status)->get();


        //dd($this->comments);
        
       return view('livewire.dashboard.search-comments', ['comments' => $this->comments, 'statuses' => $this->statuses]);
    }

    public function render()
    {
        return view('livewire.dashboard.search-comments');
    }
}
