<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\ValidatedInput;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class UserListController extends Controller
{

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $page = $request->input('page', 1);
        $search = $request->input('q');
        $role = $request->input('role');
        $cacheKey = "users_{$page}_{$perPage}_search_" . ($search ?? '') . "_role_" . ($role ?? '');
        $users = Cache::get($cacheKey);
        $users = '';
        if (!$users) {
            // $query = User::query();
            $query = User::with('posts');
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }
            if ($role) {
                $query->where('role', $role);
            }
            $users = $query->paginate($perPage, ['id', 'name', 'email', 'role'], 'page', $page);
            Cache::put($cacheKey, $users, now()->addMinutes(10));
        }
        return response()->json(['data' => $users->items(),
        'meta'=>[
            'current_page' => $users->currentPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
            'last_page' => $users->lastPage(),
        ]]);
        
    
    }
}
