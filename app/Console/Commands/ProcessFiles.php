<?php

namespace App\Console\Commands;

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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = File::where('status','PROCESSING')->get();
        foreach ($files as $file)
            if ($file['is_valid'])
                $file->processNumbers();
    }
}
