<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Refer_Hospital extends BaseController
{
    public function index()
	{
		$user = $this->userauth(); //Return array

        //Get Refer Type = visit or teledermatology
        $uri                    = service('uri');
        $max_segment            = $uri->getTotalSegments();
        $type_refer             = ucwords(substr($uri->getSegment($max_segment),6));

		$data = [
			'title'         => 'Rujukan ' . $type_refer,
			'user'          => $user,
            'type_refer'    => $type_refer,
		];
		return view('panel_faskes/refer_hospital/index', $data);
	}

    public function getdatavisit()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); //Return array
            $user_faskes = $user['user_faskes'];

            $data = [
                'list' => $this->medical->list_refer_visit($user_faskes),
            ];

            $response = [
                'data' => view('panel_faskes/refer_hospital/list_visit', $data)
            ];

            echo json_encode($response);
        }
    }

    public function getdatatldm()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); //Return array
            $user_faskes = $user['user_faskes'];

            $data = [
                'list' => $this->medical->list_refer_tldm($user_faskes),
            ];

            $response = [
                'data' => view('panel_faskes/refer_hospital/list_tldm', $data)
            ];

            echo json_encode($response);
        }
    }

    public function refer_visit()
	{
		$user           = $this->userauth(); // Return Object
        $user_faskes    = $user['user_faskes'];
        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('medical', $params)) {
            $medical_code   = $params['medical'];

            $medical        = $this->medical->medical_complete($medical_code);
            $invoice        = $this->invoice->find_medical($medical_code);
            if ($medical != 0) {
                $product     = $this->product->list_active($user_faskes);
                $treatment   = $this->treatment->list_active($user_faskes);
                $data = [
                    'title'         => 'Form Rujukan Kunjungan',
                    'user'          => $user,
                    'medical'       => $medical,
                    'invoice'       => $invoice,
                    'product'       => $product,
                    'treatment'     => $treatment
                ];
                return view('panel_faskes/refer_hospital/add_visit', $data);
            } else {
                return redirect()->to('/refer-visit');
            }
            
        } else{
            return redirect()->to('/refer-visit');
        }
		
	}

    public function create()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'medical_type'      => 'required',
                'invoice_method'    => 'required',
            ];
    
            $errors = [
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
                        'medical_type'      => $validation->getError('medical_type'),
                        'invoice_method'    => $validation->getError('invoice_method'),
                    ]
                ];
            } else {
                $user               = $this->userauth(); // Return array
                $user_faskes        = $user['user_faskes'];
                $user_name          = $user['user_name'];
                $faskes             = $this->faskes->find($user_faskes);
                // $initial            = $faskes['faskes_initial'];
                // $medical_create     = str_replace(str_split('T'), ' ', $this->request->getVar('medical_create'));
                $amount             = 0; 
                $medical_code       = $this->request->getVar('medical_code');

                $updateMedical = [
                    'medical_type'         => $this->request->getVar('medical_type'),
                    'medical_description'  => trim(preg_replace('/\s\s+/', ' ', $this->request->getVar('medical_description'))),
                ];
                //Transaction Start
                $this->db->transStart();
                $this->medical->update($medical_code, $updateMedical);

                $medtreat_items     = $this->request->getPost('group-medtreat[][medtreat_treatment]');
                if ($medtreat_items != NULL) {
                    foreach ($medtreat_items as $medtreat) {
                        $medtreat_treatment = $medtreat['medtreat_treatment'];
                        $treatmentData      = $this->treatment->find($medtreat_treatment);

                        if ($treatmentData['treatment_discount'] == 't') {
                            $discount           = round((($treatmentData['treatment_price']-$treatmentData['treatment_discount_price'])/$treatmentData['treatment_price'])*100,2);
                            $treatmentName      = $treatmentData['treatment_name'];
                            $treatmentDiscount  = 'PROMO '. $discount . '%';
                            $treatmentPrice     = $treatmentData['treatment_discount_price'];
                            $treatmentBD        = $treatmentData['treatment_price'];
                        } else {
                            $treatmentName      = $treatmentData['treatment_name'];
                            $treatmentDiscount  = NULL;
                            $treatmentPrice     = $treatmentData['treatment_price'];
                            $treatmentBD        = NULL;
                        }
                        
                        $newMedtreat = [
                            'medtreat_medical'        => $medical_code,
                            'medtreat_treatment'      => $medtreat_treatment,
                            'medtreat_name'           => $treatmentName,
                            'medtreat_price'          => $treatmentPrice,
                            'medtreat_discount'       => $treatmentDiscount,
                            'medtreat_discount_price' => $treatmentBD,
                        ];
                        $amount        = $amount + $treatmentPrice; 
                        $this->medtreat->insert($newMedtreat);
                    }
                }
                
                $medprod_items     = $this->request->getPost('group-medprod[][medprod_product]');
                if ($medprod_items[0]['medprod_qty'] != "") {
                    foreach ($medprod_items as $medprod ) {
                        $medprod_product       = $medprod['medprod_product'];
                        $medprod_qty           = $medprod['medprod_qty'];
                        if ($medprod_qty == NULL) {
                            $medprod_qty = 1;
                        }
                        $productData           = $this->product->find($medprod_product);
                        $productName           = $productData['product_name'];
                        $productPrice          = $productData['product_price'];
                        $newMedprod = [
                            'medprod_medical'  => $medical_code,
                            'medprod_product'  => $medprod_product,
                            'medprod_qty'      => $medprod_qty,
                            'medprod_price'    => $productPrice,
                            'medprod_name'     => $productName
                        ];
                        
                        $amount      = $amount + ($productPrice*$medprod_qty); 
                        
                        $productQty  = $productData['product_qty'] - $medprod_qty;
                        $updateProduct = [
                            'product_qty' => $productQty
                        ];

                        $newStock = [
                            'stock_product'     => $medprod_product,
                            'stock_type'        => 'Pengurangan',
                            'stock_qty'         => $medprod_qty,
                            'stock_create'      => date('Y-m-d H:i:s'),
                            'stock_description' => $medical_code,
                        ];
                        
                        $this->medprod->insert($newMedprod);
                        $this->product->update($medprod_product, $updateProduct);
                        $this->product_stock->insert($newStock);
                        
                    }
                }

                $medoth_items     = $this->request->getPost('group-medoth[][medoth_name]');
                if ($medoth_items[0]['medoth_name'] != "") {
                    foreach ($medoth_items as $medoth) {
                        $medoth_name         = $medoth['medoth_name'];
                        $medoth_qty          = $medoth['medoth_qty'];
                        if ($medoth_qty == NULL) {
                            $medoth_qty = 1;
                        }
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

                $invoice_method     = $this->request->getVar('invoice_method');
                
                $invoice_admin_fee  = $this->transaction_fee($invoice_method, $amount);

                $amount             = $amount + $invoice_admin_fee;
                $invoice_id         = $this->request->getVar('invoice_id');
                $updateInvoice = [
                    'invoice_amount'    => $amount,
                    'invoice_method'    => $invoice_method,
                    'invoice_status'    => 'PENDING',
                    'invoice_admin_fee' => $invoice_admin_fee,
                ];
                $this->invoice->update($invoice_id, $updateInvoice);

                $this->db->transComplete();
                //Transaction End

                $response = [
                    'success' => 'Data Berhasil Disimpan',
                    'link'    => '/refer-visit', 
                ];
            }
            echo json_encode($response);
        }
    }

    public function cancel()
    {
        if ($this->request->isAJAX()) {

            $medical_code = $this->request->getVar('medical_code');
            $invoice_code = $this->request->getVar('invoice_code');

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

            $updateMedical = [
                'medical_type'         => NULL,
            ];
            
            $updateInvoice = [
                'invoice_amount'    => '0',
                'invoice_method'    => NULL,
                'invoice_status'    => 'PENDING',
                'invoice_admin_fee' => '0',
            ];
            
            $this->medical->update($medical_code, $updateMedical);
            $this->invoice->update($invoice_code, $updateInvoice);
            $this->db->transComplete();

            $response = [
                'success' => 'Data Kunjungan Pasien Berhasil Dibatalkan'
            ];

            echo json_encode($response);
        }
    }
}
