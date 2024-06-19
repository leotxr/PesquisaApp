<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;
use App\Models\Rating;

class DashboardStats extends Component
{
    public $initial_date;
    public $final_date;
    public $description;
    public $today_count;
    public $diff_yesterday;
    public $month_count;
    public $diff_last_month;
    public $month_comments;
    public $satisfaction;

    public function getCountByDate($date)
    {
        return Rating::where('data_req', $date)->count();
    }

    public function getCountByMonth($month, $year)
    {
        return Rating::whereMonth('data_req', $month)->whereYear('data_req', $year)->count();
    }

    public function getWeekDay($subdays)
    {
        $yesterday = now()->subDays($subdays)->format('w');
        if($yesterday != 0) return now()->subDays($subdays)->format('Y-m-d');

        $this->getWeekDay($subdays+1);
    }

    public function getLastDayWithCount(int $sub_days)
    {
        $date = now()->subDays($sub_days)->format('Y-m-d');
        $count = Rating::where('data_req', $date)->count();

        if($count > 0) return $count;
        else
        return $this->getLastDayWithCount($sub_days+1);


    }

    public function calculateDiffDays(): float|int
    {
        $today = $this->getCountByDate(date('Y/m/d'));
        //$yesterday = $this->getWeekDay(1);
        $yesterday_count = $this->getLastDayWithCount(1);

        if ($yesterday_count == 0)
            if ($today > 0) $porcentagem = 100;
            else $porcentagem = 0;
        else $porcentagem = number_format((($today - $yesterday_count) / $yesterday_count) * 100, 2, '.', '');

        return $porcentagem;

    }

    public function calculateDiffMonths()
    {

        $month = $this->getCountByMonth(date('m'), date('Y'));
        $last_month = Rating::whereBetween('data_req', [now()->subMonth(1)->format('Y-m-01'), now()->subMonth(1)->format('Y-m-d')])->count();


        if ($last_month == 0)
            if ($month > 0) $porcentagem = 100; // Caso não haja pesquisas no mês passado, mas haja hoje
            else $porcentagem = 0; // Caso não haja pesquisas em nenhum dos períodos
        else $porcentagem = number_format((($month - $last_month) / $last_month) * 100, 2, '.', '');


        return $porcentagem;

    }

    public function getSatisfaction()
    {
        $ratings = Rating::whereMonth('data_req', date('m'))->whereYear('data_req', date('Y'))->count();
        $great_ratings = Rating::whereMonth('data_req', date('m'))->whereYear('data_req', date('Y'))->where('nota_clinica', '>', 3)->count();

        return number_format(($great_ratings / $ratings) * 100, 2, '.', '');
    }

    public function render()
    {

        $this->today_count = $this->getCountByDate(date('Y/m/d'));
        $this->month_count = $this->getCountByMonth(date('m'), date('Y'));
        $this->diff_last_month = $this->calculateDiffMonths();
        $this->diff_yesterday = $this->calculateDiffDays();
        $this->month_comments = Rating::whereMonth('data_req', date('m'))->whereYear('data_req', date('Y'))->whereNotNull('comentario')->count();
        $this->satisfaction = $this->getSatisfaction();
        return view('livewire.dashboard.dashboard-stats', [
            'today' => $this->today_count,
            'month' => $this->month_count,
            'diff_yesterday' => $this->diff_yesterday,
            'diff_last_month' => $this->diff_last_month,
            'month_comments' => $this->month_comments,
            'satisfaction' => $this->satisfaction]);
    }
}
