<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class SalesForm extends Component
{
    public Sale $sale;

    public Collection $allProducts;

    public array $orderProducts = [];

    public bool $editing = false;

    public int $taxesPercent = 0;

    public function mount(Sale $sale): void
    {
        $this->sale = $sale;

        if ($this->sale->exists) {
            $this->editing = true;

            foreach ($this->sale->products()->get() as $product) {
                $this->orderProducts[] = [
                    'product_id' => $product->id,
                    'quantity' => $product->pivot->quantity,
                    'product_name' => $product->name,
                    'product_price' => number_format($product->pivot->price / 100, 2),
                    'is_saved' => true,
                ];
            }
        } else {
            $this->editing = false;

            $this->sale->sale_date = today();
        }

        $this->initListsForFields();
        $this->taxesPercent = 13;
    }

    public function render(): View|Factory
    {
        $this->sale->subtotal = 0;

        foreach ($this->orderProducts as $orderProduct) {
            if ($orderProduct['is_saved'] && $orderProduct['product_price'] && $orderProduct['quantity']) {
                $this->sale->subtotal += $orderProduct['product_price'] * $orderProduct['quantity'];
            }
        }

        $this->sale->total = $this->sale->subtotal * (1 + $this->taxesPercent / 100);
        $this->sale->taxes = $this->sale->total - $this->sale->subtotal;

        return view('livewire.sales-form');
    }

    public function addProduct(): void
    {
        foreach ($this->orderProducts as $key => $product) {
            if (!$product['is_saved']) {
                $this->addError('orderProducts.' . $key, 'Debe guardar el producto antes de continuar.');
                return;
            }
        }

        $this->orderProducts[] = [
            'product_id' => '',
            'quantity' => 1,
            'is_saved' => false,
            'product_name' => '',
            'product_price' => 0,
        ];
    }

    public function saveProduct(int $index): void
    {
        $this->resetErrorBag();
        $product = $this->allProducts->find($this->orderProducts[$index]['product_id']);
        $this->orderProducts[$index]['product_name'] = $product->name;
        $this->orderProducts[$index]['product_price'] = $product->price;
        $this->orderProducts[$index]['is_saved'] = true;
    }

    public function editProduct(int $index): void
    {
        foreach ($this->orderProducts as $key => $invoiceProduct) {
            if (!$invoiceProduct['is_saved']) {
                $this->addError('$this->orderProducts.' . $key, 'Debe guardar los datos antes de editarlos.');
                return;
            }
        }

        $this->orderProducts[$index]['is_saved'] = false;
    }

    public function removeProduct(int $index): void
    {
        unset($this->orderProducts[$index]);
        $this->orderProducts = array_values($this->orderProducts);
    }

    public function save()
    {
        $this->validate();

        $this->sale->sale_date = now();

        $this->sale->save();

        $products = [];

        foreach ($this->orderProducts as $product) {
            $products[$product['product_id']] = ['price' => $product['product_price'], 'quantity' => $product['quantity']];
        }

        $this->sale->products()->sync($products);

        return redirect()->route('sales.index');
    }

    /**
     * @return array<string,array<int,string>>
     */
    public function rules(): array
    {
        return [
            'sale.sale_date' => ['required', 'date'],
            'sale.subtotal' => ['required', 'numeric'],
            'sale.taxes' => ['required', 'numeric'],
            'sale.total' => ['required', 'numeric'],
            'orderProducts' => ['array']
        ];
    }

    protected function initListsForFields(): void
    {
        $this->allProducts = Product::all();
    }
}
