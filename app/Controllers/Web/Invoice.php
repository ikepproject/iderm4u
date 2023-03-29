<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Invoice extends BaseController
{
    public function index()
	{
		$user = $this->userauth(); //Return array
		$data = [
			'title'  => 'Invoice',
			'user'   => $user,
		];
		return view('panel_faskes/invoice/index', $data);
	}

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); //Return array
            $user_faskes = $user['user_faskes'];
            $list        = $this->invoice->list($user_faskes);

            $data = [
                'list' => $list,
            ];

            $response = [
                'data' => view('panel_faskes/invoice/list', $data)
            ];
            
            echo json_encode($response);
        }
    }

}
