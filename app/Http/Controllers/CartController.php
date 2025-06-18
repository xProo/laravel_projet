<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Afficher le panier
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $products = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
            }
        }

        return view('cart.index', compact('products', 'total'));
    }

    /**
     * Ajouter un produit au panier
     */
    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $product = Product::findOrFail($productId);
        
        // Vérifier le stock
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stock insuffisant pour ce produit.');
        }

        $cart = session()->get('cart', []);
        
        // Si le produit existe déjà, ajouter la quantité
        if (isset($cart[$productId])) {
            $cart[$productId] += $request->quantity;
        } else {
            $cart[$productId] = $request->quantity;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produit ajouté au panier !');
    }

    /**
     * Mettre à jour la quantité d'un produit
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:10'
        ]);

        $product = Product::findOrFail($productId);
        
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stock insuffisant pour ce produit.');
        }

        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId] = $request->quantity;
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Quantité mise à jour !');
    }

    /**
     * Supprimer un produit du panier
     */
    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produit retiré du panier !');
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Panier vidé !');
    }
}
