@extends('layouts.app')

@section('content')
    <div class="main py-4">
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="col-12 px-0">
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <h2 class="fs-5 fw-bold mb-1">{{ __('Editar producto') }}</h2>

                            <form action="{{ route('products.update', $product->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="row align-items-center mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label for="name">{{ 'Producto' }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-box fa-fw"></i>
                                            </span>
                                            <input id="name" class="form-control" type="text" name="name"
                                                placeholder="{{ __('Producto') }}" value="{{ old('name', $product->name) }}"
                                                required>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="price">{{ __('Precio') }}</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-money-bill fa-fw"></i>
                                            </span>
                                            <input type="price" name="price" class="form-control"
                                                placeholder="{{ __('Precio') }}" id="price"
                                                value="{{ old('price', $product->price) }}" required>
                                        </div>
                                        @error('price')
                                            <div class="invalid-feedback"> {{ $message }} </div>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Editar</button>
                                <a href="{{ route('products.index') }}" class="btn btn-danger">Regresar al listado</a>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
