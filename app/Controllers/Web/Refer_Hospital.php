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

            $medical        = $this->medical->find($medical_code);

            if ($medical != 0) {
                $product     = $this->product->list_active($user_faskes);
                $treatment   = $this->treatment->list_active($user_faskes);
                $data = [
                    'title'         => 'Form Rujukan Kunjungan',
                    'user'          => $user,
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
}
