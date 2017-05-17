<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use phpCAS;

class HomeController extends Controller
{
	public function index(Request $request)
	{
		if($request->user())
		{
			return redirect()->route('admin.users.index');
		}
		else
		{
			return redirect()->route('login');
		}
	}

	public function login(Request $request)
	{
		if(phpCAS::checkAuthentication())
		{
			return redirect()->route('root');
		}
		else
		{
			phpCAS::forceAuthentication();
		}
	}

	public function logout(Request $request)
	{
		if($request->user())
		{
			phpCAS::logout();
		}
		else
		{
			redirect()->route('root');
		}
	}
}
