<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Appointment extends BaseController
{
    public function index()
	{
		$user = $this->userauth(); //Return array
		$data = [
			'title'  => 'Produk Order (PO)',
			'user'   => $user,
		];
		return view('panel_faskes/appointment/index', $data);
	}

    public function getdata()
    {
        if ($this->request->isAJAX()) {
            $user        = $this->userauth(); //Return array
            $user_faskes = $user['user_faskes'];
            $list        = $this->appointment->list($user_faskes);

            $data = [
                'list' => $list,
            ];

            $response = [
                'data' => view('panel_faskes/appointment/list', $data)
            ];
            
            echo json_encode($response);
        }
    }

}
