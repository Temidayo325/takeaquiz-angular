<?php
declare(strict_types = 1);
namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\User;

class MailJet
{
    public static function sendTemplate(User $user, \App\Models\Event $event, \App\Models\Ticket $ticket)
    {
        $body = [
            "Messages" => [
                [
                    "From" => [
                        "Email" => "pacy@cruisehq.fun",
                        "Name" => "TCG from CruiseHq"
                    ],
                    "To" => [
                        [
                            "Email" => "opeyemi@cruisehq.fun",
                            "Name" => $user->nickname
                        ]
                    ],
                    "TemplateID" => 6830844,
                    "TemplateLanguage" => true,
                    "Subject" => "[TEST] Your event ticket"
                ]
            ],
            "Data" => [
                "firstname" => "Dear Customer"
            ],
            "Variables" => [
                "enrolled" => "",
                "event_state" => $event->state,
                "event_location" => $event->location,
                "event_organizer" => $event->user->nickname,
                "user" => $user->nickname,
                "event_date" => $event->event_date,
                "event_time" => $event->starting_time,
                "ticket_name" => $ticket->name,
                "event_name" => $event->name
            ]
        ];
        
        try {
            $request = Http::mailjet(config('mailjet.url.send_template'), $body);
            $response = $request->object();
            if ( $request->failed() || !$response->Messages[0]->Status != 'success') {
                throw new \Exception("Error Processing Request", 1);  
            }
            return $response;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), 1);
        }
    }
}
