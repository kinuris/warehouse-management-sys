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
}
