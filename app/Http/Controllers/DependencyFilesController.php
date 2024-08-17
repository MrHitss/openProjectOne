<?php

namespace App\Http\Controllers;

use App\Models\DependencyFiles;
use App\Services\DebrickedService;
use App\Services\DependencyFilesServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DependencyFilesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function upload(Request $request)
    {
        $request->validate([
            'fileInput' => 'required'
        ]);
        
        return (new DependencyFilesServices())->uploadToDB($request);
    }

    /**
     * Get all files of users
     * 
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function files()
    {
        $dependencies = DependencyFiles::where('user_id', auth()->user()->id)->get();

        if (empty($dependencies)) {
            return response()->json(['success' => false, 'messagee' => 'something went wrong'],400);
        }

        $data = $dependencies->map(function($dependency){
            return [
                'file_name' => basename($dependency->file),
                'status' => $dependency->status_name
            ];
        });

        return response()->json(['success' => true, 'messagee' => 'fetched', 'data' => $data]);
    }
}
