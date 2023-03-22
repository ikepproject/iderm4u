<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Patient extends BaseController
{
	public function index()
	{
		$user = $this->userauth(); //Return array
		$data = [
			'title'  => 'Pasien',
			'user'   => $user,
		];
		return view('panel_faskes/patient/index', $data);
	}

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); //Return array
            $user_faskes = $user['user_faskes'];
            $data = [
                'list' => $this->user->list_patient($user_faskes)
            ];
            $response = [
                'data' => view('panel_faskes/patient/list', $data)
            ];
            echo json_encode($response);
        }
    }

	public function formadd()
    {
        if ($this->request->isAJAX()) {
            $user = $this->userauth(); //Return array
            $data = [
                'title' => 'Tambah Pasien',
                'user'   => $user,
            ];
            $response = [
                'data' => view('panel_faskes/patient/add', $data)
            ];
            echo json_encode($response);
        }
    }

    public function formdetail()
    {
        if ($this->request->isAJAX()) {
            $user_id = $this->request->getVar('user_id');
            $profile = $this->user->find_patient($user_id);
            $data = [
                'title'     => 'Profile Pasien',
                'profile'   => $profile,
                'medical'   => $this->medical->list_by_user($user_id)
            ];
            $response = [
                'data' => view('panel_faskes/patient/detail', $data)
            ];
            echo json_encode($response);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $user_id = $this->request->getVar('user_id');
            $profile = $this->user->find_patient($user_id);
            $data = [
                'title'     => 'Edit Data Pasien',
                'profile'   => $profile,
            ];
            $response = [
                'data' => view('panel_faskes/patient/edit', $data)
            ];
            echo json_encode($response);
        }
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'patient_name'      => 'required',
                'patient_gender'    => 'required',
                'patient_birth'     => 'required',
                'patient_type'      => 'required',
                'user_email'        => 'required|valid_email|is_unique[tb_user.user_email]',
                'user_phone'        => 'required|is_unique[tb_user.user_phone]',
            ];
    
            $errors = [
                'patient_code' => [
                    'required'    => 'ID Pasien harus diisi.',
                    'is_unique'   => 'ID Pasien sudah terdaftar', 
                ],
                'patient_name' => [
                    'required'    => 'Nama Pasien harus diisi.',
                ],
                'patient_gender' => [
                    'required'   => 'Jenis Kelamin harus dipilih.',
                ],
                'patient_birth' => [
                    'required'   => 'Tgl Lahir harus diisi.',
                ],
                'patient_type' => [
                    'required'   => 'Kategori Pasien harus dipilih.',
                ],
                'user_email' => [
                    'required'   => 'Email Pasien harus diisi.',
                    'valid_email' => 'Email Pasien harus berformat email',
                    'is_unique'  => 'Email Pasien sudah terdaftar', 
                ],
                'user_phone' => [
                    'required'   => 'No. WA harus diisi.',
                    'is_unique'  => 'No. WA sudah terdaftar', 
                ],
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'patient_code'      => $validation->getError('patient_code'),
                        'patient_name'      => $validation->getError('patient_name'),
                        'patient_gender'    => $validation->getError('patient_gender'),
                        'patient_birth'     => $validation->getError('patient_birth'),
                        'patient_type'      => $validation->getError('patient_type'),
                        'user_email'        => $validation->getError('user_email'),
                        'user_phone'        => $validation->getError('user_phone'),
                    ]
                ];
            } else {

                $patient_code		        = $this->generate_patient_code();
                $user_faskes                = $this->request->getVar('user_faskes');

                $userPhoto  = $this->request->getFile('user_photo');
                if ($userPhoto->getName()!= NULL) {
                    //Get Datetime now
                    $namePhoto   = $patient_code . '_' . date("YmdHis") . '_' . $userPhoto->getName();
                    $user_photo  = $namePhoto;
                    \Config\Services::image()
                        ->withFile($userPhoto)
                        ->fit(250, 250, 'center')
                        ->save('public/assets/images/users/' . $namePhoto);
                } else {
                    $user_photo = 'default.png';
                }

                if ($user_faskes == 'MC01') {
                    $password = 'mcits2023';
                }

                if ($user_faskes == 'ESTD') {
                    $password = 'estdps2023';
                }

                if ($user_faskes == 'MKSR') {
                    $password = 'makasar2023';
                }

                if ($user_faskes == 'RSUA') {
                    $password = 'rsua23iderm';
                }

                $newPatient = [
                    'patient_code'         => $patient_code,
                    'patient_name'         => $this->request->getVar('patient_name'),
                    'patient_gender'       => $this->request->getVar('patient_gender'),
                    'patient_type'         => $this->request->getVar('patient_type'),
                    'patient_birth'        => $this->request->getVar('patient_birth'),
                    'patient_address'      => trim($this->request->getVar('patient_address')),
                    'patient_other'        => trim($this->request->getVar('patient_other')),
                    'patient_create'       => date('Y-m-d H:i:s'),
                ];

                $newUser = [
                    'user_email'         => strtolower($this->request->getVar('user_email')),
                    'user_password'      => password_hash($password, PASSWORD_BCRYPT),
                    'user_role'          => 1011,
                    'user_faskes'        => $this->request->getVar('user_faskes'),
                    'user_patient'       => $patient_code,
                    'user_create'        => date('Y-m-d H:i:s'),
                    'user_active'        => 't',
                    'user_photo'         => $user_photo,
                    'user_name'          => $this->request->getVar('patient_name'),
                    'user_phone'         => $this->request->getVar('user_phone'),
                    'user_nik'           => $this->request->getVar('user_nik'),
                    'user_username'      => $patient_code,
                ];

                $this->db->transStart();
                $this->patient->insert($newPatient);
                $this->user->insert($newUser);
                $this->db->transComplete();

                $response = [
                    'success' => 'Data Berhasil Disimpan'
                ];
            }
            echo json_encode($response);
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'edit_patient_name'      => 'required',
                'edit_patient_gender'    => 'required',
                'edit_patient_birth'     => 'required',
                'edit_patient_type'      => 'required',
                'edit_user_email'        => 'required',
                'edit_user_phone'        => 'required',
            ];
    
            $errors = [
                'edit_patient_name' => [
                    'required'    => 'Nama Pasien harus diisi.',
                ],
                'edit_patient_gender' => [
                    'required'   => 'Jenis Kelamin harus dipilih.',
                ],
                'edit_patient_birth' => [
                    'required'   => 'Tgl Lahir harus diisi.',
                ],
                'edit_patient_type' => [
                    'required'   => 'Kategori Pasien harus dipilih.',
                ],
                'edit_user_email' => [
                    'required'   => 'Email harus diisi.',
                ],
                'edit_user_phone' => [
                    'required'   => 'No. WA harus diisi.',
                ],
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'edit_patient_name'      => $validation->getError('edit_patient_name'),
                        'edit_patient_gender'    => $validation->getError('edit_patient_gender'),
                        'edit_patient_birth'     => $validation->getError('edit_patient_birth'),
                        'edit_patient_type'      => $validation->getError('edit_patient_type'),
                        'edit_user_email'        => $validation->getError('edit_user_email'),
                        'edit_user_phone'        => $validation->getError('edit_user_phone'),
                    ]
                ];
            } else {
                $patient_code = $this->request->getVar('patient_code');
                $updatePatient = [
                    'patient_name'         => $this->request->getVar('edit_patient_name'),
                    'patient_gender'       => $this->request->getVar('edit_patient_gender'),
                    'patient_type'         => $this->request->getVar('edit_patient_type'),
                    'patient_birth'        => $this->request->getVar('edit_patient_birth'),
                    'patient_phone'        => $this->request->getVar('edit_patient_phone'),
                    'patient_address'      => $this->request->getVar('edit_patient_address'),
                    'patient_other'        => $this->request->getVar('edit_patient_other'),
                    'patient_edit'         => date('Y-m-d H:i:s'),
                ];
                
                $userPhoto      = $this->request->getFile('edit_user_photo');
                $user_photo_old = $this->request->getVar('user_photo_old');
                if ($userPhoto->getName()!= NULL) {
                    //Get Datetime now
                    $date        = date("Y-m-d");
                    $time        = date("H-i-s");
                    $namePhoto   = $this->request->getVar('patient_code') . '_' . date("YmdHis") . '_' . $userPhoto->getName();
                    $user_photo  = $namePhoto;
                    if ($user_photo_old != 'default.png') {
                        unlink('public/assets/images/users/' . $user_photo_old);
                    }
                    
                    \Config\Services::image()
                        ->withFile($userPhoto)
                        ->fit(250, 250, 'center')
                        ->save('public/assets/images/users/' . $namePhoto);
                } else {
                    $user_photo = $user_photo_old;
                }

                $user_id = $this->request->getVar('user_id');
                $updateUser = [
                    'user_edit'          => date('Y-m-d H:i:s'),
                    'user_photo'         => $user_photo,
                    'user_name'          => $this->request->getVar('edit_patient_name'),
                    'user_email'         => $this->request->getVar('edit_user_email'),
                    'user_phone'         => $this->request->getVar('edit_user_phone'),
                    'user_nik'           => $this->request->getVar('edit_user_nik'),
                ];

                $this->db->transStart();
                $this->patient->update($patient_code, $updatePatient);
                $this->user->update($user_id, $updateUser);
                $this->db->transComplete();

                $response = [
                    'success' => 'Data Berhasil Diupdate'
                ];
            }
            echo json_encode($response);
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {

            $user_id      = $this->request->getVar('user_id');
            $patient_code = $this->request->getVar('patient_code');
            //check
            $check_medical= $this->medical->where('medical_user', $user_id)->countAllResults();
            if ($check_medical == 0) {
                $user         = $this->user->find($user_id);
                $user_photo   = $user['user_photo'];

                if ($user_photo != 'default.png') {
                    unlink('public/assets/images/users/' . $user_photo);
                }

                $this->user->delete($user_id);
                $this->patient->delete($patient_code);

                $response = [
                    'success' => true,
                    'icon'    => 'success',
                    'message' => 'Data Berhasil Dihapus.',
                ];
            } else {
                $response = [
                    'success' => true,
                    'icon'    => 'error',
                    'message' => 'Data Gagal Dihapus. Pasien memiliki data kunjungan.', 
                ];
            }
            echo json_encode($response);
        }
    }

    public function tes()
    {
        // $tes = $this->user->orderBy('user_id', 'desc')->first(); // get highest id
        // $tes = substr('TR-MC-00001', -5); // get last 5 char
        // $tes2 = substr('TR-MC-00001',0, 6); // get 6 first char
        // $s = '51';
        // $p = $tes + 1;
        // $k = str_pad($p,5,"0",STR_PAD_LEFT); // get 0000X, -> x is result from summary
        // $n = $tes2 . $k;
        // $d = date('Ymd');
        // $f = 'K' . 'MC' . '-' . $d . '-' . $k;

        // $date = date('Y-m-d H:i:s');
        // $dt = strtok($date, ' '); // get char before space
        // $dt = explode(' ', $date); // get char use explode, result is array
        // // $a = $this->treatment->orderBy('treatment_code', 'desc')->first();
        
        // $config         = new \Config\Encryption();
        // // $config->driver = 'OpenSSL';
        // // Your CI3's encryption_key
        // $config->key            = getenv("encrypt_key");
        // // $config->rawData = false;

        // // ENCRYPTION
        // $encrypter = \Config\Services::encrypter($config, false);
        // $plainText  = 'xnd_development_tc6PAc89hlleb6sGvzLhEO653zJvLXRUgUaXaR4x55qBvR0JUx2LX7LyhVslq';
        // $enc = $encrypter->encrypt($plainText);
        // $enc2 = base64_encode($enc);
        // $dec = $encrypter->decrypt(base64_decode($enc2));
        // $d1 = [
        //     'employee_code' => 'tes',
        // ];

        // // Transaction
        // $db      = \Config\Database::connect();
        // $db->transStart();
        // $this->employee->insert($d1);
        // $tes = 'ss';
        // $db->transComplete();

        // $t = date('Y-m-d\TH:i:s.Z\Z', time());
        
        //Add time
        // $convertedTime = date('Y-m-d H:i:s', strtotime('+20 minutes', strtotime(date('Y-m-d H:i:s'))));
        // var_dump(date($convertedTime));
    }
}