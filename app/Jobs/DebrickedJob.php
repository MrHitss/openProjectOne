<?php

namespace App\Jobs;

use App\Services\DebrickedService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DebrickedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;
    protected string $command;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data,string $command)
    {
        $this->data = $data;
        $this->command = $command;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->command == 'upload')
            (new DebrickedService())->uploadFile($this->data);
        else if ($this->command == 'status')
            (new DebrickedService())->fileStatus($this->data);

    }
}
