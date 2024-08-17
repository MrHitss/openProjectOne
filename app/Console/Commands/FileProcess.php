<?php

namespace App\Console\Commands;

use App\Services\DependencyFilesServices;
use Illuminate\Console\Command;

class FileProcess extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fileProcess {type}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is using to start the process of all file functions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $command = $this->argument('type');
        $service = (new DependencyFilesServices());
        if ($command == 'upload')
            $service->filesAutomation($command);
        else if ($command == 'status')
            $service->filesStatus($command);

    }
}
