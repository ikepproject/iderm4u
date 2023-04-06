<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Refer extends BaseController
{
    public function index()
	{
		$user = $this->userauth(); //Return array
		$data = [
			'title'  => 'Rujukan',
			'user'   => $user,
		];
		return view('panel_faskes/refer/index', $data);
	}

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); //Return array
            $user_faskes = $user['user_faskes'];
            $faskes      = $this->faskes->find($user_faskes);
            $faskes_type = $faskes['faskes_type'];
            if ($faskes_type == "Klinik") {
                $list_kunjungan         = $this->medical->list_refer_klinik_kunjungan($user_faskes);
                $list_teledermatologi   = $this->medical->list_refer_klinik_teledermatologi($user_faskes);
            } elseif ($faskes_type == "Rumah Sakit") {
                $list    = $this->medical->list_refer_rs($user_faskes);
            }
            
            if ($faskes_type == "Klinik") {
                $data = [
                    'list_kunjungan'       => $list_kunjungan,
                    'list_teledermatologi' => $list_teledermatologi,
                ];
                $response = [
                    'data' => view('panel_faskes/refer/list_klinik', $data)
                ];

            } elseif ($faskes_type == "Rumah Sakit") {
                $data = [
                    'list' => $list,
                ];
                $response = [
                    'data' => view('panel_faskes/refer/list_rs', $data)
                ];
            }
            
            echo json_encode($response);
        }
    }

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

                $updateMedical = [
                    'medical_refer_type'   => $refer_type,
                ];

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
                $this->medical->update($this->request->getVar('medical_refer_code'), $updateMedical);
                $this->medical->insert($newMedical);
                $this->appointment->insert($newAppointment);
                if ($refer_type == 'Teledermatologi') {

                    $invoice_method = $this->request->getVar('invoice_method');

                    $invoice_admin_fee = $this->transaction_fee($invoice_method, $amount);

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

                    $newMedoth = [
                        'medoth_medical'  => $medical_code,
                        'medoth_name'     => 'Teledermatologi',
                        'medoth_qty'      => 1,
                        'medoth_price'    => $faskes_refer_price
                    ];
                    $this->medoth->insert($newMedoth);
                    
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
