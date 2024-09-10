<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;

        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'merchant':
                return redirect()->route('merchant.dashboard');
            case 'customer':
                return redirect()->route('customer.dashboard');
            default:
                abort(403, 'Unauthorized action.');
        }
    }

    public function adminDashboard()  {
        return view('dashboard.admin');
    }

    public function merchantDashboard()  {
        return view('dashboard.merchant');
    }

    public function customerDashboard()  {
        return view('dashboard.customer');
    }

    public function adminDestroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = [
            'message' => 'Admin Logout Successfully',
            'alert-type' => 'warning',
        ];
        return redirect('/logout')->with($notification);
    }

    public function adminLogoutPage()
    {
        return view('auth.login');
    }
}
