<?php

namespace App\Controllers\Api;
use App\Libraries\JWTCI4;
use App\Models\Model_User;

use CodeIgniter\RESTful\ResourceController;

class AppAuth extends ResourceController
{
    public function login()
	{
		if( !$this->validate([
			'email' 	=> 'required',
			'password' 	=> 'required',
		]))
		{
			return $this->response->setJSON(
                [
                    'success' => false,
                    'code'    => '422',
                    'data'    => null, 
                    'message' => 'Email dan Password Harus Terisi.'
                ]);
		}
        $tb_user = new Model_User;
		$user    = $tb_user->where('user_email', $this->request->getVar('email'))->first();
		if( $user )
		{
			if( password_verify($this->request->getVar('password'), $user['user_password']) )
			{
				$jwt        = new JWTCI4;
                $uid        = $user['user_id'];
                $rle        = $user['user_role'];
                $fsk        = $user['user_faskes'];
                $atv        = $user['user_active'];
				$token      = $jwt->token($uid,$rle,$fsk,$atv);

				return $this->response->setJSON( 
                    [
                        'token'=> $token 
                    ]);
			} else {
                return $this->response->setJSON( 
                    [
                        'success' => false,
                        'code'    => '403',
                        'data'    => null, 
                        'message' => 'Email atau Password Salah.', 
                    ]);
            }
		}else{

			return $this->response->setJSON( 
                [
                    'success' => false,
                    'code'    => '403',
                    'data'    => null, 
                    'message' => 'Email atau Password Salah.', 
                    ]);
		}
		
		
	}
}
