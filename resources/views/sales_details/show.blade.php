@extends('layouts.app')

@section('content')
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="col-12 px-0">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="fs-5 fw-bold mb-1">{{ __('Detalles de la venta') }}</h2>

                            <div class="invoice p-3 mb-3">

                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            <i class="fas fa-globe"></i> Nombre de la Empresa
                                            <small class="float-end">Fecha: {{ $sale->sale_date->format('d/m/Y') }}</small>
                                        </h4>
                                    </div>

                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($sale->products as $product)
                                                    <tr>
                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->pivot->quantity }}</td>
                                                        <td>$ {{ number_format($product->pivot->price, 2) }}</td>
                                                        <td>$
                                                            {{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <div class="col-md-3 mt-4 float-end">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <th style="width:50%">Subtotal:</th>
                                                            <td>$ {{ number_format($sale->subtotal, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Impuestos (13%)</th>
                                                            <td>$ {{ number_format($sale->taxes, 2) }}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Total:</th>
                                                            <td>$ {{ number_format($sale->total, 2) }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
