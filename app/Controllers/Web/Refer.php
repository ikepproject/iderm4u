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

                $refer_type         = $this->request->getVar('medical_refer_type');
                $amount             = $faskes_refer_price; 
                $medical_code       = $this->generate_medical_code_rujukan($faskes_code, $faskes_initial);
                $appointment_code   = $this->generate_appointment_code_rujukan($faskes_code, $faskes_initial);

                $newMedical = [
                    'medical_code'         => $medical_code,
                    'medical_faskes'       => $faskes_code,
                    'medical_user'         => $this->request->getVar('medical_user'),
                    'medical_employee'     => $user['user_name'],
                    'medical_create'       => date('Y-m-d H:i:s'),
                    'medical_status'       => 'Proses',
                    'medical_creator_type' => 'Admin',
                    'medical_refer_type'   => $refer_type,
                    'medical_refer_origin' => $user['user_faskes'],
                    'medical_refer_code'   => $this->request->getVar('medical_refer_code'),
                ];

                $newAppointment = [
                    'appointment_code'     => $appointment_code,
                    'appointment_faskes'   => $faskes_code,
                    'appointment_user'     => $this->request->getVar('medical_user'),
                    'appointment_status'   => 'Diajukan',
                    'appointment_create'   => date('Y-m-d H:i:s'),
                    'appointment_type'     => $refer_type,
                    'appointment_medical'  => $medical_code,
                    'appointment_note_user'=> $this->request->getVar('appointment_note_user'),
                ];

                //Transaction Start
                $this->db->transStart();
                $this->medical->insert($newMedical);
                $this->appointment->insert($newAppointment);
                if ($refer_type == 'Teledermatologi') {

                    $invoice_method = $this->request->getVar('invoice_method');

                    if ($invoice_method == 'VA') {
                        $invoice_admin_fee = 4000;
                    } elseif ($invoice_method == 'E-WALLET') {
                        $invoice_admin_fee = $amount * 0.02;
                    } elseif ($invoice_method == 'QR') {
                        $invoice_admin_fee = $amount * 0.007;
                    } elseif ($invoice_method == NULL) {
                        $invoice_method == 'QR';
                        $invoice_admin_fee = $amount * 0.007;
                    }

                    $amount            = $amount + $invoice_admin_fee;
                    $invoice_code      = 'INV-' . $faskes_initial . '-'  . $this->request->getVar('medical_user') .date('YmdHis');
                    $invoice_method    = 
                    $newInvoice = [
                        'invoice_code'      => $invoice_code,
                        'invoice_medical'   => $medical_code,
                        'invoice_amount'    => $amount,
                        'invoice_method'    => $invoice_method,
                        'invoice_status'    => 'PENDING',
                        'invoice_admin_fee' => $invoice_admin_fee,
                    ];
                    $this->invoice->insert($newInvoice);
                }
                $this->db->transComplete();
                //Transaction Complete

                $response = [
                    'success' => 'Data Berhasil Dirujuk',
                    'link'    => 'medical', 
                ];
            }
            echo json_encode($response);
        }
    }
}
