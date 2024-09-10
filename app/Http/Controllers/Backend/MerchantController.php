<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class MerchantController extends Controller
{
    // Menampilkan daftar merchant yang dibuat oleh user yang sedang login
    public function index()
    {
        $merchants = Merchant::where('user_id', Auth::id())->get();
        return view('backend.merchant.index', compact('merchants'));
    }

    public function create()
    {
        return view('backend.merchant.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        Merchant::create([
            'user_id' => Auth::id(),
            'company_name' => $request->company_name,
            'address' => $request->address,
            'contact' => $request->contact,
            'description' => $request->description,
        ]);

        return redirect()->route('merchant.index')->with('success', 'Merchant berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit merchant
    public function edit(Merchant $merchant)
    {
        $this->authorizeMerchant($merchant);
        return view('merchant.edit', compact('merchant'));
    }

    // Mengupdate merchant
    public function update(Request $request, Merchant $merchant)
    {
        $this->authorizeMerchant($merchant);

        $request->validate([
            'company_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        $merchant->update($request->only(['company_name', 'address', 'contact', 'description']));

        return redirect()->route('merchant.index')->with('success', 'Merchant berhasil diperbarui.');
    }

    // Menghapus merchant
    public function destroy(Merchant $merchant)
    {
        $this->authorizeMerchant($merchant);
        $merchant->delete();

        return redirect()->route('merchant.index')->with('success', 'Merchant berhasil dihapus.');
    }

    // Metode untuk memastikan hanya pemilik merchant yang bisa mengakses
    private function authorizeMerchant(Merchant $merchant)
    {
        if ($merchant->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
