<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Laporan;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function ubahPassword(Request $request)
    {
        $validasi = $this->validate($request, [
            'password'     => 'required|min:8|confirmed',
        ]);

        $auth_id = Auth::user()->id;
        $data = User::findOrFail($auth_id);
        $data->password = bcrypt($request->password);
        $data->save();

        auth()->guard('web')->logout();
        return redirect()->route('login');
    }

    public function email()
    {
        $data = Laporan::with('user')->with('admin')->find(1);
        // return $data;
        return view('email', ['data'=> $data]);
    }
}
