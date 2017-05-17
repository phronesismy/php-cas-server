<?php

namespace App\Services;

use Ticket;
use User;

class TicketService
{
	public static function create($serviceUrl, $username, $renew=false, $remember=false)
	{
		$service = Service::whereHas('urls', function($query), use($serviceUrl) {
			$query->whereUrl($serviceUrl);
		})->first();

		if($renew)
		{
			$ticket 			= new Ticket;
			$ticket->user_id 	= $user->id;
			$ticket->renew		= true;
			$ticket->service_id = $service->id
		}
		else
		{

		}
		$ticket = Ticket::whereHas('urls', function($query) use($service) {
			$query->whereUrl($service);
		})->active()->first();
	}
}