<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\JenisPelayanan;
use App\Models\DokumenDetail;
use App\DataTables\JenisPelayananDataTable;
use Validator;
use PDF;
use Barryvdh\Snappy;

class JenisPelayananController extends Controller
{
    public function index(JenisPelayananDataTable $dataTable)
    {
        return $dataTable->render('jenis-pelayanan.index');
        // /// mengambil data terakhir dan pagination 5 list
        // $JenisPelayanann = JenisPelayanan::latest()->paginate(5);
         
        // /// mengirimkan variabel $JenisPelayanann ke halaman views JenisPelayanan/index.blade.php
        // /// include dengan number index
        // return view('jenis-pelayanan.index',compact('JenisPelayanan'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    public function create(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $valid = Validator::make($request->all(), [
                'code'      => 'required|string',
                'name'      => 'required|string'
            ]);

            if (!$valid->fails())
            {
                $JenisPelayanan = JenisPelayanan::create([
                    'code'  => $request->input('code'),
                    'name'  => $request->input('name'),
                    'status'  => 1
                ]);

                if ($JenisPelayanan) {
                    return redirect()->route('view_jenis_pelayanan')->with('success', 'Jenis Pelayanan berhasil dibuat.');
                }
            }
            return redirect()->route('create_jenis_pelayanan')->withErrors($valid)->withInput();
        }
        /// menampilkan halaman create
        return view('jenis-pelayanan.create');
    }
  
    public function store(Request $request)
    {
        /// membuat validasi untuk title dan content wajib diisi
        $request->validate([
            'name' => 'required'
        ]);
         
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        JenisPelayanan::create($request->all());
         
        /// redirect jika sukses menyimpan data
        return redirect()->route('jenis-pelayanan.index')->with('success','JenisPelayanan created successfully.');
    }
  
    public function show($id)
    {
        /// dengan menggunakan resource, kita bisa memanfaatkan model sebagai parameter
        /// berdasarkan id yang dipilih
        $JenisPelayanann = JenisPelayanan::find($id);
        return view('jenis-pelayanan.show',compact('JenisPelayanan'));
    }
  
    public function edit($id)
    {
        /// dengan menggunakan resource, kita bisa memanfaatkan model sebagai parameter
        /// berdasarkan id yang dipilih
        $JenisPelayanann = JenisPelayanan::find($id);
        return view('jenis-pelayanan.edit',compact('JenisPelayanan'));
    }
  
    public function update(Request $request, $id)
    {
        /// membuat validasi untuk title dan content wajib diisi
        $request->validate([
            'name' => 'required'
        ]);
         
        /// mengubah data berdasarkan request dan parameter yang dikirimkan
        $JenisPelayanann = JenisPelayanan::find($id);
        $JenisPelayanann->update($request->all());
         
        /// setelah berhasil mengubah data
        return redirect()->route('jenis-pelayanan.index')
                        ->with('success','JenisPelayanan updated successfully');
    }
  
    public function destroy($id)
    {
        /// melakukan hapus data berdasarkan parameter yang dikirimkan
        $JenisPelayanann = JenisPelayanan::find($id);
        $JenisPelayanann->delete();
  
        return redirect()->route('jenis-pelayanan.index')
                        ->with('success','JenisPelayanan deleted successfully');
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
        $JenisPelayanan = JenisPelayanan::find($id);
        // dd($JenisPelayanan);
        if (!empty($JenisPelayanan))
        {
            if ($request->isMethod('post'))
            {
                $valid = Validator::make($request->all(), [
                    'code'      => 'required|string',
                    'name'      => 'required|string'
                ]);

                if (!$valid->fails()) { 

                    $JenisPelayanan->code = $request->input('code');
                    $JenisPelayanan->name = $request->input('name');
                    $JenisPelayanan->status = 1;
                    $status = $JenisPelayanan->save();

                    if ($status) {
                        return redirect()->route('view_jenis_pelayanan')->with('success', 'Jenis Pelayanan berhasil diubah.');
                    }

                }
                return redirect()->route('view_detail_jenis_pelayanan', ['id' => $id])->withErrors($valid)->withInput();
            }

            return view('jenis-pelayanan.view', compact('JenisPelayanan'));
        }
        return redirect()->route('view_jenis_pelayanan')->with('error', 'User tidak ditemukan');
    }

            /**
     * Ajax for delete the JenisPelayanan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function ajaxDeleteJenisPelayanan(Request $request)
    {
        if ($request->ajax()):
            if (!empty($request->input('id'))) {
                $JenisPelayanan = JenisPelayanan::find($request->input('id'));

                if ($JenisPelayanan) {
                        $status = $JenisPelayanan->delete();

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
