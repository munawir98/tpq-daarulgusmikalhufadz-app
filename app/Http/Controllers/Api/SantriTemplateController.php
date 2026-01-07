<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SantriTemplateController extends Controller
{
    /**
     * ============================
     * DOWNLOAD TEMPLATE SANTRI
     * GET /api/santri/template
     * ============================
     */
    public function download()
    {
        $path = 'templates/santri_import_template.xlsx';

        if (!Storage::disk('public')->exists($path)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Template santri tidak ditemukan'
            ], 404);
        }

        return Storage::disk('public')->download(
            $path,
            'template_import_santri.xlsx'
        );
    }
}
