<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Account extends BaseController
{
	public function index()
	{
		$user 					= $this->userauth(); // Return Object
		$user_id 				= $user['user_id'];
		$user_role 				= $user['user_role'];

		if ($user_role == '1011') {
			$profile = $this->user->find_patient($user_id);
		} else {
			$profile = $this->user->find($user_id);
		}

		$data = [
			'title' 	=> 'Pengaturan Akun',
			'user'  	=> $user,
			'profile'	=> $profile,
			'user_role' => $user_role,
		];
		return view('panel/account', $data);
	}

	public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'old_password'    => 'required',
                'new_password'    => 'required|min_length[8]|max_length[50]',
            ];
    
            $errors = [
                'old_password' => [
                    'required'   => 'Password lama harus diisi.',
                ],
                'new_password' => [
                    'required'   => 'Password baru harus diisi.',
					'min_length' => 'Password minimal memiliki panjang 8 character.',
                    'max_length' => 'Password maximal memiliki panjang 50 character.'
                ],
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'old_password'      => $validation->getError('old_password'),
                        'new_password'      => $validation->getError('new_password'),
                    ]
                ];
            } else {
				$user_id = $this->request->getVar('user_id');
                $user 	 = $this->user->find($user_id);
				if (password_verify($this->request->getVar('old_password'), $user['user_password'])) {
					$update = [
						'user_password'        => password_hash($this->request->getVar('new_password'), PASSWORD_BCRYPT),
					];
	
					$this->user->update($user_id, $update);
					set_cookie('gem','logout');
					$response = [
						'success' => 'Password Berhasil Diupdate',
						'title'   => 'Berhasil',
						'text'    => 'Berhasil diupdate',
						'icon'	  => 'success',
						'link'	  => '/login'
					];
				} else {
					$response = [
						'success' => 'Password Lama Tidak Cocok',
						'title'   => 'Error',
						'text'    => 'Password Lama Tidak Cocok',
						'icon'	  => 'error',
						'link'	  => '/account'
					];
				}
				

                
            }
            echo json_encode($response);
        }
    }
}