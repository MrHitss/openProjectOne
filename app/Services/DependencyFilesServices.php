<?php

namespace App\Services;

use App\Jobs\DebrickedJob;
use App\Models\DependencyFiles;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class DependencyFilesServices
{
    /**
     * Summary of uploadToDB
     * @param mixed $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function uploadToDB($request)
    {
        $data = [];
        foreach ($request->file('fileInput') as $file) {
            $filePath = $this->processFileToLocal($file);
            $data[] = [
                'file' => $filePath,
                'user_id' => auth()->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            
        }
        $isCreated = DependencyFiles::insert($data);
        

        if ($isCreated) {
            return response()->json(['success' => true,'message' => 'File is pending to upload']);
        }

        return response()->json(['success' => false,'message' => 'Something went wrong'],400);
    }

    /**
     * Function to use in command to process the files via job.
     * 
     * @return void
     */
    public function filesAutomation(string $command)
    {
        $dependencies = DependencyFiles::with('user')->where('status',0)->get(); // It taking only pending files

        foreach ($dependencies as $dependency) {
            if (Storage::disk('public')->exists($dependency->file)) {
                $data = [
                    'd_id' => $dependency->id,
                    'file' => Storage::disk('public')->get($dependency->file),
                    'file_name' => basename($dependency['file']),
                    'user_id' => $dependency->user_id,
                    'name' => $dependency->user->name,
                    'email' => $dependency->user->email
                ];
                dispatch(new DebrickedJob($data,$command));
            }
            
        }
    }

    /**
     * Function to use in command to fetch the status of files via job
     * @param string $command
     * @return void
     */
    public function filesStatus(string $command)
    {
        $dependencies = DependencyFiles::with('user')->whereNotIn('status',[0])->whereNotNull('upload_response')->get(); // It takes only under progress files

        foreach ($dependencies as $dependency) {
            $uploadResponse = !empty($dependency->upload_response) ? json_decode($dependency->upload_response,true) : [];
            $data = [
                'd_id' => $dependency->id,
                'ciUploadId' => isset($uploadResponse['ciUploadId']) ? $uploadResponse['ciUploadId'] : '',
                'user_id' => $dependency->user_id,
                'name' => $dependency->user->name,
                'email' => $dependency->user->email
            ];
            dispatch(new DebrickedJob($data,$command));
        }
    }

    private function processFileToLocal($file)
    {
        // Storage can be used as alternative but it was re-write lock files as json ;
        $fileNameWithExt = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME) . '.'.$file->getClientOriginalExtension();
        return $file->storeAs('public/scans', $fileNameWithExt);
    }
}