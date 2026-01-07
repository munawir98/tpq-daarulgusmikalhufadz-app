<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SantriWebController extends Controller
{
    /**
     * Show santri list (shared)
     */
    public function index()
    {
        return view('santri.index');
    }

    /**
     * Show santri detail
     */
    public function show($id)
    {
        return view('santri.show', ['santriId' => $id]);
    }

    /**
     * Admin - Show santri list
     */
    public function adminIndex()
    {
        return view('admin.santri.index');
    }

    /**
     * Admin - Show create form
     */
    public function create()
    {
        return view('admin.santri.create');
    }

    /**
     * Admin - Store new santri
     */
    public function store(Request $request)
    {
        // TODO: Implement store logic
        return redirect()->route('admin.santri.index')->with('success', 'Santri berhasil ditambahkan');
    }

    /**
     * Admin - Show edit form
     */
    public function edit($id)
    {
        return view('admin.santri.edit', ['santriId' => $id]);
    }

    /**
     * Admin - Update santri
     */
    public function update(Request $request, $id)
    {
        // TODO: Implement update logic
        return redirect()->route('admin.santri.index')->with('success', 'Santri berhasil diperbarui');
    }

    /**
     * Admin - Delete santri
     */
    public function destroy($id)
    {
        // TODO: Implement delete logic
        return redirect()->route('admin.santri.index')->with('success', 'Santri berhasil dihapus');
    }
}
