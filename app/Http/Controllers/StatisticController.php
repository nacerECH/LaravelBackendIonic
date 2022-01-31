<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Commande;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends BaseController
{
    public function statistics()
    {
        try {
            $restaurant = auth()->user()->restaurant;

            $monthCommandes = $restaurant->commandes()->where('created_at', '>=', Carbon::now()->subMonth());
            $weekCommandes = $restaurant->commandes()->where('created_at', '>=', Carbon::now()->subWeek());

            $week['totalCommandes'] = $weekCommandes->count();
            $week['totalMoney'] = $weekCommandes->sum('total');
            $week['statistics'] = $weekCommandes
                ->orderBy('date', 'ASC')->groupBy('date')
                ->get(array(
                    DB::raw('Date(created_at) as date'),
                    DB::raw('COUNT(*) as "commandes"'),
                    DB::raw('SUM(total) as "total"')

                ));


            $month['totalCommandes'] = $monthCommandes->count();
            $month['totalMoney'] = $monthCommandes->sum('total');
            $month['statistics'] = $monthCommandes
                ->orderBy('date', 'ASC')->groupBy('date')
                ->get(array(
                    DB::raw('Date(created_at) as date'),
                    DB::raw('COUNT(*) as "commandes"'),
                    DB::raw('SUM(total) as "total"')

                ));

            $statistics['month'] = $month;
            $statistics['week'] = $week;
            $success['statistics'] = $statistics;

            return $this->sendResponse($success, 'Statistics found successfully.');
        } catch (Exception $e) {
            return ($e->getMessage());
        }
    }
}
