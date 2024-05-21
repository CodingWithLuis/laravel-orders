<form wire:submit="save">
    @csrf

    {{-- Order Products --}}
    <table class="table table-bordered table-striped">
        <thead>
            <th>
                Producto
            </th>
            <th>
                Cantidad
            </th>
            <th>SubTotal</th>
            <th></th>
        </thead>
        <tbody>
            @forelse($orderProducts as $index => $orderProduct)
                <tr>
                    <td>
                        @if ($orderProduct['is_saved'])
                            <input type="hidden" name="orderProducts[{{ $index }}][product_id]"
                                wire:model="orderProducts.{{ $index }}.product_id" />
                            @if ($orderProduct['product_name'] && $orderProduct['product_price'])
                                {{ $orderProduct['product_name'] }}
                                (${{ number_format($orderProduct['product_price'], 2) }})
                            @endif
                        @else
                            <select name="orderProducts[{{ $index }}][product_id]"
                                class="form-select {{ $errors->has('$orderProducts.' . $index) ? 'border border-danger' : 'border border-primary' }} "
                                wire:model="orderProducts.{{ $index }}.product_id">
                                <option value="">Seleccione un producto</option>
                                @foreach ($this->allProducts as $product)
                                    <option value="{{ $product->id }}">
                                        {{ $product->name }}
                                        (${{ number_format($product->price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('orderProducts.' . $index)
                                <em class="text-danger">
                                    {{ $message }}
                                </em>
                            @enderror
                        @endif
                    </td>
                    <td>
                        @if ($orderProduct['is_saved'])
                            <input type="hidden" name="orderProducts[{{ $index }}][quantity]"
                                wire:model="orderProducts.{{ $index }}.quantity" />
                            {{ $orderProduct['quantity'] }}
                        @else
                            <input type="number" step="1" name="orderProducts[{{ $index }}][quantity]"
                                class="form-control" wire:model="orderProducts.{{ $index }}.quantity" />
                        @endif
                    </td>
                    <td>
                        <span>{{ number_format($orderProducts[$index]['quantity'] * $orderProducts[$index]['product_price'], 2) }}</span>
                    </td>
                    <td>
                        @if ($orderProduct['is_saved'])
                            <button wire:click.prevent="editProduct({{ $index }})" class="btn btn-primary">
                                Editar
                            </button>
                        @elseif($orderProduct['product_id'])
                            <button wire:click.prevent="saveProduct({{ $index }})" class="btn btn-success">
                                Guardar
                            </button>
                        @endif
                        <button class="btn btn-danger" wire:click.prevent="removeProduct({{ $index }})">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="px-6 py-4 text-sm leading-5 text-gray-900 whitespace-no-wrap">
                        Agregue productos a su venta
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-3">
        <button wire:click.prevent="addProduct" class="btn btn-primary">Agregar producto</button>
    </div>
    {{-- End Order Products --}}

    <div class="flex justify-end mt-3">
        <table>
            <tr>
                <th class="text-left p-2">Subtotal</th>
                <td class="p-2">${{ number_format($sale->subtotal, 2) }}</td>
            </tr>
            <tr class="text-left border-t border-gray-300">
                <th class="p-2">Impuestos ({{ $taxesPercent }}%)</th>
                <td class="p-2">
                    ${{ number_format($sale->taxes, 2) }}
                </td>
            </tr>
            <tr class="text-left border-t border-gray-300">
                <th class="p-2">Total</th>
                <td class="p-2">${{ number_format($sale->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-danger">
            Guardar venta
        </button>
    </div>
</form>
