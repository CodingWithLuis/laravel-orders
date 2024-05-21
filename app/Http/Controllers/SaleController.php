<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SaleController extends Controller
{
    public function index(): View|Factory
    {
        $sales = Sale::query()->select('id', 'sale_date', 'total', 'subtotal', 'taxes')->orderBy('id', 'desc')->get();

        return view('sales.index', compact('sales'));
    }

    public function create(): View|Factory
    {
        $products = Product::query()->select('id', 'name', 'price')->get();

        return view('sales.create', compact('products'));
    }
}
