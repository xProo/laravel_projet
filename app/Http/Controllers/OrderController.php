<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Afficher le formulaire de checkout
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $products = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
            }
        }

        return view('orders.checkout', compact('products', 'total'));
    }

    /**
     * Traiter la commande et rediriger vers le paiement
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|min:10',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // Vérifier le stock de tous les produits
        foreach ($cart as $productId => $quantity) {
            $product = \App\Models\Product::find($productId);
            if (!$product || $product->stock < $quantity) {
                return back()->with('error', 'Stock insuffisant pour ' . $product->name);
            }
        }

        try {
            DB::beginTransaction();

            // Calculer le total
            $total = 0;
            foreach ($cart as $productId => $quantity) {
                $product = \App\Models\Product::find($productId);
                $total += $product->price * $quantity;
            }

            // Créer la commande
            $order = Order::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'status' => 'pending',
                'address' => $request->address . ', ' . $request->city . ' ' . $request->postal_code . ' - Tél: ' . $request->phone,
            ]);

            // Créer les éléments de commande et mettre à jour le stock
            foreach ($cart as $productId => $quantity) {
                $product = \App\Models\Product::find($productId);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

                // Mettre à jour le stock
                $product->decrement('stock', $quantity);
            }

            // Vider le panier
            session()->forget('cart');

            DB::commit();

            // Rediriger vers le paiement avec un message de succès
            return redirect()->route('payments.show', $order)
                ->with('success', 'Commande #' . $order->id . ' créée avec succès ! Veuillez maintenant procéder au paiement pour finaliser votre commande.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création de la commande. Veuillez réessayer.');
        }
    }

    /**
     * Afficher une commande
     */
    public function show(Order $order)
    {
        // Vérifier que l'utilisateur peut voir cette commande
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Afficher l'historique des commandes
     */
    public function index()
    {
        $orders = auth()->user()->orders()->with('orderItems.product')->orderBy('created_at', 'desc')->paginate(10);
        return view('orders.index', compact('orders'));
    }
}
