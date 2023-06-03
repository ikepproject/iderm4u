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
		return view('panel_faskes/refer_clinic/index', $data);
	}

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); //Return array
            $user_faskes = $user['user_faskes'];

            $list_kunjungan         = $this->medical->list_refer_klinik_kunjungan($user_faskes);
            $list_teledermatologi   = $this->medical->list_refer_klinik_teledermatologi($user_faskes);
            $list_storefoward       = $this->medical->list_refer_klinik_storefoward($user_faskes);

            $data = [
                'list_kunjungan'       => $list_kunjungan,
                'list_teledermatologi' => $list_teledermatologi,
                'list_storefoward'     => $list_storefoward,
            ];

            $response = [
                'data' => view('panel_faskes/refer_clinic/list', $data)
            ];
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
            ];
    
            $errors = [
                'medical_refer_type' => [
                    'required'    => 'Tipe Rujukan dipilih.',
                ],
                'medical_faskes' => [
                    'required'    => 'Faskes Rujukan harus dipilih.',
                ],
                'appointment_date_expect' => [
                    'required'    => 'Waktu perkiraan kunjungan harus diisi.',
                ],
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'medical_refer_type'    => $validation->getError('medical_refer_type'),
                        'medical_faskes'        => $validation->getError('medical_faskes'),
                    ]
                ];
            } else {
                $user               = $this->userauth(); 
                $faskes_code        = $this->request->getVar('medical_faskes');
                $faskes             = $this->faskes->find($faskes_code);
                $faskes_initial     = $faskes['faskes_initial'];
                $faskes_refer_price = $faskes['faskes_refer_price'];
                $faskes_refersf_price = $faskes['faskes_refersf_price'];

                $refer_type         = $this->request->getVar('medical_refer_type');
                
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
                    'appointment_code'          => $appointment_code,
                    'appointment_faskes'        => $faskes_code,
                    'appointment_user'          => $this->request->getVar('medical_user'),
                    'appointment_status'        => 'Diajukan',
                    'appointment_create'        => date('Y-m-d H:i:s'),
                    'appointment_type'          => $refer_type,
                    'appointment_medical'       => $medical_code,
                    'appointment_date_expect'   => $this->request->getVar('appointment_date_expect'),
                    'appointment_note_user'     => trim(preg_replace('/\s\s+/', ' ', $this->request->getVar('appointment_note_user'))),
                ];

                //Transaction Start
                $this->db->transStart();
                $this->medical->update($this->request->getVar('medical_refer_code'), $updateMedical);
                $this->medical->insert($newMedical);
                if ($refer_type == 'Kunjungan' || $refer_type == 'Teledermatologi') {
                    $this->appointment->insert($newAppointment);
                }
                if ($refer_type == 'Kunjungan') {
                    $invoice_code      = 'INV-' . $faskes_initial . '-'  . $this->request->getVar('medical_user') .date('YmdHis');
                    $newInvoice = [
                        'invoice_code'      => $invoice_code,
                        'invoice_medical'   => $medical_code,
                        'invoice_status'    => 'PENDING',
                    ];
                    $this->invoice->insert($newInvoice);
                }
                if ($refer_type == 'Teledermatologi' || $refer_type == 'StoreFoward') {

                    if ($refer_type == 'Teledermatologi') {
                        $refer_price         = $faskes_refer_price;
                        $medoth_name    = 'Teledermatologi';    
                    }elseif ($refer_type == 'StoreFoward') {
                        $refer_price         = $faskes_refersf_price;
                        $medoth_name    = 'StoreFoward'; 
                    }

                    $invoice_method    = $this->request->getVar('invoice_method');

                    $invoice_admin_fee = $this->transaction_fee($invoice_method, $refer_price);

                    $amount            = $refer_price + $invoice_admin_fee;
                    $invoice_code      = 'INV-' . $faskes_initial . '-'  . $this->request->getVar('medical_user') .date('YmdHis');
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
                        'medoth_name'     => $medoth_name,
                        'medoth_qty'      => 1,
                        'medoth_price'    => $refer_price
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
