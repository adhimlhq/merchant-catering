<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // Menampilkan daftar menu
    public function index()
    {
        // Ambil menu berdasarkan merchant yang terkait dengan pengguna saat ini
        $menus = Menu::where('merchant_id', Auth::user()->merchant_id)->get();
        return view('menus.index', compact('menus'));
    }

    // Menampilkan form untuk membuat menu baru
    public function create()
    {
        return view('menus.create');
    }

    // Menyimpan menu baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $menu = new Menu();
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->merchant_id = Auth::user()->merchant_id;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('menus', 'public');
            $menu->photo = $photoPath;
        }

        $menu->save();

        return redirect()->route('menus.index')->with('success', 'Menu created successfully.');
    }

    // Menampilkan detail menu
    public function show(Menu $menu)
    {
        $this->authorizeMenu(Auth::user(), $menu);
        return view('menus.show', compact('menu'));
    }

    // Menampilkan form untuk mengedit menu
    public function edit(Menu $menu)
    {
        $this->authorizeMenu(Auth::user(), $menu);
        return view('menus.edit', compact('menu'));
    }

    // Mengupdate menu di database
    public function update(Request $request, Menu $menu)
    {
        $this->authorizeMenu(Auth::user(), $menu);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;

        if ($request->hasFile('photo')) {
            // Hapus foto lama jika ada
            if ($menu->photo && Storage::disk('public')->exists($menu->photo)) {
                Storage::disk('public')->delete($menu->photo);
            }
            $photoPath = $request->file('photo')->store('menus', 'public');
            $menu->photo = $photoPath;
        }

        $menu->save();

        return redirect()->route('menus.index')->with('success', 'Menu updated successfully.');
    }

    // Menghapus menu dari database
    public function destroy(Menu $menu)
    {
        $this->authorizeMenu(Auth::user(), $menu);

        // Hapus foto jika ada
        if ($menu->photo && Storage::disk('public')->exists($menu->photo)) {
            Storage::disk('public')->delete($menu->photo);
        }

        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully.');
    }

    // Fungsi untuk mengotorisasi pengguna
    private function authorizeMenu($user, $menu)
    {
        if ($user->merchant_id !== $menu->merchant_id) {
            abort(403, 'Unauthorized action.');
        }
    }
}
