<?php

namespace App\Console\Commands;

use App\Event;
use App\EventNotification;
use Illuminate\Console\Command;
use Joli\JoliNotif\Notification;
use Joli\JoliNotif\NotifierFactory;

class DesktopNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an desktop notification';

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
        $events = Event::where('start', date("Y-m-d", strtotime("+1 days")))->get();
        foreach ($events as $event) {
            if (!EventNotification::where('event_id', $event->id)->exists()) {
                $eventNotification = new EventNotification();
                $eventNotification->event_id = $event->id;
                $eventNotification->notified = true;
                $eventNotification->save();
                $notifier = NotifierFactory::create();
                // Create your notification
                $notification =
                    (new Notification())
                        ->setTitle($event->title)
                        ->setBody($event->title)
                        ->setIcon(asset('ev.png'));
                // Send it
                $notifier->send($notification);
            }

        }
    }
}
