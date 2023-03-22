<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Medical extends BaseController
{
	public function index()
	{
		$user = $this->userauth(); //Return array
		$data = [
			'title'  => 'Kunjungan',
			'user'   => $user,
		];
		return view('panel_faskes/medical/index', $data);
	}

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); //Return array
            $user_faskes = $user['user_faskes'];
            $data = [
                'list' => $this->medical->list($user_faskes)
            ];
            $response = [
                'data' => view('panel_faskes/medical/list', $data)
            ];
            echo json_encode($response);
        }
    }

	public function formadd()
    {
        $user        = $this->userauth(); //Return array
        $user_faskes = $user['user_faskes'];
        $product     = $this->product->list_active($user_faskes);
        $treatment   = $this->treatment->list_active($user_faskes);
		$data = [
			'title'     => 'Tambah Data Kunjungan Pasien',
			'user'      => $user,
            'product'   => $product,
            'treatment' => $treatment
		];
		return view('panel_faskes/medical/add', $data);
    }

    public function formdetail()
    {
        if ($this->request->isAJAX()) {
            $medical_code = $this->request->getVar('medical_code');
            $medical      = $this->medical->find($medical_code);
            $user_id      = $medical['medical_user'];
            $user         = $this->user->find($user_id);
            $patient_code = $user['user_patient'];
            $patient      = $this->patient->find($patient_code);

            $medtreat     = $this->medtreat->find_medical($medical_code);
            $medprod      = $this->medprod->find_medical($medical_code);
            $medoth       = $this->medoth->find_medical($medical_code);
            $medgal       = $this->medgal->find_medical($medical_code);
            $invoice      = $this->invoice->find_medical($medical_code);

            $data = [
                'title'     => 'Detail Data Kunjungan Pasien',
                'user'      => $user,
                'patient'   => $patient,
                'medical'   => $medical,
                'medtreat'  => $medtreat,
                'medprod'   => $medprod,
                'medoth'    => $medoth,
                'medgal'    => $medgal,
                'invoice'   => $invoice,
                'faskes'    => $this->faskes->list_faskes()
            ];
            $response = [
                'data' => view('panel_faskes/medical/detail', $data)
            ];
            echo json_encode($response);
        }
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'medical_user'      => 'required',
                'medical_type'      => 'required',
                'invoice_method'    => 'required',
            ];
    
            $errors = [
                'medical_user' => [
                    'required'    => 'Pasien harus dipilih.',
                ],
                'medical_type' => [
                    'required'    => 'Tipe kunjungan harus dipilih.',
                ],
                'invoice_method' => [
                    'required'    => 'Cara bayar harus dipilih.',
                ],
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'medical_user'      => $validation->getError('medical_user'),
                        'medical_type'      => $validation->getError('medical_type'),
                        'invoice_method'    => $validation->getError('invoice_method'),
                    ]
                ];
            } else {
                $user               = $this->userauth(); // Return array
                $user_faskes        = $user['user_faskes'];
                $user_name          = $user['user_name'];
                $faskes             = $this->faskes->find($user_faskes);
                $initial            = $faskes['faskes_initial'];
                $medical_create     = str_replace(str_split('T'), ' ', $this->request->getVar('medical_create'));
                $amount             = 0; 
                $medical_code       = $this->generate_medical_code();

                $new = [
                    'medical_code'         => $medical_code,
                    'medical_faskes'       => $user_faskes,
                    'medical_user'         => $this->request->getVar('medical_user'),
                    'medical_employee'     => $user_name,
                    'medical_type'         => $this->request->getVar('medical_type'),
                    'medical_description'  => $this->request->getVar('medical_description'),
                    'medical_create'       => $medical_create,
                    'medical_status'       => 'Proses',
                    'medical_creator_type' => 'Admin',
                ];
                $this->medical->insert($new);

                $medtreat_items     = $this->request->getPost('group-medtreat[][medtreat_treatment]');
                if ($medtreat_items != NULL) {
                    foreach ($medtreat_items as $medtreat) {
                        $medtreat_treatment           = $medtreat['medtreat_treatment'];
                        $newMedtreat = [
                            'medtreat_medical'        => $medical_code,
                            'medtreat_treatment'      => $medtreat_treatment
                        ];
                        $treatmentData = $this->treatment->find($medtreat_treatment);
                        $treatmentPrice= $treatmentData['treatment_price'];
                        $amount        = $amount + $treatmentPrice; 
                        $this->medtreat->insert($newMedtreat);
                        // $tes1[] = $medtreat_treatment;
                    }
                }
                
                $medprod_items     = $this->request->getPost('group-medprod[][medprod_product]');
                if ($medprod_items[0]['medprod_qty'] != "") {
                    foreach ($medprod_items as $medprod ) {
                        $medprod_product       = $medprod['medprod_product'];
                        $medprod_qty           = $medprod['medprod_qty'];
                        $newMedprod = [
                            'medprod_medical'  => $medical_code,
                            'medprod_product'  => $medprod_product,
                            'medprod_qty'      => $medprod_qty
                        ];
                        $productData = $this->product->find($medprod_product);
                        $productPrice= $productData['product_price'] * $medprod_qty;
                        $amount      = $amount + $productPrice; 

                        $productQty  = $productData['product_qty'] - $medprod_qty;
                        $updateProduct = [
                            'product_qty' => $productQty
                        ];
                        $this->db->transStart();
                        $this->medprod->insert($newMedprod);
                        $this->product->update($medprod_product, $updateProduct);
                        $this->db->transComplete();
                    }
                }

                $medoth_items     = $this->request->getPost('group-medoth[][medoth_name]');
                if ($medoth_items[0]['medoth_name'] != "") {
                    foreach ($medoth_items as $medoth) {
                        $medoth_name         = $medoth['medoth_name'];
                        $medoth_qty          = $medoth['medoth_qty'];
                        $medoth_price        = str_replace(str_split('Rp. .'), '', $medoth['medoth_price']);
                        $newMedoth = [
                            'medoth_medical'  => $medical_code,
                            'medoth_name'     => $medoth_name,
                            'medoth_qty'      => $medoth_qty,
                            'medoth_price'    => $medoth_price
                        ];
                        $other_price = $medoth_price * $medoth_qty;
                        $amount      = $amount + $other_price; 
                        $this->medoth->insert($newMedoth);
                    }
                }
                
                $images_items     = $this->request->getFileMultiple('images');
                if ($images_items[0]->getName() != "") {
                    foreach ($images_items as $images) {
                        $img_name       = $images->getName();
                        $disease        = trim($this->request->getVar('medgal_disease'));

                        if ($disease == NULL) {
                            $disease = 'unnamed';
                        }

                        $datetime       = date("YmdHis");
                        $new_img_name   = $disease . '_' . $medical_code . '_' . $datetime . '_' . $img_name;
                        \Config\Services::image()
                        ->withFile($images)
                        ->fit(250, 250, 'center')
                        ->save('public/assets/images/medical/thumb/' . $new_img_name);
                        $images->move('public/assets/images/medical/ori/', $new_img_name);
                        $newMedgal = [
                            'medgal_medical'  => $medical_code,
                            'medgal_create'   => date('Y-m-d H:i:s'),
                            'medgal_filename' => $new_img_name,
                            'medgal_disease'  => $disease
                        ];
                        $this->medgal->insert($newMedgal);
                    }
                }

                $invoice_method = $this->request->getVar('invoice_method');
                if ($invoice_method == 'VA') {
                    $invoice_admin_fee = 3500;
                } elseif ($invoice_method == 'QR') {
                    $invoice_admin_fee = $amount * 0.007;
                } else {
                    $invoice_admin_fee = 0;
                }
                $amount = $amount + $invoice_admin_fee;
                $invoice_code = 'INV-' . $initial . '-'  . $this->request->getVar('medical_user') .date('YmdHis');
                $newInvoice = [
                    'invoice_code'      => $invoice_code,
                    'invoice_medical'   => $medical_code,
                    'invoice_amount'    => $amount,
                    'invoice_method'    => $invoice_method,
                    'invoice_status'    => 'PENDING',
                    'invoice_admin_fee' => $invoice_admin_fee,
                ];
                $this->invoice->insert($newInvoice);

                $response = [
                    'success' => 'Data Berhasil Disimpan',
                    'link'    => 'medical', 
                ];
            }
            echo json_encode($response);
        }
    }

    public function addgallery()
    {
        if ($this->request->isAJAX()) {
            $images_items     = $this->request->getFileMultiple('images');
            $medical_code     = $this->request->getVar('medical_code');
            $disease          = trim($this->request->getVar('medgal_disease'));
                        
            if ($disease == NULL) {
                $disease = 'unnamed';
            }

            if ($images_items[0]->getName() != "") {
                foreach ($images_items as $images) {
                    $img_name       = $images->getName();
                    $datetime       = date("YmdHis");
                    $new_img_name   = $disease . '_' . $medical_code . '_' . $datetime . '_' . $img_name;
                    \Config\Services::image()
                    ->withFile($images)
                    ->fit(250, 250, 'center')
                    ->save('public/assets/images/medical/thumb/' . $new_img_name);
                    $images->move('public/assets/images/medical/ori/', $new_img_name);
                    $newMedgal = [
                        'medgal_medical'  => $medical_code,
                        'medgal_create'   => date('Y-m-d H:i:s'),
                        'medgal_filename' => $new_img_name,
                        'medgal_disease'  => $disease
                    ];
                    $this->medgal->insert($newMedgal);
                }
                $response = [
                    'success' => 'Gallery Bary Berhasil Ditambahkan',
                    'icon'    => 'success',
                    'link'    => 'medical', 
                ];
            } else {
                $response = [
                    'success' => 'Tidak Ada Gallery Baru',
                    'icon'    => 'warning',
                    'link'    => 'medical', 
                ];
            }
            echo json_encode($response);
        }
    }

    public function deletegallery()
    {
        if ($this->request->isAJAX()) {
            $medgal_id      = $this->request->getVar('medgal_id');
            $medgal_filename= $this->request->getVar('medgal_filename');
            unlink('public/assets/images/medical/ori/' . $medgal_filename);
            unlink('public/assets/images/medical/thumb/' . $medgal_filename);
            $this->medgal->delete($medgal_id);
            $response = [
                'success' => 'Berhasil Hapus Foto',
                'link'    => 'medical', 
            ];
            echo json_encode($response);
        }
    }

    public function cancel()
    {
        if ($this->request->isAJAX()) {

            $medical_code = $this->request->getVar('medical_code');
            $medtreat     = $this->medtreat->find_medical($medical_code);
            $medprod      = $this->medprod->find_medical($medical_code);
            $medoth       = $this->medoth->find_medical($medical_code);
            $medgal       = $this->medgal->find_medical($medical_code);
            $invoice      = $this->invoice->find_medical($medical_code);

            $this->db->transStart();
            if (count($medtreat) != 0) {
                foreach ($medtreat as $treat) {
                    $this->medtreat->delete($treat['medtreat_id']);
                }
            }

            if (count($medprod) != 0) {
                foreach ($medprod as $prod) {
                    $this->medprod->delete($prod['medprod_id']);
                    $productData = $this->product->find($prod['medprod_product']);
                    $productQty  = $productData['product_qty'] + $prod['medprod_qty'];
                    $productUpdate = [
                        'product_qty' => $productQty,
                    ];
                    $this->product->update($prod['medprod_product'], $productUpdate);
                }
            }

            if (count($medoth) != 0) {
                foreach ($medoth as $other) {
                    $this->medoth->delete($other['medoth_id']);
                }
            }

            if (count($medgal) != 0) {
                foreach ($medgal as $gallery) {
                    unlink('public/assets/images/medical/ori/' . $gallery['medgal_filename']);
                    unlink('public/assets/images/medical/thumb/' . $gallery['medgal_filename']);
                    $this->medgal->delete($gallery['medgal_id']);
                }
            }

            $this->invoice->delete($invoice['invoice_id']);
            $this->medical->delete($medical_code);
            $this->db->transComplete();

            $response = [
                'success' => 'Data Kunjungan Pasien Berhasil Dibatalkan'
            ];

            echo json_encode($response);
        }
    }
}