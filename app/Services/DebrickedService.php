<?php

namespace App\Services;

use App\Models\DependencyFiles;
use Illuminate\Support\Facades\Http;

class DebrickedService
{
    protected string $apiBaseUrl = "https://debricked.com/api/1.0/open/";
    protected string $username;
    protected string $password;
    protected string $accessToken;

    public function __construct()
    {
        $this->username = env('DEBRICKED_USERNAME');
        $this->password = env('DEBRICKED_PASSWORD');
    }

    /**
     * Upload File API
     * 
     * @param array $data
     * @return void
     */
    public function uploadFile(array $data)
    {

        $this->authenticate();

        $response = Http::acceptJson()->withHeaders(['Authorization' => 'Bearer '.$this->accessToken])
        ->attach('fileData',$data['file'],$data['file_name'])
        ->post("{$this->apiBaseUrl}uploads/dependencies/files",
        [
            'repositoryName' => 'File',
            'commitName' => $data['file_name'],
        ]);

        $dependencyfile = DependencyFiles::where('id',$data['d_id'])->first();
        $dependencyfile->upload_response = json_encode($response->json());
        $dependencyfile->status = $response->status() === 200 ? 1 : 3;
        $dependencyfile->save();

    }

    /**
     * 
     * File Status API
     * 
     * @param array $data
     * @return void
     */
    public function fileStatus(array $data)
    {
        $this->authenticate();

        $response = Http::acceptJson()->withHeaders(['Authorization' => 'Bearer '.$this->accessToken])
        ->get("{$this->apiBaseUrl}ci/upload/status?ciUploadId={$data['ciUploadId']}");
        
        $dependencyfile = DependencyFiles::where('id',$data['d_id'])->first();
        $dependencyfile->status_response = json_encode($response->json());
        $dependencyfile->status = $response->status() === 202 && ($response->json())['progress'] == 0 ? 2 : 3;
        $dependencyfile->save();
    }

    /**
     * 
     * Authenticate API
     * 
     * @return void
     */
    private function authenticate()
    {
        if (empty($this->accessToken)) {
            $response = Http::withBody(json_encode(['_username' => $this->username, '_password' => $this->password]))->post('https://debricked.com/api/login_check');
            $response = $response->json();
    
            $this->accessToken = (isset($response['token']) ? $response['token'] : '');
        }
        
    }
}