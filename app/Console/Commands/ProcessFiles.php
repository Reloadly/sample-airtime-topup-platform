<?php

namespace App\Console\Commands;

use Exception;
use App\Models\File;
use Illuminate\Console\Command;

class ProcessFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process All Files that are uploaded.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try{
            $files = File::query()
                ->where('status', 'PROCESSING')
                ->get();
            $this->withProgressBar($files, function ($file) {
                if ($file['is_valid']) {
                    $file->processNumbers();
                }
            });
        }catch (Exception $exception){
            $this->error($exception->getMessage());
        }
        return 0;
    }
}
