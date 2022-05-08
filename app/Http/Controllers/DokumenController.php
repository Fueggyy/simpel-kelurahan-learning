<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\DataTables\DokumenDataTable;
use Validator;
use PDF;
use Barryvdh\Snappy;

class DokumenController extends Controller
{
    public function index(DokumenDataTable $dataTable)
    {
        return $dataTable->render('dokumen.index');
        // /// mengambil data terakhir dan pagination 5 list
        // $dokumenn = Dokumen::latest()->paginate(5);
         
        // /// mengirimkan variabel $dokumenn ke halaman views Dokumen/index.blade.php
        // /// include dengan number index
        // return view('dokumen.index',compact('dokumen'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    public function create(Request $request)
    {
        if ($request->isMethod('post'))
        {
            $valid = Validator::make($request->all(), [
                'name'      => 'required|string'
            ]);

            if (!$valid->fails())
            {
                $dokumen = Dokumen::create([
                    'name'  => $request->input('name')
                ]);

                if ($dokumen) {
                    return redirect()->route('view_dokumen')->with('success', 'Dokumen berhasil dibuat.');
                }
            }
            return redirect()->route('create_dokumen')->withErrors($valid)->withInput();
        }
        /// menampilkan halaman create
        return view('dokumen.create');
    }
  
    public function store(Request $request)
    {
        /// membuat validasi untuk title dan content wajib diisi
        $request->validate([
            'name' => 'required'
        ]);
         
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        Dokumen::create($request->all());
         
        /// redirect jika sukses menyimpan data
        return redirect()->route('dokumen.index')->with('success','Dokumen created successfully.');
    }
  
    public function show($id)
    {
        /// dengan menggunakan resource, kita bisa memanfaatkan model sebagai parameter
        /// berdasarkan id yang dipilih
        $dokumenn = Dokumen::find($id);
        return view('dokumen.show',compact('dokumen'));
    }
  
    public function edit($id)
    {
        /// dengan menggunakan resource, kita bisa memanfaatkan model sebagai parameter
        /// berdasarkan id yang dipilih
        $dokumenn = Dokumen::find($id);
        return view('dokumen.edit',compact('dokumen'));
    }
  
    public function update(Request $request, $id)
    {
        /// membuat validasi untuk title dan content wajib diisi
        $request->validate([
            'name' => 'required'
        ]);
         
        /// mengubah data berdasarkan request dan parameter yang dikirimkan
        $dokumenn = Dokumen::find($id);
        $dokumenn->update($request->all());
         
        /// setelah berhasil mengubah data
        return redirect()->route('dokumen.index')
                        ->with('success','Dokumen updated successfully');
    }
  
    public function destroy($id)
    {
        /// melakukan hapus data berdasarkan parameter yang dikirimkan
        $dokumenn = Dokumen::find($id);
        $dokumenn->delete();
  
        return redirect()->route('dokumen.index')
                        ->with('success','Dokumen deleted successfully');
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
        $dokumen = Dokumen::find($id);
        if (!empty($dokumen))
        {
            if ($request->isMethod('post'))
            {
                $valid = Validator::make($request->all(), [
                    'name'      => 'required|string'
                ]);

                if (!$valid->fails()) { 

                    $dokumen->name = $request->input('name');
                    $status = $dokumen->save();

                    if ($status) {
                        return redirect()->route('view_dokumen')->with('success', 'Dokumen berhasil diubah.');
                    }

                }
                return redirect()->route('view_detail_dokumen', ['id' => $id])->withErrors($valid)->withInput();
            }

            return view('dokumen.view', compact('dokumen'));
        }
        return redirect()->route('view_dokumen')->with('error', 'User tidak ditemukan');
    }

            /**
     * Ajax for delete the Dokumen
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function ajaxDeleteDokumen(Request $request)
    {
        if ($request->ajax()):
            if (!empty($request->input('id'))) {
                $dokumen = Dokumen::find($request->input('id'));

                if ($dokumen) {
                        $status = $dokumen->delete();

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
