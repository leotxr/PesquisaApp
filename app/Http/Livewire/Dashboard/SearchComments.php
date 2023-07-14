<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Rating;
use App\Models\Fatura;
use App\Models\Status;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CommentsExport;

class SearchComments extends Component 
{
    use WithPagination;

    public $initial_date;
    public $final_date;
    public $statuses;
    public $comment;
    public $search_status = [1, 2, 3];
    public $fill_color;
    public Rating $rating;
    public Status $status;
    public $modalComment = false;
    
    public function mount()
    {
        $this->statuses = Status::all();

    }


    public function search()
    {
        /*

        $this->comments = Rating::with('relFaturas')
        ->join('faturas', 'faturas.rating_id', '=', 'ratings.id')
        ->whereBetween('ratings.data_req', [$this->initial_date, $this->final_date])
        ->whereNotNull('ratings.comentario') 
        ->whereIn('ratings.status_comentario_id', $this->search_status)->get();


       
        
       return view('livewire.dashboard.search-comments', ['comments' => $this->comments, 'statuses' => $this->statuses]);
        */
    }

    public function setStatus(Rating $rating, Status $status)
    {
        $this->rating = $rating;
        $this->status = $status;

        $this->rating->status_comentario_id = $this->status->id;
        $this->rating->save();

       
    }

    public function showDetails(Rating $rating)
    {
        $this->modalComment = true;
        $this->rating = $rating;
    }

    public function export() 
    {
        $range = ['initial_date'=>$this->initial_date, 'final_date'=>$this->final_date, 'search_status'=>$this->search_status];
        return Excel::download(new CommentsExport($range), 'comentarios.xlsx');
    }


    public function render()
    {
        return view('livewire.dashboard.search-comments', ['comments' => Rating::with('relFaturas')
        ->join('faturas', 'faturas.rating_id', '=', 'ratings.id')
        ->whereBetween('ratings.data_req', [$this->initial_date, $this->final_date])
        ->whereNotNull('ratings.comentario') 
        ->whereIn('ratings.status_comentario_id', $this->search_status)->get()]);
    }
}
