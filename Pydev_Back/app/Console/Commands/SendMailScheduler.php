<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SendMailScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduler:send_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cette commande lancera la file d\'attente des mails';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return Artisan::call('queue:work');
    }
}
