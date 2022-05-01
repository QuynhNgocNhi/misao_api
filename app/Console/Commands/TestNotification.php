<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        $result = \OneSignal::sendNotificationToExternalUser(
            message: 'からメッセージがあります。',
            data: [
                'chat_room_id' => 1
            ],
            userId: '103',
            url: asset(''),
            headings: '新着メッセージがあります。',
        );
        dd($result);
        return Command::SUCCESS;
    }
}
