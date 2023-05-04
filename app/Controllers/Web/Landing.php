<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Landing extends BaseController
{
    public function index()
    {
        $data = [
			'title' => 'The Best Intelligent Teledermatology System in Indonesia',
		];
        return view('index', $data);
    }

    public function privacy()
    {
        $data = [
			'title' => 'Privacy Policy iDerm4U',
		];
        return view('page_privacy', $data);
    }

    public function toc()
    {
        $data = [
			'title' => 'Terms and Conditions iDerm4U',
		];
        return view('page_tos', $data);
    }

    public function test_pruchase()
    {
        // $user        = $this->userauth(); //Return array
        $user_faskes = 'MC01';
        $product     = $this->product->list_active($user_faskes);
        $treatment   = $this->treatment->list_active($user_faskes);
		$data = [
			'title'     => 'Order Treatment/Product Pasien (*Test Version)',
			// 'user'      => $user,
            'product'   => $product,
            'treatment' => $treatment
		];
		return view('stagging/test_purchase', $data);
    }

    public function test_checkout()
    {
        $response = [
            'success' => 'Data test tidak akan disimpan',
            'link'    => 'test/purchase', 
        ];
        echo json_encode($response);
    }
}
