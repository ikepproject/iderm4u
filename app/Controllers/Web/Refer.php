<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Refer extends BaseController
{
    public function create()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'medical_refer_type'    => 'required',
                'medical_faskes'        => 'required',
                'appointment_note_user' => 'required',
            ];
    
            $errors = [
                'medical_refer_type' => [
                    'required'    => 'Tipe Rujukan dipilih.',
                ],
                'medical_faskes' => [
                    'required'    => 'Faskes Rujukan harus dipilih.',
                ],
                'appointment_note_user' => [
                    'required'    => 'Waktu yang Diharapkan dan Catatan Lain harus diisi.',
                ],
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'medical_refer_type'    => $validation->getError('medical_refer_type'),
                        'medical_faskes'        => $validation->getError('medical_faskes'),
                        'appointment_note_user' => $validation->getError('appointment_note_user'),
                    ]
                ];
            } else {
                $user               = $this->userauth(); 
                $faskes_code        = $this->request->getVar('medical_faskes');
                $faskes             = $this->faskes->find($faskes_code);
                $faskes_initial     = $faskes['faskes_initial'];
                $faskes_refer_price = $faskes['faskes_refer_price'];

                $amount             = $faskes_refer_price; 
                $medical_code       = $this->generate_medical_code_rujukan($faskes_code, $faskes_initial);
                var_dump($medical_code);

                $newMedical = [
                    'medical_code'         => $medical_code,
                    'medical_faskes'       => $faskes_code,
                    'medical_user'         => $this->request->getVar('medical_user'),
                    'medical_employee'     => $user['user_name'],
                    'medical_create'       => date('Y-m-d H:i:s'),
                    'medical_status'       => 'Proses',
                    'medical_creator_type' => 'Admin',
                    'medical_refer_type'   => $this->request->getVar('medical_refer_type'),
                    'medical_refer_origin' => $user['user_faskes'],
                    'medical_refer_code'   => $this->request->getVar('medical_refer_code'),
                ];

                // $newAppointment = [
                //     'appointment_code' => generate code
                //     appointment_faskes => faskes RS dituju
                //     appointment_user => user_id pasien
                //     appointment_status => Diajukan
                //     appointment_create => Y-m-d H:i:s
                //     appointment_date_expect  (timestamp) => NULL
                //     appointment_date_fix     (timestamp) => NULL
                //     appointment_type => Kunjungan
                //     appointment_medical => from medical code above
                //     appointment_link => NULL
                //     appointment_note_user => ekspektasi tanggal
                //     appointment_note_faskes => NULL
                // ];

                $this->db->transStart();
                // $this->appointment->insert($newAppointment);
                $this->medical->insert($newMedical);
                $this->db->transComplete();

                $response = [
                    'success' => 'Data Berhasil Dirujuk',
                    'link'    => 'medical', 
                ];
            }
            echo json_encode($response);
        }
    }
}
