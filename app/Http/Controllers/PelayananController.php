<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\JenisPelayanan;
use App\Models\DokumenDetail;
use App\Models\Pelayanan;
use App\Models\PelayananDetail;
use App\DataTables\PelayananDataTable;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Validator;
use PDF;
use Barryvdh\Snappy;

class PelayananController extends Controller
{
    public function index(PelayananDataTable $dataTable)
    {
        return $dataTable->render('pelayanan.index');
        // /// mengambil data terakhir dan pagination 5 list
        // $Pelayanann = Pelayanan::latest()->paginate(5);
         
        // /// mengirimkan variabel $Pelayanann ke halaman views Pelayanan/index.blade.php
        // /// include dengan number index
        // return view('pelayanan.index',compact('Pelayanan'))->with('i', (request()->input('page', 1) - 1) * 5);
    }
    
    public function create(Request $request)
    {
        $JenisPelayanan = JenisPelayanan::all();
        if ($request->isMethod('post'))
        {
            $valid = Validator::make($request->all(), [
                'nomor'      => 'required|string',
                'jenis_pelayanan_id'      => 'required|string',
                'nik'      => 'required|string',
                'name'      => 'required|string',
                'address'      => 'required|string'
            ]);

            if (!$valid->fails())
            {
                $Pelayanan = Pelayanan::create([
                    'nomor'  => $request->input('nomor'),
                    'jenis_pelayanan_id'  => $request->input('jenis_pelayanan_id'),
                    'nik'  => $request->input('nik'),
                    'name'  => $request->input('name'),
                    'address'  => $request->input('address'),
                ]);

                if ($Pelayanan) {
                    $dokumenDetail = DokumenDetail::where('type_id',$Pelayanan->jenis_pelayanan_id)->get();
                    foreach($dokumenDetail as $dd){                            
                        $savePelayananDetail = PelayananDetail::create([
                            'pelayanan_id'  => $Pelayanan->id,
                            'document_id'  => $dd->document_id
                        ]);    
                    }   
                    return redirect()->route('view_detail_pelayanan',['id' => $Pelayanan->id])->with('success', ' Pelayanan berhasil dibuat.');
                }
            }
            return redirect()->route('create_pelayanan')->withErrors($valid)->withInput();
        }
        /// menampilkan halaman create
        return view('pelayanan.create', compact('JenisPelayanan'));
    }
  
    public function store(Request $request)
    {
        /// membuat validasi untuk title dan content wajib diisi
        $request->validate([
            'name' => 'required'
        ]);
         
        /// insert setiap request dari form ke dalam database via model
        /// jika menggunakan metode ini, maka nama field dan nama form harus sama
        Pelayanan::create($request->all());
         
        /// redirect jika sukses menyimpan data
        return redirect()->route('pelayanan.index')->with('success','Pelayanan created successfully.');
    }
  
    public function show($id)
    {
        /// dengan menggunakan resource, kita bisa memanfaatkan model sebagai parameter
        /// berdasarkan id yang dipilih
        $Pelayanann = Pelayanan::find($id);
        return view('pelayanan.show',compact('Pelayanan'));
    }
  
    public function edit($id)
    {
        /// dengan menggunakan resource, kita bisa memanfaatkan model sebagai parameter
        /// berdasarkan id yang dipilih
        $Pelayanann = Pelayanan::find($id);
        return view('pelayanan.edit',compact('Pelayanan'));
    }
  
    public function update(Request $request, $id)
    {
        /// membuat validasi untuk title dan content wajib diisi
        $request->validate([
            'name' => 'required'
        ]);
         
        /// mengubah data berdasarkan request dan parameter yang dikirimkan
        $Pelayanann = Pelayanan::find($id);
        $Pelayanann->update($request->all());
         
        /// setelah berhasil mengubah data
        return redirect()->route('pelayanan.index')
                        ->with('success','Pelayanan updated successfully');
    }
  
    public function destroy($id)
    {
        /// melakukan hapus data berdasarkan parameter yang dikirimkan
        $Pelayanann = Pelayanan::find($id);
        $Pelayanann->delete();
  
        return redirect()->route('pelayanan.index')
                        ->with('success','Pelayanan deleted successfully');
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
        $JenisPelayanan = JenisPelayanan::all();
        $Pelayanan = Pelayanan::find($id);
        $pelayananDetail = PelayananDetail::with('dok')->where('pelayanan_id',$Pelayanan->id)->get();
        // dd($pelayananDetail);
        if (!empty($Pelayanan))
        {
            if ($request->isMethod('post'))
            {
                $valid = Validator::make($request->all(), [
                    'nomor'      => 'required|string',
                    'jenis_pelayanan_id'      => 'required|string',
                    'nik'      => 'required|string',
                    'name'      => 'required|string',
                    'address'      => 'required|string'
                ]);

                if (!$valid->fails()) { 

                    $Pelayanan->nomor = $request->input('nomor');
                    $Pelayanan->jenis_pelayanan_id = $request->input('jenis_pelayanan_id');
                    $Pelayanan->nik = $request->input('nik');
                    $Pelayanan->name = $request->input('name');
                    $Pelayanan->address = $request->input('address');
                    $status = $Pelayanan->save();

                    if ($status) {
                        return redirect()->route('view_pelayanan')->with('success', ' Pelayanan berhasil diubah.');
                    }

                }
                return redirect()->route('view_detail_pelayanan', ['id' => $id])->withErrors($valid)->withInput();
            }

            return view('pelayanan.view', compact('Pelayanan','JenisPelayanan','pelayananDetail'));
        }
        return redirect()->route('view_pelayanan')->with('error', 'User tidak ditemukan');
    }

           /**
     * Get  User's detail and form change password
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function uploadDokumen($id, Request $request)
    {
        $pelayananDetail = PelayananDetail::find($id);
        // dd($pelayananDetail);
        if (!empty($pelayananDetail))
        {
            $valid = Validator::make($request->all(), [
                'dokumen'      => 'required',
            ]);

            if (!$valid->fails()) { 
                if (!file_exists(public_path('storage/pelayanan/'.$pelayananDetail->pelayanan_id))) Storage::disk('public')->makeDirectory('pelayanan/'.$pelayananDetail->pelayanan_id);
                $file = $request->file('dokumen');
                $extension = $file->extension();
                $namaFile = $pelayananDetail->pelayanan_id."-".$pelayananDetail->document_id.".".$extension;
                $tujuan_upload = 'pelayanan/'.$pelayananDetail->pelayanan_id;
                // $file->move($tujuan_upload,$namaFile);
                Storage::disk('public')->putFileAs($tujuan_upload, $file, $namaFile,'public');

                $pelayananDetail->dokumen = $namaFile;
                $status = $pelayananDetail->save();

                if ($status) {
                    return redirect()->route('view_detail_pelayanan', ['id' => $pelayananDetail->pelayanan_id])->with('success', ' Dokumen Berhasil di upload.');
                }

            }
            return redirect()->route('view_detail_pelayanan', ['id' => $pelayananDetail->pelayanan_id])->withErrors($valid)->withInput();
        }
        return redirect()->route('view_pelayanan')->with('error', 'Pelayanan detail tidak ditemukan');
    }

            /**
     * Ajax for delete the Pelayanan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function ajaxDeletePelayanan(Request $request)
    {
        if ($request->ajax()):
            if (!empty($request->input('id'))) {
                $Pelayanan = Pelayanan::find($request->input('id'));

                if ($Pelayanan) {
                        $status = $Pelayanan->delete();

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

    /**
     * Ajax for delete the Pelayanan
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function getNomorPelayanan(Request $request)
    {
        if ($request->ajax()):
            if (!empty($request->input('jenis_pelayanan_id'))) {
                $JenisPelayanan = JenisPelayanan::find($request->input('jenis_pelayanan_id'));
                $Pelayanan = Pelayanan::where('jenis_pelayanan_id',$JenisPelayanan->id)->orderBy('id', 'desc')->first();
                // return response()->json(['success' => true, 'description' => 'berhasil get nomor.', 'data' => $Pelayanan]);
                if ($JenisPelayanan) {
                    if ($Pelayanan) {
                        $lastNomor = explode("/",$Pelayanan->nomor);    
                        $nomorBefore = $lastNomor[0];

                        if ($this->getRomawi(date("m")) == $lastNomor[2]  && date("Y") == $lastNomor[3]){
                            $nomor = (int)$nomorBefore + 1;
                            $nomorSurat = $nomor."/".$JenisPelayanan->code."/".$this->getRomawi(date("m"))."/".date("Y");
                        }else{
                            $nomor = 1;
                            $nomorSurat = $nomor."/".$JenisPelayanan->code."/".$this->getRomawi(date("m"))."/".date("Y"); 
                        }
                    } else {
                        $nomor = 1;
                        $nomorSurat = $nomor."/".$JenisPelayanan->code."/".$this->getRomawi(date("m"))."/".date("Y");
                    }

                    if ($nomorSurat) {
                        return response()->json(['success' => true, 'description' => 'berhasil get nomor.', 'data' => $nomorSurat]);
                    }

                    return response()->json(['success' => false, 'description' => 'Gagal get data.', 'data' => null]);
                }
                return response()->json(['success' => false, 'description' => 'data tidak dapat ditemukan', 'data' => null]);
            }

            return response()->json([
                'success' => false,
                'description' => 'Mohon sertakan ID Jenis Pelayanan',
                'data' => null
            ]);
        else:
            return redirect()->route('dashboard')->with('error', 'Anda dilarang mengakses halaman ini.');
        endif;
    }

    function getRomawi($bln){
        switch ($bln){
            case 1: 
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
}
}
