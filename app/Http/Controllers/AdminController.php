<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
            'recent_users' => User::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::with('orders')->latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function orders()
    {
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load(['user', 'items.product.category']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Statut de la commande mis à jour avec succès.');
    }

    public function toggleAdminStatus(User $user)
    {
        $user->update(['is_admin' => !$user->is_admin]);
        
        return back()->with('success', 
            $user->is_admin ? 'Utilisateur promu administrateur.' : 'Utilisateur rétrogradé.'
        );
    }
} 