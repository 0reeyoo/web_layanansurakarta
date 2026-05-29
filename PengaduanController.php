<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PengaduanController extends Controller
{
    public function index()
    {
        return $this->renderByStatus('Menunggu', 'admin.pengaduan.index', 'Pengaduan Masuk');
    }

    public function proses()
    {
        return $this->renderByStatus('Diproses', 'admin.pengaduan.proses', 'Pengaduan Diproses');
    }

    public function selesai()
    {
        return $this->renderByStatus('Selesai', 'admin.pengaduan.selesai', 'Pengaduan Selesai');
    }

    public function show($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        
        // Pastikan admin hanya bisa melihat pengaduan sesuai dinasnya
        $this->checkDinasAccess($pengaduan);

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(Request $request, $id)
    {
        $mailFailed = false;

        $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai',
            'bukti_selesai' => 'nullable|image|max:10240',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);
        
        // Pastikan admin hanya bisa update pengaduan sesuai dinasnya
        $this->checkDinasAccess($pengaduan);
        
        if ($request->hasFile('bukti_selesai')) {
            $pengaduan->bukti_selesai = $request->file('bukti_selesai')->store('bukti_selesai_pengaduan', 'public');
        }

        $pengaduan->status = $request->status;
        $pengaduan->save();

        if ($pengaduan->status === 'Selesai' && $pengaduan->user && $pengaduan->user->email) {
            try {
                $buktiUrl = $pengaduan->bukti_selesai_url;
                $subject = 'Pengaduan Anda telah selesai diproses';
                $message = "Halo {$pengaduan->user->name}, pengaduan #{$pengaduan->id} dengan kategori {$pengaduan->kategori} telah selesai ditangani.";
                if ($buktiUrl) {
                    $message .= " Bukti penyelesaian dapat dilihat di: {$buktiUrl}";
                }

                Mail::raw($message, function ($mail) use ($pengaduan, $subject) {
                    $mail->to($pengaduan->user->email)
                        ->subject($subject);
                });
            } catch (\Throwable $e) {
                report($e);
                $mailFailed = true;
            }
        }

        $message = 'Status pengaduan berhasil diperbarui.';
        if ($mailFailed) {
            $message .= ' Namun email notifikasi gagal dikirim. Periksa konfigurasi/layanan SMTP.';
        }

        return back()->with('success', $message);
    }

    private function renderByStatus(string $status, string $view, string $judul)
    {
        $user = Auth::user();
        
        $seenKey = match ($status) {
            'Diproses' => 'admin_pengaduan_seen_diproses_at',
            'Selesai' => 'admin_pengaduan_seen_selesai_at',
            default => null,
        };

        if ($seenKey !== null) {
            session([$seenKey => Carbon::now()->toDateTimeString()]);
        }

        // Filter berdasarkan dinas jika user adalah admin dinas
        $dinasQuery = $user->dinas_role ? ['dinas' => $user->dinas_role] : [];

        $stats = [
            'total' => Pengaduan::where($dinasQuery)->count(),
            'menunggu' => Pengaduan::where('status', 'Menunggu')->where($dinasQuery)->count(),
            'proses' => Pengaduan::where('status', 'Diproses')->where($dinasQuery)->count(),
            'selesai' => Pengaduan::where('status', 'Selesai')->where($dinasQuery)->count(),
        ];

        $pengaduans = Pengaduan::where('status', $status)
            ->where($dinasQuery)
            ->latest()
            ->paginate(10);

        return view($view, compact('pengaduans', 'stats', 'judul'));
    }

    private function checkDinasAccess($pengaduan)
    {
        $user = Auth::user();
        
        // Jika admin punya dinas_role, pastikan pengaduan sesuai dengan dinasnya
        if ($user->dinas_role && $pengaduan->dinas !== $user->dinas_role) {
            abort(403, 'Anda tidak memiliki akses ke pengaduan ini');
        }
    }
}
