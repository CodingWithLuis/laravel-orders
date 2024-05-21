<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SaleDetailController extends Controller
{
    public function show(Sale $sale): View|Factory
    {
        $sale->load('products');

        return view('sales_details.show', compact('sale'));
    }
}
