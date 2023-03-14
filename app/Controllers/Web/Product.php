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
                'title' => 'Tambah Product',
                'user'   => $user,
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
            $product_code = $this->request->getVar('product_code');
            $product      = $this->product->find($product_code);
            $data = [
                'title'     => 'Edit Data Product',
                'product'   => $product,
            ];
            $response = [
                'data' => view('panel_faskes/product/edit', $data)
            ];
            echo json_encode($response);
        }
    }

    public function create()
    {
        if ($this->request->isAJAX()) {
            $validation = \Config\Services::validation();
            $rules = [
                'product_name'    => 'required',
                'product_price'   => 'required',
                'product_qty'     => 'required',
                'product_unit'    => 'required',
                'product_status'  => 'required',
            ];
    
            $errors = [
                'product_name' => [
                    'required'   => 'Nama produk harus diisi.',
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
                    'product_price'       => $product_price,
                    'product_qty'         => $this->request->getVar('product_qty'),
                    'product_unit'        => $this->request->getVar('product_unit'),
                    'product_description' => $this->request->getVar('product_description'),
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
                'product_price'   => 'required',
                'product_qty'     => 'required',
                'product_unit'    => 'required',
                'product_status'  => 'required',
            ];
    
            $errors = [
                'product_name' => [
                    'required'   => 'Nama produk harus diisi.',
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
                        'product_price'     => $validation->getError('product_price'),
                        'product_qty'       => $validation->getError('product_qty'),
                        'product_unit'      => $validation->getError('product_unit'),
                        'product_status'    => $validation->getError('product_status'),
                    ]
                ];
            } else {
                $product_code = $this->request->getVar('product_code');
                $product_price= str_replace(str_split('Rp. .'), '', $this->request->getVar('product_price'));

                $update = [
                    'product_name'        => $this->request->getVar('product_name'),
                    'product_price'       => $product_price,
                    'product_qty'         => $this->request->getVar('product_qty'),
                    'product_unit'        => $this->request->getVar('product_unit'),
                    'product_description' => $this->request->getVar('product_description'),
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
}