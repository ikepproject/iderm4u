<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class MedicalRefer extends BaseController
{
	public function index()
	{
		$user = $this->userauth(); //Return array
		$data = [
			'title'  => 'Rujukan',
			'user'   => $user,
		];
		return view('panel_faskes/medicalrefer/index', $data);
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
                'data' => view('panel_faskes/medicalrefer/list', $data)
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
                'invoice'   => $invoice
            ];
            $response = [
                'data' => view('panel_faskes/medical/detail', $data)
            ];
            echo json_encode($response);
        }
    }

    public function create()
    {
        $medical_faskes     = $this->request->getVar('medical_faskes');
        $medical_refer_code = $this->request->getVar('medical_refer_code'); 
        var_dump($medical_refer_code);
        // if ($this->request->isAJAX()) {
        //     $validation = \Config\Services::validation();
        //     $rules = [
        //         'medical_refer_type'=> 'required',
        //         'medical_faskes'    => 'required',
        //     ];
    
        //     $errors = [
        //         'medical_refer_type' => [
        //             'required'    => 'Tipe Rujukan harus dipilih.',
        //         ],
        //         'medical_faskes' => [
        //             'required'    => 'Rumah Sakit Rujukan harus dipilih.',
        //         ],
        //     ];
        //     $valid = $this->validate($rules, $errors);
        //     if (!$valid) {
        //         $response = [
        //             'error' => [
        //                 'medical_refer_type'  => $validation->getError('medical_refer_type'),
        //                 'medical_faskes'      => $validation->getError('medical_faskes'),
        //             ]
        //         ];
        //     } else {
        //         $user               = $this->userauth(); // Return array
        //         $user_name          = $user['user_name'];
        //         $user_faskes        = $user['user_faskes'];

        //         $medical_faskes     = $this->request->getVar('medical_faskes');
        //         $medical_refer_code = $this->request->getVar('medical_refer_code');               
        //         $faskes             = $this->faskes->find($medical_faskes);
        //         $initial            = $faskes['faskes_initial'];
        //         $last               = $this->medical->where('medical_faskes', $medical_faskes )->orderBy('medical_code', 'desc')->first();

        //         $amount             = 0; 
        //         if ($last == NULL) {
        //             $last           = '0000001';
        //             $medical_code   = 'MED-' . $initial . '-'  . $last;
        //         } else {
        //             $last           = $last['medical_code'];
        //             $code0          = substr($last, -7); // get last 7 char
        //             $code1          = substr($last,0, 7); // get 7 first char
        //             $code2          = $code0 + 1;
        //             $code2          = str_pad($code2,7,"0",STR_PAD_LEFT);
        //             $medical_code   = $code1 . $code2;
        //         }

        //         $new = [
        //             'medical_code'         => $medical_code,
        //             'medical_faskes'       => $medical_faskes,
        //             'medical_user'         => $this->request->getVar('medical_user'),
        //             'medical_employee'     => $user_name,
        //             'medical_description'  => $this->request->getVar('medical_description'),
        //             'medical_create'       => date('Y-m-d H:i:s'),
        //             'medical_status'       => 'Proses',
        //             'medical_creator_type' => 'Admin',
        //             'medical_refer_type'   => $this->request->getVar('medical_refer_type'),
        //             'medical_refer_origin' => $user_faskes,
        //             'medical_refer_code'   => $medical_refer_code,
        //         ];
        //         $this->medical->insert($new);

        //         $response = [
        //             'success' => 'Data Berhasil Dirujuk',
        //             'link'    => 'medical', 
        //         ];
        //     }
        //     echo json_encode($response);
        // }
    }

    public function addgallery()
    {
        if ($this->request->isAJAX()) {
            $images_items     = $this->request->getFileMultiple('images');
            $medical_code     = $this->request->getVar('medical_code');
            if ($images_items[0]->getName() != "") {
                foreach ($images_items as $images) {
                    $img_name       = $images->getName();
                    $datetime       = date("YmdHis");
                    $new_img_name   = $medical_code . '_' . $datetime . '_' . $img_name;
                    \Config\Services::image()
                    ->withFile($images)
                    ->fit(250, 250, 'center')
                    ->save('public/assets/images/medical/thumb/' . $new_img_name);
                    $images->move('public/assets/images/medical/ori/', $new_img_name);
                    $newMedgal = [
                        'medgal_medical'  => $medical_code,
                        'medgal_create'   => date('Y-m-d H:i:s'),
                        'medgal_filename' => $new_img_name,
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