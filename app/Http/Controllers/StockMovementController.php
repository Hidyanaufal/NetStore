<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockMovementController extends Controller
{
    public function index()
    {
        $movements = DB::table('stock_movements')
            ->join('products', 'stock_movements.product_id', '=', 'products.id')
            ->leftJoin('users', 'stock_movements.user_id', '=', 'users.id')
            ->select(
                'stock_movements.*',
                'products.name as product_name',
                'products.type as product_type',
                'products.quota as product_quota',
                'users.name as user_name'
            )
            ->latest('stock_movements.created_at')
            ->paginate(10);

        $products = Product::orderBy('name')->get();

        return view('stock-movements.index', compact(
            'movements',
            'products'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'movement_type' => ['required', 'in:in,out'],
            'quantity' => ['required', 'integer', 'min:1'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($validated) {

            $product = Product::where('id', $validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $stockBefore = (int) $product->stock;
            $quantity = (int) $validated['quantity'];

            if ($validated['movement_type'] === 'in') {

                $stockAfter = $stockBefore + $quantity;

            } else {

                if ($quantity > $stockBefore) {
                    throw ValidationException::withMessages([
                        'quantity' => 'Stok tidak mencukupi untuk pengeluaran produk ini.',
                    ]);
                }

                $stockAfter = $stockBefore - $quantity;
            }

            // Update stok produk
            $product->update([
                'stock' => $stockAfter
            ]);

            // Simpan riwayat perubahan stok
            DB::table('stock_movements')->insert([
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'transaction_id' => null,
                'movement_type' => $validated['movement_type'],
                'quantity' => $quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'notes' => $validated['notes'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()
            ->route('stock-movements.index')
            ->with('success', 'Perubahan stok berhasil disimpan.');
    }
}
