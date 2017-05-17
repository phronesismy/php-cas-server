<?php

namespace App\Http\Controllers\Cas;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use phpCAS;

class LoginController extends Controller
{
	public function login(Request $request)
	{
		$serviceUrl	= $request->input('service');
		$renew		= $request->input('renew');
		$gateway	= $renew ? false : $request->input('gateway');
		$session	= $request->session()->get('user_id');

		if($session)
		{
			$user = UserService::get($session);

			if($gateway)
			{
				$ticket = TicketService::create($serviceUrl, $inputs['username']);

				return redirect($serviceUrl . '?ticket=' . $ticket->ticket);
			}
		}

		return view('cas.login');
	}

	public function postLogin(Request $request)
	{
		$inputs		= $request->only('username', 'password');
		$serviceUrl	= $request->only('service');
		$renew		= $request->input('renew');
		$gateway	= $renew ? false : $request->input('gateway');

		if(Auth::validate($inputs))
		{
			$ticket = TicketService::create($serviceUrl, $inputs['username'], $renew);
			$request->session()->put('user_id', $ticket->user_id);

			return redirect($serviceUrl . '?ticket=' . $ticket->ticket);
		}

		return redirect()->back();
	}
}
