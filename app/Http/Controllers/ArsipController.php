<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Mutasi;
use App\Models\Pangkat;
use App\Models\Pemberhentian;
use App\Models\Cpns;
use App\Models\Ijazah;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ArsipController extends Controller
{
    // Method untuk menampilkan semua arsip
    public function index($type)
{
    $model = $this->getModel($type);
    $items = $model::latest()->get();
    
    return view('admin.pages.arsip.index', [
        'type' => $type,
        'items' => $items,
        'title' => ucfirst($type) // Tambahkan title untuk view
    ]);
}

    // Method untuk menampilkan form create
    public function create($type)
    {
        return view('admin.pages.arsip.create', compact('type'));
    }

    // Method untuk menyimpan data baru
    public function store(Request $request, $type)
    {
        $commonRules = [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:18',
            'jabatan' => 'required|string|max:255',
            'letak_berkas' => 'required|string'
        ];

        switch ($type) {
            case 'jabatan':
            case 'mutasi':
            case 'pangkat':
            case 'pemberhentian':
            case 'cpns':
                $validated = $request->validate(array_merge($commonRules, [
                    'no_sk' => 'required|string|max:50',
                    'tanggal' => 'required|date'
                ]));
                $model = 'App\\Models\\' . ucfirst($type);
                break;
                
            case 'ijazah':
                $validated = $request->validate(array_merge($commonRules, [
                    'jenjang' => 'required|in:SMA,D3,S1,S2,S3',
                    'universitas' => 'required|string|max:255'
                ]));
                $model = 'App\\Models\\Ijazah';
                break;
                
            default:
                return back()->with('error', 'Tipe arsip tidak valid');
        }

        $model::create($validated);

            return redirect()->route('admin.arsip.index', ['type' => $type])
            ->with('success', 'Data berhasil disimpan');
            
    }

    

    // Method untuk menampilkan form edit
    public function edit($type, $id)
    {
        $model = $this->getModel($type);
        $item = $model::findOrFail($id);
        
        return view('admin.pages.arsip.edit', [
            'type' => $type,
            'item' => $item
        ]);
         
    }

    // Method untuk update data
    public function update(Request $request, $type, $id)
    {
        $model = $this->getModel($type);
        $item = $model::findOrFail($id);

        $commonRules = [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:18',
            'jabatan' => 'required|string|max:255',
            'letak_berkas' => 'required|string'
        ];

        switch ($type) {
            case 'jabatan':
            case 'mutasi':
            case 'pangkat':
            case 'pemberhentian':
            case 'cpns':
                $validated = $request->validate(array_merge($commonRules, [
                    'no_sk' => 'required|string|max:50',
                    'tanggal' => 'required|date'
                ]));
                break;
                
            case 'ijazah':
                $validated = $request->validate(array_merge($commonRules, [
                    'jenjang' => 'required|in:SMA,D3,S1,S2,S3',
                    'universitas' => 'required|string|max:255'
                ]));
                break;
        }

        $item->update($validated);

        // return redirect()->route('arsip.index')
        //     ->with('success', 'Data arsip berhasil diperbarui');
        
            return redirect()->route('admin.arsip.index', ['type' => $type])
            ->with('success', 'Data berhasil disimpan');
    }

    // Method untuk menghapus data
    public function destroy($type, $id)
    {
        $model = $this->getModel($type);
        $item = $model::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Data arsip berhasil dihapus');
    }

    // Helper method untuk mendapatkan model berdasarkan type
    private function getModel($type)
    {
        $models = [
            'jabatan' => Jabatan::class,
            'mutasi' => Mutasi::class,
            'pangkat' => Pangkat::class,
            'pemberhentian' => Pemberhentian::class,
            'cpns' => Cpns::class,
            'ijazah' => Ijazah::class
        ];

        return $models[$type] ?? abort(404);
    }
}