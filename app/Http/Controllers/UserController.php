<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\DataTables\UserDataTable;
use Validator;
use PDF;
use Barryvdh\Snappy;

class UserController extends Controller
{
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('user-management.index');
        // /// mengambil data terakhir dan pagination 5 list
        // $user = User::latest()->paginate(5);
         
        // /// mengirimkan variabel $user ke halaman views stasiun/index.blade.php
        // /// include dengan number index
        // return view('user-management.index',compact('user'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    public function create(Request $request)
    {
        $roles = Role::get();
        if ($request->isMethod('post'))
        {
            $valid = Validator::make($request->all(), [
                'name'      => 'required|string',
                'email'      => 'required|email|unique:users',
                'password' => [
                    'required',
                    'string',
                    'min:8'             // must be at least 10 characters in length
                ],
            ]);

            if (!$valid->fails())
            {
                $user = User::create([
                    'name'  => $request->input('name'),
                    'email'  => $request->input('email'),
                    'password'  => bcrypt($request->input('password')),
                    'role_id'  => $request->input('role_id')
                ]);

                if ($user) {
                    return redirect()->route('view_user')->with('success', 'User berhasil dibuat.');
                }
            }
            return redirect()->route('create_user')->withErrors($valid)->withInput();
        }
        /// menampilkan halaman create
        return view('user-management.create', compact('roles'));
    }
  
    public function show($id)
    {
        /// dengan menggunakan resource, kita bisa memanfaatkan model sebagai parameter
        /// berdasarkan id yang dipilih
        $user = User::find($id);
        return view('user-management.show',compact('user'));
    }
  
   /**
     * Get  User's detail and form change password
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function view($id, Request $request)
    {
        $roles = Role::get();
         $user = User::find($id);
        if (!empty($user))
        {
            if ($request->isMethod('post'))
            {
                $valid = Validator::make($request->all(), [
                    'name'      => 'required|string',
                    'email'      => 'required|string'
                ]);

                if (!$valid->fails()) { 

                    $user->name = $request->input('name');
                    $user->email = $request->input('email');
                    $user->role_id = $request->input('role_id');
                    $status = $user->save();

                    if ($status) {
                        return redirect()->route('view_user')->with('success', 'User berhasil diubah.');
                    }

                }
                return redirect()->route('view_detail_user', ['id' => $id])->withErrors($valid)->withInput();
            }

            return view('user-management.view', compact('user','roles'));
        }
        return redirect()->route('view_user')->with('error', 'User tidak ditemukan');
    }

  
    public function destroy($id)
    {
        /// melakukan hapus data berdasarkan parameter yang dikirimkan
        $user = User::find($id);
        $user->delete();
  
        return redirect()->route('user-management.index')
                        ->with('success','user deleted successfully');
    }

        /**
     * Ajax for delete the User
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function ajaxDeleteUser(Request $request)
    {
        if ($request->ajax()):
            if (!empty($request->input('id'))) {
                $user = User::find($request->input('id'));

                if ($user) {
                        $status = $user->delete();

                        if ($status) {
                            return response()->json(['success' => true, 'description' => 'data telah dihapus dengan sukses.', 'data' => null]);
                        }

                        return response()->json(['success' => false, 'description' => 'Gagal menghapus data.', 'data' => null]);
                }
                return response()->json(['success' => false, 'description' => 'data tidak dapat ditemukan', 'data' => null]);
            }

            return response()->json([
                'success' => false,
                'description' => 'Mohon sertakan ID pengguna',
                'data' => null
            ]);
        else:
            return redirect()->route('dashboard')->with('error', 'Anda dilarang mengakses halaman ini.');
        endif;
    }
}
