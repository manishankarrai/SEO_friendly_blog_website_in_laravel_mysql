<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
    public function getPage()
    {
        return view('admin.resetPassword');
    }

    public function reset(Request $request)
    {
        $newP = $request->new_pass;
        $cryptedP = bcrypt($newP);
        $userId = Auth::id();
        $user = DB::table('users')->where('id', $userId)->update([
            'password' => $cryptedP,
        ]);

        return redirect('/admin/resetPassword')->with('success', 'Password changed successfully!');
    }
}
