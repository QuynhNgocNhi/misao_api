<?php


namespace App\Components\Excel\Export\Notify;


use App\Models\User;
use App\Notifications\ExportExecuted;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;

class NotifyUserOfCompletedExport implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    /**
     * @var string
     */
    private $fileName;

    public function __construct(User $user, string $fileName)
    {
        $this->user = $user;
        $this->fileName = $fileName;
    }

    public function handle()
    {
        $this->user->notify(new ExportExecuted($this->fileName));
    }
}