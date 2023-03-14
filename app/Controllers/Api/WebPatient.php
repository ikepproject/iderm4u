<?php

namespace App\Controllers\Api;
use App\Libraries\JWTCI4;
use App\Models\Model_User;

use CodeIgniter\RESTful\ResourceController;

class WebPatient extends ResourceController
{
    protected $helpers = ['form', 'url', 'cookie'];

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
        $tb_user    = new Model_User;
		$user       = $tb_user->where('user_email', $this->request->getVar('email'))->first();
		if( $user )
		{
			if( password_verify($this->request->getVar('password'), $user['user_password']) )
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

    public function register()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'name'              => 'required',
                'email'             => 'required|valid_email|is_unique[tb_user.user_email]',
                'faskes'            => 'required',
                'password'          => 'required|min_length[8]|max_length[50]',
                'confirm_password'  => 'required|matches[password]',
            ];
    
            $errors = [
                'name' => [
                    'required'    => 'Nama harus diisi.',
                ],
                'email' => [
                    'required'    => 'Email harus diisi.',
                    'valid_email' => 'Penulisan email harus benar',
                    'is_unique'   => 'Email sudah terdaftar', 
                ],
                'faskes' => [
                    'required'    => 'Faskes harus dipilih.',
                ],
                'password' => [
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
                        'name'              => $validation->getError('name'),
                        'email'             => $validation->getError('email'),
                        'faskes'            => $validation->getError('faskes'),
                        'password'          => $validation->getError('password'),
                        'confirm_password'  => $validation->getError('confirm_password'),
                    ]   
                ];
            } else {

                $newData = [
                    'user_email'         => $this->request->getVar('email'),
                    'user_password'      => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                    'user_role'          => 1011,
                    'user_faskes'        => $this->request->getVar('faskes'),
                    'user_create'        => date('Y-m-d H:i:s'),
                    'user_active'        => 'f',
                    'user_photo'         => 'default.png',
                    'user_name'          => $this->request->getVar('name'),

                ];
                // $newData['id'] = $tb_user->save($newData); -> Get id data after insert
                $tb_user            = new Model_User;
                $tb_user->insert($newData);

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

    public function userauth(){
		$token   = get_cookie('gem');
		$jwt     = new JWTCI4;
		$user	 = $jwt->decodeweb($token);
		$user_id = $user->uid;
        $tb_user = new Model_User;
		$userdata= $tb_user->find($user_id);
		return $userdata;
	}

    public function get()
    {
        $user        = $this->userauth();
        $user_faskes = $user['user_faskes'];
                
        $tb_user     = new Model_User;
        // $data = $tb_user->api_list_patient($user_faskes);
        // if ($this->request->getVar('term', TRUE)) {
		// 	$data = $tb_user->api_list_patient_like($user_faskes, $this->request->getVar('term', TRUE));
		// } else {
        //     $tb_user->api_list_patient($user_faskes);
        // }
        // $item = $tb_user->api_list_patient($user_faskes);
        // $total= $tb_user->api_total_patient($user_faskes);
        if ($this->request->getPost('searchTerm', TRUE)) {
			$item = $tb_user->api_list_patient_like($user_faskes, $this->request->getPost('searchTerm', TRUE));
		} else {
            $item = $tb_user->api_list_patient($user_faskes);
        }
        $data = [
            "items" => $item,
        ];

        return $this->response->setJSON($data);
    }
    
}
