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

	public function dologin()
	{
		if( !$this->validate([
			'user_username' 	=> 'required',
			'user_password' 	=> 'required',
		]))
		{
			return $this->response->setJSON(
                [
                    'success' => false,
                    'code'    => '422',
                    'data'    => null, 
                    'message' => 'Username dan Password Harus Terisi.'
                ]);
		}
		$user       = $this->user->where('user_username', $this->request->getVar('user_username'))->first();
		if( $user )
		{
			if( password_verify($this->request->getVar('user_password'), $user['user_password']) )
			{
                if ($user['user_active'] == 'f') {
                    return $this->response->setJSON( 
                        [
                            'success' => false,
                            'code'    => '403',
                            'data'    => null, 
                            'message' => 'Akun Belum Aktif.', 
                        ]);
                }  else  {
                    $uid        = $user['user_id'];
                    $rle        = $user['user_role'];
                    $fsk        = $user['user_faskes'];
                    $atv        = $user['user_active'];
                    $jwt        = new JWTCI4;
                    $token      = $jwt->token($uid,$rle,$fsk,$atv);
                    
                    $exp        = 60 * 60 * 24 * 1; // in second (60 * 60 * 24 * 30) (86.400 = 1day)
                    $remember   = $this->request->getVar('remember');
                    if ($remember == 1) {
                        $exp        = 60 * 60 * 24 * 2; // 7day
                    }
                    set_Cookie('gem',$token,$exp);
                    return $this->response->setJSON( 
                        [
                            'success' => true,
                            'code'    => '200',
                            'data'    => [
                                'link' => 'dashboard'
                            ], 
                            'message' => 'Berhasil, Redirect...',  
                        ]);
                }
                
                
			} else {
                return $this->response->setJSON( 
                    [
                        'success' => false,
                        'code'    => '403',
                        'data'    => null, 
                        'message' => 'Username atau Password Salah.', 
                    ]);
            }
		}else{

			return $this->response->setJSON( 
                [
                    'success' => false,
                    'code'    => '403',
                    'data'    => null, 
                    'message' => 'Username atau Password Salah.', 
                    ]);
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

    public function doregister()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'user_name'         => 'required',
                'user_email'        => 'required|valid_email|is_unique[tb_user.user_email]',
                'user_phone'        => 'required|is_unique[tb_user.user_phone]',
                'user_faskes'       => 'required',
                'user_password'     => 'required|min_length[8]|max_length[50]',
                'confirm_password'  => 'required|matches[user_password]',
            ];
    
            $errors = [
                'user_name' => [
                    'required'    => 'Nama harus diisi.',
                ],
                'user_email' => [
                    'required'    => 'Email harus diisi.',
                    'valid_email' => 'Penulisan email harus benar',
                    'is_unique'   => 'Email sudah terdaftar', 
                ],
                'user_phone' => [
                    'required'    => 'No. HP harus diisi.',
                    'is_unique'   => 'No. HP sudah terdaftar', 
                ],
                'user_faskes' => [
                    'required'    => 'Faskes harus dipilih.',
                ],
                'user_password' => [
                    'required'   => 'Password harus diisi.',
                    'min_length' => 'Password minimal memiliki panjang 8 character.',
                    'max_length' => 'Password maximal memiliki panjang 50 character.'
                ],
                'confirm_password' => [
                    'required'   => 'Konfirmasi Password harus diisi.',
                    'matches'    => 'Konfirmasi Password tidak sesuai.'
                ]
            ];

            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'user_name'         => $validation->getError('user_name'),
                        'user_email'        => $validation->getError('user_email'),
                        'user_phone'        => $validation->getError('user_phone'),
                        'user_faskes'       => $validation->getError('user_faskes'),
                        'user_password'     => $validation->getError('user_password'),
                        'confirm_password'  => $validation->getError('confirm_password'),
                    ]   
                ];
            } else {

				$patient_code		= $this->generate_patient_code();

				$this->db->transStart();
				$newPatient = [
					'patient_code' 		 => $patient_code
				];
				$this->patient->insert($newPatient);
                $newUser = [
                    'user_email'         => strtolower($this->request->getVar('user_email')),
                    'user_password'      => password_hash($this->request->getVar('user_password'), PASSWORD_BCRYPT),
                    'user_role'          => 1011,
                    'user_faskes'        => $this->request->getVar('user_faskes'),
					'user_patient'		 => $patient_code,
                    'user_create'        => date('Y-m-d H:i:s'),
                    'user_active'        => 'f',
                    'user_photo'         => 'default.png',
                    'user_name'          => $this->request->getVar('user_name'),
					'user_phone'		 => $this->request->getVar('user_phone'),
					'user_otp' 			 => rand(1000, 9999),
					'user_otp_active'    => date('Y-m-d H:i:s', strtotime('+2 minutes', strtotime(date('Y-m-d H:i:s')))),
					'user_username' 	 => $patient_code
                ];
                $this->user->insert($newUser);
				$this->db->transComplete();

                $response = [
                    'success' => true,
                    'code'    => '200',
                    'data'    => [
                        'link' => 'login'
                    ], 
                    'message' => 'Berhasil, Redirect...', 
                ];
            }
            echo json_encode($response);
        }
	}

    public function logout()
    {
        if ($this->request->isAJAX()) {

            set_cookie('gem','logout');

            $response = [
                'success' => true,
                'code'    => '200',
                'data'    => [
                    'link' => 'login'
                ], 
                'message' => 'Berhasil, Redirect...', 
            ];

            echo json_encode($response);
        }
        
    }
	
}