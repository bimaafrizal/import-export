<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role_id == 1) {
            $blog = Blog::where('user_id', auth()->id())->count();
        } else {
            $blog = Blog::with('user')->whereHas('user', function ($query) {
                $query->where('active', 1);
            })->count();
        }
        $data = [
            'blog' => $blog,
            'blog_category' => BlogCategory::count(),
            'admin' => User::count(),
            'product' => Product::count(),
            'team' => Team::count(),
        ];

        $notifications = Notification::where('type', 'email')->orderBy('created_at', 'desc')->limit(10)->get();
        return view('dashboard.views.index', [
            'data' => $data,
            'notifications' => $notifications,
        ]);
    }
}
