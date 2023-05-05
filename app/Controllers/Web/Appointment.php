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
            

            $data = [
                'title'         => 'Form Penjadwalan Appointment ' . $type,
                'type'          => $type,
                'appointment'   => $this->appointment->find_medical($medical_code),

            ];
            $response = [
                'data' => view('panel_faskes/appointment/accept', $data)
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

}
