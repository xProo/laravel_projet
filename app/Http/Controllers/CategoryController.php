<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->paginate(10);
        
        // Si on est dans l'admin, utiliser la vue admin
        if (request()->routeIs('admin.*')) {
            return view('admin.categories.index', compact('categories'));
        }
        
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Si on est dans l'admin, utiliser la vue admin
        if (request()->routeIs('admin.*')) {
            return view('admin.categories.create');
        }
        
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = $imagePath;
        }

        Category::create($data);

        // Rediriger vers la bonne route selon le contexte
        if (request()->routeIs('admin.*')) {
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès !');
        }

        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $products = $category->products()->paginate(12);
        return view('categories.show', compact('category', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Si on est dans l'admin, utiliser la vue admin
        if (request()->routeIs('admin.*')) {
            return view('admin.categories.edit', compact('category'));
        }
        
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = $imagePath;
        }

        $category->update($data);

        // Rediriger vers la bonne route selon le contexte
        if (request()->routeIs('admin.*')) {
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès !');
        }

        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            $errorMessage = 'Impossible de supprimer une catégorie qui contient des produits !';
            
            if (request()->routeIs('admin.*')) {
                return redirect()->route('admin.categories.index')->with('error', $errorMessage);
            }
            
            return redirect()->route('categories.index')->with('error', $errorMessage);
        }

        $category->delete();
        
        // Rediriger vers la bonne route selon le contexte
        if (request()->routeIs('admin.*')) {
            return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès !');
        }

        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès !');
    }
}
