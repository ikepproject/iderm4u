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

    public function privacy()
    {
        $data = [
			'title' => 'Privacy Policy iDerm4U',
		];
        return view('page_privacy', $data);
    }

    public function toc()
    {
        $data = [
			'title' => 'Terms and Conditions iDerm4U',
		];
        return view('page_tos', $data);
    }
}
