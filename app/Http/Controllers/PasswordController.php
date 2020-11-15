<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function($request, $next) {
            if (Gate::allows('author-access')) return $next($request);
            abort(403);
        });
    }

    public function changePassword(Request $request)
    {
        return view('password', [
            'user' => $request->user()
        ]);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'current_password'      => 'required',
            'password'              => 'required',
            'password_confirmation' => 'required|same:password'
        ]);

        $plainPassword = $request->get('current_password');

        if (Hash::check($plainPassword, $user->password) == true) {
            $user->password = bcrypt(request('password'));
            $user->save();

            return redirect()->back()->with('success','Password updated successfully.');
        }

        return redirect()->back()->with('error','Old Password Wrong!');

    }
}
