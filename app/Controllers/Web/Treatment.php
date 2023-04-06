<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Treatment extends BaseController
{
	public function index()
	{
		$user = $this->userauth(); // Return Object
		$data = [
			'title'  => 'Treatment',
			'user'   => $user,
		];
		return view('panel_faskes/treatment/index', $data);
	}

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); // Return Object
            $user_faskes = $user['user_faskes'];
            $data = [
                'list' => $this->treatment->list($user_faskes)
            ];
            $response = [
                'data' => view('panel_faskes/treatment/list', $data)
            ];
            echo json_encode($response);
        }
    }

	public function formadd()
    {
        if ($this->request->isAJAX()) {
            $user = $this->userauth(); // Return Object
            $data = [
                'title' => 'Tambah Treatment',
                'user'   => $user,
            ];
            $response = [
                'data' => view('panel_faskes/treatment/add', $data)
            ];
            echo json_encode($response);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $treatment_code = $this->request->getVar('treatment_code');
            $treatment      = $this->treatment->find($treatment_code);
            $data = [
                'title'     => 'Edit Data Treatment',
                'treatment' => $treatment,
            ];
            $response = [
                'data' => view('panel_faskes/treatment/edit', $data)
            ];
            echo json_encode($response);
        }
    }

    public function formdiscount()
    {
        if ($this->request->isAJAX()) {
            $treatment_code = $this->request->getVar('treatment_code');
            $treatment      = $this->treatment->find($treatment_code);
            $discount       = $this->discount->list($treatment_code);
            $data = [
                'title'       => 'Data Diskon Treatment',
                'treatment'   => $treatment,
                'discount'    => $discount
            ];
            $response = [
                'data' => view('panel_faskes/treatment/discount', $data)
            ];
            echo json_encode($response);
        }
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'treatment_name'    => 'required',
                'treatment_type'    => 'required',
                'treatment_price'   => 'required',
                'treatment_status'  => 'required',
            ];
    
            $errors = [
                'treatment_name' => [
                    'required'   => 'Nama treatment harus diisi.',
                ],
                'treatment_type' => [
                    'required'   => 'Tipe treatment harus diisi.',
                ],
                'treatment_price' => [
                    'required'   => 'Harga treatment harus diisi.',
                ],
                'treatment_status' => [
                    'required'   => 'Status treatment harus dipilih.',
                ]
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'treatment_name'      => $validation->getError('treatment_name'),
                        'treatment_type'      => $validation->getError('treatment_type'),
                        'treatment_price'     => $validation->getError('treatment_price'),
                        'treatment_status'    => $validation->getError('treatment_status'),
                    ]
                ];
            } else {
                
                $user               = $this->userauth(); // Return array
                $user_faskes        = $user['user_faskes'];
                $last               = $this->treatment->where('treatment_faskes',$user_faskes)->orderBy('treatment_code', 'desc')->first();
                if ($last == NULL) {
                    $last           = '00001';
                    $faskes         = $this->faskes->find($user_faskes);
                    $initial        = $faskes['faskes_initial'];
                    $treatment_code = 'TR-' . $initial . '-'  . $last;
                } else {
                    $last           = $last['treatment_code'];
                    $code0          = substr($last, -5); // get last 5 char
                    $code1          = substr($last,0, 6); // get 6 first char
                    $code2          = $code0 + 1;
                    $code2          = str_pad($code2,5,"0",STR_PAD_LEFT);
                    $treatment_code = $code1 . $code2;
                }

                $treatment_price= str_replace(str_split('Rp. .'), '', $this->request->getVar('treatment_price'));

                $new = [
                    'treatment_code'        => $treatment_code,
                    'treatment_name'        => $this->request->getVar('treatment_name'),
                    'treatment_price'       => $treatment_price,
                    'treatment_description' => trim(preg_replace('/\s\s+/', ' ', $this->request->getVar('treatment_description'))),
                    'treatment_faskes'      => $user_faskes,
                    'treatment_create'      => date('Y-m-d H:i:s'),
                    'treatment_status'      => $this->request->getVar('treatment_status'),
                    'treatment_type'        => $this->request->getVar('treatment_type'),
                ];
                $this->treatment->insert($new);

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
                'treatment_name'    => 'required',
                'treatment_type'    => 'required',
                'treatment_price'   => 'required',
                'treatment_status'  => 'required',
            ];
    
            $errors = [
                'treatment_name' => [
                    'required'   => 'Nama treatment harus diisi.',
                ],
                'treatment_type' => [
                    'required'   => 'Tipe treatment harus diisi.',
                ],
                'treatment_price' => [
                    'required'   => 'Harga treatment harus diisi.',
                ],
                'treatment_status' => [
                    'required'   => 'Status treatment harus dipilih.',
                ]
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'treatment_name'      => $validation->getError('treatment_name'),
                        'treatment_type'      => $validation->getError('treatment_type'),
                        'treatment_price'     => $validation->getError('treatment_price'),
                        'treatment_status'    => $validation->getError('treatment_status'),
                    ]
                ];
            } else {
                $treatment_code = $this->request->getVar('treatment_code');
                $treatment_price= str_replace(str_split('Rp. .'), '', $this->request->getVar('treatment_price'));

                $update = [
                    'treatment_name'        => $this->request->getVar('treatment_name'),
                    'treatment_price'       => $treatment_price,
                    'treatment_description' => trim(preg_replace('/\s\s+/', ' ', $this->request->getVar('treatment_description'))),
                    'treatment_edit'        => date('Y-m-d H:i:s'),
                    'treatment_status'      => $this->request->getVar('treatment_status'),
                    'treatment_type'        => $this->request->getVar('treatment_type'),
                ];

                $this->treatment->update($treatment_code, $update);

                $response = [
                    'success' => 'Data Berhasil Diupdate'
                ];
            }
            echo json_encode($response);
        }
    }

    public function discount()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'treatment_discount'        => 'required',
                'treatment_discount_price'  => 'required',
            ];
    
            $errors = [
                'treatment_discount' => [
                    'required'   => 'Status diskon treatment harus dipilih.',
                ],
                'treatment_discount_price' => [
                    'required'   => 'Harga diskon treatment harus diisi.',
                ]
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'treatment_discount'        => $validation->getError('treatment_discount'),
                        'treatment_discount_price'  => $validation->getError('treatment_discount_price'),
                    ]
                ];
            } else {
                $user                       = $this->userauth();
                $treatment_code             = $this->request->getVar('treatment_code');
                $treatment                  = $this->treatment->find($treatment_code);
                $treatment_price            = $treatment['treatment_price'];
                
                $treatment_discount         = $this->request->getVar('treatment_discount');

                if ($treatment_discount == 't') {
                    $treatment_discount_price   = str_replace(str_split('Rp. .'), '', $this->request->getVar('treatment_discount_price'));
                } else {
                    $treatment_discount_price   = NULL;
                }
                
                $newDiscount = [
                    'discount_treatment'    => $treatment_code,
                    'discount_status'       => $treatment_discount,
                    'discount_create'       => date('Y-m-d H:i:s'),
                    'discount_price_normal' => $treatment_price,
                    'discount_price'        => $treatment_discount_price, 
                    'discount_description'  => trim(preg_replace('/\s\s+/', ' ', $this->request->getVar('discount_description'))),
                    'discount_user'         => $user['user_name']
                ];

                $updateTreatment = [
                    'treatment_discount'       => $treatment_discount,
                    'treatment_discount_price' => $treatment_discount_price,
                ];

                $this->db->transStart();
                $this->discount->insert($newDiscount);
                $this->treatment->update($treatment_code, $updateTreatment);
                $this->db->transComplete();

                $response = [
                    'success' => 'Data Treatment Berhasil Didiskon'
                ];
            }
            echo json_encode($response);
        }
    }
}