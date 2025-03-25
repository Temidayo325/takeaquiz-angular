<x-mail::message>
# Dear Customer

OGs purchase ticket

Here's your ticket for the #{{ $event->name }} event

<x-mail::table>

| **Detail**   | **Information** |
|-------------|----------------|
| **Event**   | {{ $event->name }} |
| **Date**    | {{ (new DateTime($event->event_date))->format('D, M d Y') }} |
| **Time**    | {{ $event->event_time }} |
| **Location**   | {{ $event->location }} |
| **Price**   | #{{ number_format($ticket->price, 2, '.', ',') }} |

</x-mail::table>

Dress code for the event is stated as {{$event->dress_code}}

Ticket attractions includes: {{$ticket->type_copy}}

For event inquiry and support, kindly reachout to the organizer via {{$event->contact_information}}

Thank you for your purchase! 🎉,<br>


{{ config('app.name') }}
</x-mail::message>
