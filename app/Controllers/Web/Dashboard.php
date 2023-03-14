<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
	public function index()
	{
		$user = $this->userauth(); // Return Object
		$data = [
			'title' => 'Dashboard',
			'user'  => $user,
		];
		return view('panel/dashboard', $data);
	}
}