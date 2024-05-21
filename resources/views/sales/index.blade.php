@extends('layouts.app')

@section('content')
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="col-12 px-0">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="fs-5 fw-bold mb-1">{{ __('Listado de ventas') }}</h2>

                            <a href="{{ route('sales.create') }}" class="btn btn-secondary mb-3 mt-3">
                                Nueva venta
                            </a>

                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Fecha venta</th>
                                        <th>SubTotal</th>
                                        <th>Impuestos</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sales as $sale)
                                        <tr>
                                            <td>{{ $sale->id }}</td>
                                            <td>{{ $sale->sale_date->format('d M Y') }}</td>
                                            <td>{{ '$' . $sale->subtotal }}</td>
                                            <td>{{ '$' . $sale->taxes }}</td>
                                            <td>{{ '$' . $sale->total }}</td>
                                            <td>
                                                <a href="{{ route('sale-details.show', $sale->id) }}"
                                                    class="btn btn-primary">Ver detalles</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">
                                                No se encontraron datos
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
