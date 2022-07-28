<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        $response = ['url' => ''];

        if ($request->hasFile('upload')) {
            $path            = $request->upload->store('public');
            $response['url'] = Storage::url($path);
        }

        return response()->json($response);
    }
}
