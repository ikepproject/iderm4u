<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Appointment extends BaseController
{
    public function index()
	{
		$user = $this->userauth(); //Return array
		$data = [
			'title'  => 'Produk Order (PO)',
			'user'   => $user,
		];
		return view('panel_faskes/appointment/index', $data);
	}

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); //Return array
            $user_faskes = $user['user_faskes'];
            $list        = $this->appointment->list($user_faskes);

            $data = [
                'list' => $list,
            ];

            $response = [
                'data' => view('panel_faskes/appointment/list', $data)
            ];
            
            echo json_encode($response);
        }
    }

    public function formaccept()
    {
        if ($this->request->isAJAX()) {
            $modul         = $this->request->getVar('modul');
            if ($modul == 'refer') {
                $medical_code       = $this->request->getVar('medical_code');
                $medical            = $this->medical->find($medical_code);
                $medical_refer_type = $medical['medical_refer_type'];

                if ($medical_refer_type == NULL) {
                    $type     = 'Kunjungan Pasien';
                } elseif($medical_refer_type == 'Kunjungan') {
                    $type     = 'Kunjungan Rujukan';
                } else {
                    $type     = $medical_refer_type;
                }

                $appointment =  $this->appointment->find_medical($medical_code);
            } else {
                $type           = 'Kunjungan Pasien';
                $appointment_id = $this->request->getVar('appointment_id');
                $appointment    =  $this->appointment->find_id($appointment_id);
            }
            
            $data = [
                'title'         => 'Form Penjadwalan Appointment ' . $type,
                'type'          => $type,
                'appointment'   => $appointment,

            ];
            $response = [
                'data' => view('panel_faskes/appointment/accept', $data)
            ];
            echo json_encode($response);
        }
    }

    public function formdetail()
    {
        if ($this->request->isAJAX()) {
            $appointment_id         = $this->request->getVar('appointment_id');
            
            
            $data = [
                'title'         => 'Detail Penjadwalan Appointment ',
                'appointment'   => $this->appointment->find_id($appointment_id),

            ];
            $response = [
                'data' => view('panel_faskes/appointment/detail', $data)
            ];
            echo json_encode($response);
        }
    }

    public function accept()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'appointment_fix_date'    => 'required',
                'appointment_fix_time'    => 'required',
            ];
    
            $errors = [
                'appointment_fix_date' => [
                    'required'   => 'Tgl Penjadwalan harus diisi.',
                ],
                'appointment_fix_time' => [
                    'required'   => 'Waktu Penjadwalan harus diisi.',
                ],
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'appointment_fix_date'      => $validation->getError('appointment_fix_date'),
                        'appointment_fix_time'      => $validation->getError('appointment_fix_time'),
                    ]
                ];
            } else {
                $appointment_id = $this->request->getVar('appointment_id');
                $medical_code   = $this->request->getVar('appointment_medical');

                $update = [
                    'appointment_status'        => 'Dijadwalkan',
                    'appointment_date_fix'      => $this->request->getVar('appointment_fix_date').' '.$this->request->getVar('appointment_fix_time'),
                    'appointment_link'          => $this->request->getVar('appointment_link'),
                    'appointment_note_faskes'   => trim(preg_replace('/\s\s+/', ' ', $this->request->getVar('appointment_note_faskes'))),
                ];

                $this->appointment->update($appointment_id, $update);

                $response = [
                    'success' => 'Appointment Dijadwalkan '
                ];
            }
            echo json_encode($response);
        }
    }

    public function index_patient()
	{
		$user        = $this->userauth(); //Return array
        $user_id     = $user['user_id'];
		$data = [
			'title'  => 'Data Appointment',
			'user'   => $user,
            'pending'=> $this->appointment->appointment_pending($user_id),
		];
		return view('panel_patient/appointment/index', $data);
	}

    public function getdata_patient()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); //Return array
            $user_id     = $user['user_id'];
            $list        = $this->appointment->list_patient($user_id);

            $data = [
                'list' => $list,
            ];

            $response = [
                'data' => view('panel_patient/appointment/list', $data)
            ];
            
            echo json_encode($response);
        }
    }

    public function formadd_patient()
    {
        if ($this->request->isAJAX()) {

            $user               = $this->userauth();
            $user_name          = $user['user_name']; 

            $data = [
                'title'       => 'Form Pengajuan Janji Temu (Appointment)',
                'user_name'   => $user_name,

            ];
            $response = [
                'data' => view('panel_patient/appointment/add', $data)
            ];
            echo json_encode($response);
        }
    }

    public function create_patient()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'appointment_date_expect'    => 'required',
            ];
    
            $errors = [
                'appointment_date_expect' => [
                    'required'   => 'Tgl Estimasi Kunjungan harus diisi.',
                ],
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'appointment_date_expect'      => $validation->getError('appointment_date_expect'),
                    ]
                ];
            } else {
                $user               = $this->userauth();
                $user_id            = $user['user_id']; 
                $faskes_code        = $user['user_faskes'];
                $faskes             = $this->faskes->find($faskes_code);
                $faskes_initial     = $faskes['faskes_initial'];
                $appointment_code   = $this->generate_appointment_code_rujukan($faskes_code, $faskes_initial);
                $new = [
                    'appointment_code'          => $appointment_code,
                    'appointment_faskes'        => $faskes_code,
                    'appointment_user'          => $user_id,
                    'appointment_status'        => 'Diajukan',
                    'appointment_create'        => date('Y-m-d H:i:s'),
                    'appointment_type'          => 'Lokal',
                    'appointment_medical'       => NULL,
                    'appointment_date_expect'   => $this->request->getVar('appointment_date_expect'),
                    'appointment_note_user'     => trim(preg_replace('/\s\s+/', ' ', $this->request->getVar('appointment_note_user'))),

                ];
                $this->appointment->insert($new);

                $response = [
                    'success' => 'Data Berhasil Disimpan'
                ];
            }
            echo json_encode($response);
        }
    }

    public function cancel()
    {
        if ($this->request->isAJAX()) {

            $appointment_id = $this->request->getVar('appointment_id');

            $this->db->transStart();
            $this->appointment->delete($appointment_id);
            $this->db->transComplete();

            $response = [
                'success' => 'Appointment Dibatalkan'
            ];

            echo json_encode($response);
        }
    }

}
