<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $pastRecords = array();

        for ($i = 0; $i < 7; $i++) {
            $records = Order::pastDay($i);

            array_push($pastRecords, $records);
        }

        return view('home-page')
            ->with('records', $pastRecords);
    }

    public function generateReport()
    {
        $records = Order::query();

        if ($records->count() === 0) {
           return back()->with('message', 'No sales yet, cannot generate a report.'); 
        }

        $start = request()->query('start');
        $end = request()->query('end');

        if ($start) {
            $records = $records->where('created_at', '>=', $start);
        }

        if ($end) {
            $records = $records->where('created_at', '<=', $end);
        }

        $records = $records->get();

        return view('report')
            ->with('orders', $records);
    }
}
