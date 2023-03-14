<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Libraries\JWTCI4;
class Auth extends BaseController
{

	public function login()
	{
		helper('cookie');
        if (!get_cookie('gem')) {
			$data = [
				'title' => 'Login',
			];
			return view('auth/login',$data);
		} else {
			$token  = get_cookie('gem');
			$jwt    = new JWTCI4;
			$verifiy= $jwt->parseweb($token);
			if( !$verifiy['success'] )
			{
				delete_cookie('gem');
				$data = [
					'title' => 'Login',
				];
				return view('auth/login',$data);
				
			} else {
				return redirect()->to('dashboard');
			}
		}
	}

	public function register()
	{
		helper('cookie');
        if (!get_cookie('gem')) {
			$faskes = $this->faskes->findall();
			$data = [
				'title' 	=> 'Register',
				'faskes'	=> $faskes,
			];
			return view('auth/register',$data);
		} else {
			$token  = get_cookie('gem');
			$jwt    = new JWTCI4;
			$verifiy= $jwt->parseweb($token);
			if( !$verifiy['success'] )
			{
				$faskes = $this->faskes->findall();
				$data = [
					'title' 	=> 'Register',
					'faskes'	=> $faskes,
				];
				return view('auth/register',$data);
				
			} else {
				return redirect()->to('dashboard');
			}
		}

		
		
	}

	
}