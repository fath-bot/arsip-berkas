<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index()
    {
        // Batasi akses hanya untuk admin dan superadmin
        if (!in_array(session('role'), ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized');
        }
$logs = LogAktivitas::with('user')->latest()->get();


        return view('admin.pages.logs.index', compact('logs'));
    }
}
