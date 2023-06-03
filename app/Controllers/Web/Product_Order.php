<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Product_Order extends BaseController
{
    public function index()
	{
		$user = $this->userauth(); //Return array
		$data = [
			'title'  => 'Produk Order (PO)',
			'user'   => $user,
		];
		return view('panel_faskes/product_order/index', $data);
	}

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); //Return array
            $user_faskes = $user['user_faskes'];
            $user_id     = $user['user_id'];
            $user_role   = $user['user_role'];

            if ($user_role == 1011) {
                $list        = $this->medical->list_product_order_patient($user_id);
            } else {
                $list        = $this->medical->list_product_order($user_faskes);
            }
            
            $data = [
                'list'      => $list,
                'user_role' => $user_role,
            ];

            $response = [
                'data' => view('panel_faskes/product_order/list', $data)
            ];
            
            echo json_encode($response);
        }
    }

    public function index_patient()
	{
		$user        = $this->userauth(); //Return array
        $user_faskes = $user['user_faskes'];
        $user_id     = $user['user_id'];

        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 1 && array_key_exists('search', $params)) {
            $product     = $this->product->where('product_faskes', $user_faskes)->where('product_status', 't')->like('LOWER("product_name")', strtolower($params['search']), FALSE)->orderBy('product_name', 'ASC')->limit(10)->get()->getResultArray();
            $pager = NULL;
        } else{
            $product     = $this->product->where('product_faskes', $user_faskes)->where('product_status', 't')->orderBy('product_name', 'ASC')->paginate(8, 'tb_product');
            $pager = $this->product->pager;
        }

        $cart        = $this->cart->list($user_id);
		$data = [
			'title'  => 'Produk Order (PO)',
			'user'   => $user,
            'product' => $product,
            'cart'    => $cart,
            'pager'	  => $pager,
        ];
		return view('panel_patient/product_order/index', $data);
	}

    public function index_patient_search()
    {
        $search_product = $this->request->getVar('search_product'); 

        $queryParam = 'search=' . $search_product;

        $newUrl = 'order-product?' . $queryParam; 

        return redirect()->to($newUrl);
    }

    public function formorder()
    {
        if ($this->request->isAJAX()) {
            $product_code   = $this->request->getVar('product_code');
            $product        = $this->product->find($product_code);
            
            $data = [
                'title'     => 'Form Order '.$product['product_name'],
                'product'   => $product,

            ];
            $response = [
                'data' => view('panel_patient/product_order/order', $data)
            ];
            echo json_encode($response);
        }
    }

    public function cart_patient()
	{
		$user        = $this->userauth(); //Return array
        $user_id     = $user['user_id'];

        $cart        = $this->cart->find_user($user_id);
        $total      = 0;
        foreach ($cart as $item) {
            $total += $item['cart_qty'] * $item['product_price'];
        }
		$data = [
			'title'  => 'Keranjang',
            'user'   => $user, 
            'cart'   => $cart,
            'total'  => $total,
        ];
		return view('panel_patient/product_order/cart', $data);
	}

    public function cart()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'cart_qty'    => 'required',
            ];
    
            $errors = [
                'cart_qty' => [
                    'required'   => 'Jumlah order harus diisi.',
                ],
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'cart_qty'      => $validation->getError('cart_qty'),
                    ]
                ];
            } else {
                $user               = $this->userauth();
                $user_id            = $user['user_id']; 

                if ($this->request->getVar('cart_qty') <= $this->request->getVar('cart_qty_max')) {
                    $new = [
                        'cart_user'         => $user_id,
                        'cart_product'      => $this->request->getVar('cart_product'),
                        'cart_qty'          => $this->request->getVar('cart_qty'),
                        'cart_create'       => date('Y-m-d H:i:s'),
                    ];
                    $this->cart->insert($new);
    
                    $response = [
                        'success' => 'Produk Dimasukan Ke Keranjang',
                        'data'    => [
                            'title'=> 'Berhasil!',
                            'link' => 'order-cart',
                            'icon' => 'success',
                        ],
                    ];
                } else {
                    $response = [
                        'success' => 'Jumlah stock tidak mencukupi',
                        'data'    => [
                            'title'=> 'Gagal!',
                            'link' => 'order-product',
                            'icon' => 'warning',
                        ],
                    ];
                }
                
                
            }
            echo json_encode($response);
        }
    }

    public function cancel()
    {
        if ($this->request->isAJAX()) {

            $cart_id = $this->request->getVar('cart_id');

            $this->db->transStart();
            $this->cart->delete($cart_id);
            $this->db->transComplete();

            $response = [
                'success' => 'Produk dihapus dari keranjang'
            ];

            echo json_encode($response);
        }
    }

    public function checkout()
    {
        if ($this->request->isAJAX()) {
            $user               = $this->userauth(); // Return array
            $user_id            = $user['user_id'];
            $user_faskes        = $user['user_faskes'];
            $user_name          = $user['user_name'];
            $faskes             = $this->faskes->find($user_faskes);
            $initial            = $faskes['faskes_initial'];
            $medical_create     = date('Y-m-d H:i:s');
            $amount             = 0; 
            $medical_code       = $this->generate_medical_code();

            $new = [
                'medical_code'         => $medical_code,
                'medical_faskes'       => $user_faskes,
                'medical_user'         => $user_id,
                'medical_employee'     => $user_name,
                'medical_type'         => 'Product',
                'medical_create'       => $medical_create,
                'medical_status'       => 'Proses',
                'medical_creator_type' => 'Patient',
            ];
            //Transaction Start
            $this->db->transStart();
            $this->medical->insert($new);
            $cart_items     = $this->cart->find_user($user_id);
                if (count($cart_items) != 0) {
                    foreach ($cart_items as $cart ) {
                        $cart_product       = $cart['cart_product'];
                        $cart_qty           = $cart['cart_qty'];
                        $productData           = $this->product->find($cart_product);
                        $productName           = $productData['product_name'];
                        $productPrice          = $productData['product_price'];
                        $newMedprod = [
                            'medprod_medical'  => $medical_code,
                            'medprod_product'  => $cart_product,
                            'medprod_qty'      => $cart_qty,
                            'medprod_price'    => $productPrice,
                            'medprod_name'     => $productName
                        ];
                        
                        $amount      = $amount + ($productPrice*$cart_qty); 
                        
                        $productQty  = $productData['product_qty'] - $cart_qty;
                        $updateProduct = [
                            'product_qty' => $productQty
                        ];

                        $newStock = [
                            'stock_product'     => $cart_product,
                            'stock_type'        => 'Pengurangan',
                            'stock_qty'         => $cart_qty,
                            'stock_create'      => date('Y-m-d H:i:s'),
                            'stock_description' => $medical_code,
                        ];
                        
                        $this->medprod->insert($newMedprod);
                        $this->product->update($cart_product, $updateProduct);
                        $this->product_stock->insert($newStock);
                        $this->cart->delete($cart['cart_id']);
                    }
                }
            $invoice_method = $this->request->getVar('invoice_method');
            
            $invoice_admin_fee = $this->transaction_fee($invoice_method, $amount);

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

            $this->db->transComplete();
            //Transaction End

            $response = [
                'success' => 'Data Berhasil Disimpan',
                'link'    => '/transaction/checkout/'.$medical_code, 
            ]; 
            echo json_encode($response);   
        }
    }

}
