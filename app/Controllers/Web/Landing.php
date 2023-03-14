<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Landing extends BaseController
{
    public function index()
    {
        $data = [
			'title' => 'Coming Soon',
		];
        return view('index', $data);
    }
}
