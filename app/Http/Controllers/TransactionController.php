<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    // Menampilkan daftar transaksi
    public function index(Request $request)
    {
        $transactions = Transaction::with(['customer', 'product'])
            ->when($request->search, function ($query, $search) {
                $query->where('transaction_code', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('transaction.index', compact('transactions'));
    }

    // Menampilkan form tambah transaksi
    public function create()
    {
        $customers = Customer::orderBy('name')->get();

        $products = Product::where('stock', '>', 0)
            ->with('category')
            ->orderBy('name')
            ->get();

        return view('transaction.create', compact(
            'customers',
            'products'
        ));
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_code' => 'required|string|max:255|unique:transactions,transaction_code',
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:Tunai,Transfer,QRIS,E-Wallet',
            'transaction_date' => 'required|date',
            'status' => 'required|in:completed,pending,cancelled',
        ]);

        DB::transaction(function () use ($validated) {

            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($validated['status'] == 'completed') {
                if ($product->stock < $validated['quantity']) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'quantity' => 'Stok produk tidak mencukupi.',
                    ]);
                }

                $product->decrement('stock', $validated['quantity']);
            }

            $price = $product->selling_price;
            $total = $price * $validated['quantity'];

            Transaction::create([
                'transaction_code' => $validated['transaction_code'],
                'customer_id' => $validated['customer_id'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'price' => $price,
                'total_price' => $total,
                'payment_method' => $validated['payment_method'],
                'transaction_date' => $validated['transaction_date'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // Menampilkan form edit transaksi
    public function edit(Transaction $transaction)
    {
        $customers = Customer::orderBy('name')->get();

        $products = Product::where('stock', '>', 0)
            ->orWhere('id', $transaction->product_id)
            ->with('category')
            ->orderBy('name')
            ->get();

        return view('transaction.edit', compact(
            'transaction',
            'customers',
            'products'
        ));
    }

    // Memperbarui transaksi
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'transaction_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('transactions', 'transaction_code')
                    ->ignore($transaction->id),
            ],
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:Tunai,Transfer,QRIS,E-Wallet',
            'transaction_date' => 'required|date',
            'status' => 'required|in:completed,pending,cancelled',
        ]);

        DB::transaction(function () use ($validated, $transaction) {

            $productIds = array_unique([
                $transaction->product_id,
                $validated['product_id'],
            ]);

            sort($productIds);

            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $oldProduct = $products->get($transaction->product_id);
            $newProduct = $products->get($validated['product_id']);

            if (!$newProduct) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'product_id' => 'Produk tidak ditemukan.',
                ]);
            }

            // Kembalikan stok transaksi lama jika sebelumnya selesai
            if ($transaction->status == 'completed') {
                $oldProduct->increment('stock', $transaction->quantity);
            }

            // Periksa dan kurangi stok transaksi baru jika selesai
            if ($validated['status'] == 'completed') {

                $availableStock = $newProduct->fresh()->stock;

                if ($availableStock < $validated['quantity']) {
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'quantity' => 'Stok produk tidak mencukupi.',
                    ]);
                }

                $newProduct->decrement('stock', $validated['quantity']);
            }

            $price = $newProduct->selling_price;

            $transaction->update([
                'transaction_code' => $validated['transaction_code'],
                'customer_id' => $validated['customer_id'],
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'price' => $price,
                'total_price' => $price * $validated['quantity'],
                'payment_method' => $validated['payment_method'],
                'transaction_date' => $validated['transaction_date'],
                'status' => $validated['status'],
            ]);
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui!');
    }

    // Menghapus transaksi
    public function destroy(Transaction $transaction)
    {
        DB::transaction(function () use ($transaction) {

            if ($transaction->status == 'completed') {
                $product = Product::whereKey($transaction->product_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $product->increment('stock', $transaction->quantity);
            }

            $transaction->delete();
        });

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus dan stok diperbarui!');
    }
}
