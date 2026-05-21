<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Profile::whereIn('role', ['owner', 'kasir', 'inactive']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'ilike', "%{$search}%")
                  ->orWhere('email', 'ilike', "%{$search}%")
                  ->orWhere('phone', 'ilike', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $staffs = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.staff.index', compact('staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:profiles,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:kasir,owner,inactive',
        ]);

        $supabaseUrl = config('services.supabase.url', env('SUPABASE_URL'));
        $supabaseKey = config('services.supabase.key', env('SUPABASE_KEY'));

        // Gunakan endpoint signup untuk membuat user (karena backend request, session admin aman)
        $response = Http::withHeaders([
            'apikey' => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
        ])->post("{$supabaseUrl}/auth/v1/signup", [
            'email' => $request->email,
            'password' => $request->password,
            'data' => [
                'full_name' => $request->full_name,
                'role' => $request->role,
            ]
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Failed to create user: ' . $response->json('msg', 'Unknown error'));
        }

        return redirect()->route('admin.staff.index')->with('success', 'New staff added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:kasir,owner,inactive',
        ]);

        $profile = Profile::findOrFail($id);
        
        // Pemilik tidak bisa mengubah rolenya sendiri menjadi inactive (untuk keamanan minimal 1 owner)
        if ($profile->id === auth()->id() && $request->role !== 'owner') {
            return back()->with('error', 'You cannot change your own role.');
        }

        $profile->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff data updated successfully.');
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);

        if ($profile->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        try {
            // Hard delete dari auth.users (otomatis cascade ke profiles)
            DB::statement('DELETE FROM auth.users WHERE id = ?', [$id]);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete user: ' . $e->getMessage());
        }

        return redirect()->route('admin.staff.index')->with('success', 'Staff deleted successfully.');
    }
}
