<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Broadcast;
use App\Events\BroadcastCreated;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Storage;

class BroadcastController extends Controller
{
    /**
     * Membuat broadcast baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'message' => 'required|string',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        // ======================================================
        // UPLOAD IMAGE (opsional)
        // ======================================================
        $filePath = null;

        if ($request->hasFile('image')) {
            $filePath = $request->file('image')
                ->store('broadcasts', 'public');
        }

        // ======================================================
        // SIMPAN DATA BROADCAST KE DATABASE
        // ======================================================
        $broadcast = Broadcast::create([
            'title'   => $request->title,
            'message' => $request->message,
            'image'   => $filePath,
            'sent_by' => auth()->id(),
        ]);

        // ======================================================
        // TRIGGER EVENT BROADCAST
        // ======================================================
        event(new BroadcastCreated($broadcast));

        return ApiResponse::success(
            $broadcast,
            "Broadcast berhasil dibuat dan dikirim"
        );
    }

    /**
     * Mengambil semua broadcast
     */
    public function index()
    {
        $items = Broadcast::latest()->get();

        return ApiResponse::success(
            $items,
            "Daftar broadcast ditemukan"
        );
    }

    /**
     * Detail broadcast berdasarkan ID
     */
    public function show($id)
    {
        $data = Broadcast::findOrFail($id);

        return ApiResponse::success(
            $data,
            "Detail broadcast ditemukan"
        );
    }

    /**
     * Menghapus broadcast
     */
    public function destroy($id)
    {
        $broadcast = Broadcast::findOrFail($id);

        // Hapus file gambar jika ada
        if ($broadcast->image && Storage::disk('public')->exists($broadcast->image)) {
            Storage::disk('public')->delete($broadcast->image);
        }

        $broadcast->delete();

        return ApiResponse::success(
            null,
            "Broadcast berhasil dihapus"
        );
    }
}
