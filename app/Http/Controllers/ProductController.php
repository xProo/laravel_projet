<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->paginate(12);
        
        // Si on est dans l'admin, utiliser la vue admin
        if (request()->routeIs('admin.*')) {
            return view('admin.products.index', compact('products'));
        }
        
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        
        // Si on est dans l'admin, utiliser la vue admin
        if (request()->routeIs('admin.*')) {
            return view('admin.products.create', compact('categories'));
        }
        
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        Product::create($data);

        // Rediriger vers la bonne route selon le contexte
        if (request()->routeIs('admin.*')) {
            return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès !');
        }

        return redirect()->route('products.index')->with('success', 'Produit créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        
        // Si on est dans l'admin, utiliser la vue admin
        if (request()->routeIs('admin.*')) {
            return view('admin.products.edit', compact('product', 'categories'));
        }
        
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        $product->update($data);

        // Rediriger vers la bonne route selon le contexte
        if (request()->routeIs('admin.*')) {
            return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès !');
        }

        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        
        // Rediriger vers la bonne route selon le contexte
        if (request()->routeIs('admin.*')) {
            return redirect()->route('admin.products.index')->with('success', 'Produit supprimé avec succès !');
        }

        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès !');
    }
}
