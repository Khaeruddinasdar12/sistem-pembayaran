<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\User;
use Auth;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $admin = Admin::where('status', '0')->count();
        $penagih = Admin::where('status', '1')->count();
        $user = User::count();

        return view('admin.dashboard', [
            'admin' => $admin,
            'penagih' => $penagih,
            'user' => $user,
        ]);
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function updateProfile(Request $request)
    {
        $validasi = $this->validate($request, [
            'nama' => 'required'
        ]);

        $auth_id = Auth::guard('admin')->user()->id;
        $data = Admin::findOrFail($auth_id);

        if($request->password != '') {
            $validasi = $this->validate($request, [
                'password'     => 'required|min:8|confirmed',
            ]);

            $data->password = bcrypt($request->password);
            $data->name = $request->nama;
            $data->save();

            auth()->guard('admin')->logout();
            return redirect()->route('admin.login');
        } else {
            $data->name = $request->nama;
            $data->save();

            return redirect()->back()->with('success', 'Berhasil Mengubah Profile');
        }
        
        

        
        
    }
}
