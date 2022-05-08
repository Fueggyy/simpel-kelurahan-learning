<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;
use Validator;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

        /**
     * Handles password resets
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function changePassword(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $valid = Validator::make($request->all(), [
                'current_password' => 'required|string',
                // 'new_password' => 'required|unique:bad_passwords,bad_password|string|confirmed',
                'new_password' => [
                    'required',
                    'string',
                    'min:8',             // must be at least 10 characters in length
                    'regex:/[a-z]/',      // must contain at least one lowercase letter
                    'regex:/[A-Z]/',      // must contain at least one uppercase letter
                    'regex:/[0-9]/',      // must contain at least one digit
                    'regex:/[@$!%*#?&]/', // must contain a special character
                ],
                'new_password_confirmation' => 'required'
            ], [
                'new_password.unique' => 'Please choose stronger password'
            ]);

            if (!$valid->fails())
            {
                $user = User::find(Auth::user()->id);

                if (strtolower($request->input('current_password')) !== strtolower($request->input('new_password'))) {
                    if (Hash::check($request->input('current_password'), $user->password)) {
                        $user->password = bcrypt($request->input('new_password'));
                        // $user->changed_password = true;

                        $status = $user->save();
                        if ($status) return redirect()->route('home')->with('success', 'Kata sandi telah berhasil diubah.');

                        return redirect()->route('changePasswordProfile')->with('error', 'Gagal saat mengubah kata sandi anda.');
                    } else {
                        return redirect()->route('changePasswordProfile')->with('error', 'Kata sandi saat ini salah.');
                    }
                } else {
                    return redirect()->route('changePasswordProfile')->with('error', 'Anda tidak dapat menggunakan kata sandi yang sama');
                }
            } else {
                return redirect()->route('changePasswordProfile')->withErrors($valid);
            }
        }

        return view('profile.change-password');
    }
}
