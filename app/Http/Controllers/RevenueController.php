<?php

namespace FitHabit\Http\Controllers;

use Illuminate\Http\Request;

class RevenueController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function revenueIndex()
    {
        $chartjs = app()->chartjs
            ->name('ClientChart')
            ->type('line')
            ->element('lineChartTest')
            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'])
            ->datasets([
                [
                    "label" => "Revenue",
                    'backgroundColor' => "rgba(248, 121, 121, 1.0)",
                    'borderColor' => "rgba(248, 121, 121, 1.0)",
                    "pointBorderColor" => "rgba(248, 121, 121, 1.0)",
                    "pointBackgroundColor" => "rgba(248, 121, 121, 1.0)",
                    "pointHoverBackgroundColor" => "#f87979",
                    "pointHoverBorderColor" => "rgba(255,0,0,1)",
                 //   'data' => [0, 0, 0, 0, 0, 0, 0],
                ]
            ])
            ->options([]);
        return view('revenue', compact('chartjs'));
    }
}
