<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Product extends BaseController
{
	public function index()
	{
		$user = $this->userauth(); // Return Object
		$data = [
			'title'  => 'Product',
			'user'   => $user,
		];
		return view('panel_faskes/product/index', $data);
	}

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); // Return Object
            $user_faskes = $user['user_faskes'];
            $data = [
                'list' => $this->product->list($user_faskes)
            ];
            $response = [
                'data' => view('panel_faskes/product/list', $data)
            ];
            echo json_encode($response);
        }
    }

	public function formadd()
    {
        if ($this->request->isAJAX()) {
            $user = $this->userauth(); // Return Object
            $data = [
                'title'         => 'Tambah Product',
                'user'          => $user,
                'type_product'  => $this->type->list('Product', $user['user_faskes']),
            ];
            $response = [
                'data' => view('panel_faskes/product/add', $data)
            ];
            echo json_encode($response);
        }
    }

    public function formedit()
    {
        if ($this->request->isAJAX()) {
            $user = $this->userauth(); // Return Object
            $product_code = $this->request->getVar('product_code');
            $product      = $this->product->find($product_code);
            $data = [
                'title'         => 'Edit Data Product',
                'product'       => $product,
                'type_product'  => $this->type->list('Product', $user['user_faskes']),
            ];
            $response = [
                'data' => view('panel_faskes/product/edit', $data)
            ];
            echo json_encode($response);
        }
    }

    public function formstock()
    {
        if ($this->request->isAJAX()) {
            $product_code = $this->request->getVar('product_code');
            $product      = $this->product->find($product_code);
            $stock        = $this->product_stock->list($product_code);
            
            $data = [
                'title'     => 'Data Stok Produk',
                'product'   => $product,
                'stock'     => $stock
            ];
            $response = [
                'data' => view('panel_faskes/product/stock', $data)
            ];
            echo json_encode($response);
        }
    }

    public function flow()
	{
		$user           = $this->userauth(); //Return array
        $user_faskes    = $user['user_faskes'];

        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 2 && array_key_exists('month', $params) && array_key_exists('year', $params)) {
            $month = $params['month'];
            $year  = $params['year'];

            if (is_string($year)) {
                $year = date('Y');
            }

            if (ctype_alpha($month) && $month != 'all') {
                $month = date('m');
            }

            if ($month >= 1 && $month <= 9) { 
                $month = str_pad($month, 2, '0', STR_PAD_LEFT);
            }

            if ($month == 'all') {
                $list  = $this->product_stock->flow_year($user_faskes, $year);
            } else {
                $list  = $this->product_stock->flow($user_faskes, $month, $year);
            }
            
        } else{
            $month = date('m');
            $year  = date('Y');
            $list  = $this->product_stock->flow($user_faskes, $month, $year);
        }

        $query_month    = $this->db->query('SELECT DISTINCT EXTRACT(MONTH FROM stock_create) AS month_number, to_char(stock_create, \'Month\') AS month_name FROM tb_product_stock');
        $query_year     = $this->db->query('SELECT DISTINCT EXTRACT(YEAR FROM stock_create) AS year FROM tb_product_stock');

        $unique_month   = $query_month->getResultArray();
        $unique_year    = $query_year->getResultArray();

		$data = [
			'title'         => 'Data Produk Masuk/Keluar (Flow Produk)',
			'user'          => $user,
            'unique_month'  => $unique_month,
            'unique_year'   => $unique_year,
            'month'         => $month,
            'year'          => $year,
            'list'          => $list
		];
		return view('panel_faskes/product/flow', $data);
	}

    public function flow_filter()
    {
        $month_filter = $this->request->getVar('month_filter'); 
        $year_filter = $this->request->getVar('year_filter');

        $queryParam = 'month=' . $month_filter . '&year=' . $year_filter;

        $newUrl = 'product-flow?' . $queryParam; 

        return redirect()->to($newUrl);
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'product_name'    => 'required',
                'product_type'    => 'required',
                'product_price'   => 'required',
                'product_qty'     => 'required',
                'product_unit'    => 'required',
                'product_status'  => 'required',
            ];
    
            $errors = [
                'product_name' => [
                    'required'   => 'Nama produk harus diisi.',
                ],
                'product_type' => [
                    'required'   => 'Jenis produk harus dipilih.',
                ],
                'product_price' => [
                    'required'   => 'Harga produk harus diisi.',
                ],
                'product_qty' => [
                    'required'   => 'Jumlah produk harus diisi.',
                ],
                'product_unit' => [
                    'required'   => 'Satuan jumlah produk harus diisi.',
                ],
                'product_status' => [
                    'required'   => 'Status produk harus dipilih.',
                ]
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'product_name'      => $validation->getError('product_name'),
                        'product_type'      => $validation->getError('product_type'),
                        'product_price'     => $validation->getError('product_price'),
                        'product_qty'       => $validation->getError('product_qty'),
                        'product_unit'      => $validation->getError('product_unit'),
                        'product_status'    => $validation->getError('product_status'),
                    ]
                ];
            } else {

                $user               = $this->userauth(); // Return array
                $user_faskes        = $user['user_faskes'];
                $last               = $this->product->where('product_faskes', $user_faskes )->orderBy('product_code', 'desc')->first();
                if ($last == NULL) {
                    $last           = '00001';
                    $faskes         = $this->faskes->find($user_faskes);
                    $initial        = $faskes['faskes_initial'];
                    $product_code = 'PR-' . $initial . '-'  . $last;
                } else {
                    $last           = $last['product_code'];
                    $code0          = substr($last, -5); // get last 5 char
                    $code1          = substr($last,0, 6); // get 6 first char
                    $code2          = $code0 + 1;
                    $code2          = str_pad($code2,5,"0",STR_PAD_LEFT);
                    $product_code   = $code1 . $code2;
                }

                $product_price      = str_replace(str_split('Rp. .'), '', $this->request->getVar('product_price'));

                $new = [
                    'product_code'        => $product_code,
                    'product_name'        => $this->request->getVar('product_name'),
                    'product_type'        => $this->request->getVar('product_type'),
                    'product_price'       => $product_price,
                    'product_qty'         => $this->request->getVar('product_qty'),
                    'product_unit'        => $this->request->getVar('product_unit'),
                    'product_description' => trim(preg_replace('/\s\s+/', ' ', $this->request->getVar('product_description'))),
                    'product_faskes'      => $user_faskes,
                    'product_create'      => date('Y-m-d H:i:s'),
                    'product_status'      => $this->request->getVar('product_status'),
                ];
                $this->product->insert($new);

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
                'product_name'    => 'required',
                'product_type'    => 'required',
                'product_price'   => 'required',
                'product_unit'    => 'required',
                'product_status'  => 'required',
            ];
    
            $errors = [
                'product_name' => [
                    'required'   => 'Nama produk harus diisi.',
                ],
                'product_type' => [
                    'required'   => 'Jenis produk harus dipilih.',
                ],
                'product_price' => [
                    'required'   => 'Harga produk harus diisi.',
                ],
                'product_unit' => [
                    'required'   => 'Satuan jumlah produk harus diisi.',
                ],
                'product_status' => [
                    'required'   => 'Status produk harus dipilih.',
                ]
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'product_name'      => $validation->getError('product_name'),
                        'product_type'      => $validation->getError('product_type'),
                        'product_price'     => $validation->getError('product_price'),
                        'product_unit'      => $validation->getError('product_unit'),
                        'product_status'    => $validation->getError('product_status'),
                    ]
                ];
            } else {
                $product_code = $this->request->getVar('product_code');
                $product_price= str_replace(str_split('Rp. .'), '', $this->request->getVar('product_price'));

                $update = [
                    'product_name'        => $this->request->getVar('product_name'),
                    'product_type'        => $this->request->getVar('product_type'),
                    'product_price'       => $product_price,
                    'product_unit'        => $this->request->getVar('product_unit'),
                    'product_description' => trim(preg_replace('/\s\s+/', ' ', $this->request->getVar('product_description'))),
                    'product_edit'        => date('Y-m-d H:i:s'),
                    'product_status'      => $this->request->getVar('product_status'),
                ];

                $this->product->update($product_code, $update);

                $response = [
                    'success' => 'Data Berhasil Diupdate'
                ];
            }
            echo json_encode($response);
        }
    }

    public function restock()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'stock_type'    => 'required',
                'stock_qty'     => 'required',
            ];
    
            $errors = [
                'stock_type' => [
                    'required'   => 'Tipe restock produk harus dipilih.',
                ],
                'stock_qty' => [
                    'required'   => 'Jumlah restock produk harus diisi.',
                ]
            ];
            $valid = $this->validate($rules, $errors);
            if (!$valid) {
                $response = [
                    'error' => [
                        'stock_type'    => $validation->getError('stock_type'),
                        'stock_qty'     => $validation->getError('stock_qty'),
                    ]
                ];
            } else {
                $product_code = $this->request->getVar('product_code');
                $product      = $this->product->find($product_code);
                $product_qty  = $product['product_qty'];
                $stock_type   = $this->request->getVar('stock_type');
                $stock_qty    = $this->request->getVar('stock_qty');
                if ($stock_type == 'Penambahan') {
                    $product_qty_update = $product_qty + $stock_qty;
                } else {
                    $product_qty_update = $product_qty - $stock_qty;
                }
                
                $newStock = [
                    'stock_product'     => $product_code,
                    'stock_type'        => $stock_type,
                    'stock_qty'         => $stock_qty,
                    'stock_create'      => date('Y-m-d H:i:s'),
                    'stock_description' => trim(preg_replace('/\s\s+/', ' ', $this->request->getVar('stock_description'))),
                ];

                $updateProduct = [
                    'product_qty'       => $product_qty_update,
                ];

                $this->db->transStart();
                $this->product_stock->insert($newStock);
                $this->product->update($product_code, $updateProduct);
                $this->db->transComplete();

                $response = [
                    'success' => 'Data Produk Berhasil Direstock'
                ];
            }
            echo json_encode($response);
        }
    }
}