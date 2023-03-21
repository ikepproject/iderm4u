<?php

namespace App\Controllers\Api;
use App\Libraries\JWTCI4;
use App\Models\Model_User;

use CodeIgniter\RESTful\ResourceController;

class WebPatient extends ResourceController
{
    protected $helpers = ['form', 'url', 'cookie'];

    public function userauth(){
		$token   = get_cookie('gem');
		$jwt     = new JWTCI4;
		$user	 = $jwt->decodeweb($token);
		$user_id = $user->uid;
        $tb_user = new Model_User;
		$userdata= $tb_user->find($user_id);
		return $userdata;
	}

    //Get Data Faskes Patient Must Login
    public function get()
    {
        $user        = $this->userauth();
        $user_faskes = $user['user_faskes'];
                
        $tb_user     = new Model_User;
        if ($this->request->getVar('searchTerm') == TRUE) {
			$item = $tb_user->api_list_patient_like($user_faskes, $this->request->getVar('searchTerm'));
		} else {
            $item = $tb_user->api_list_patient($user_faskes);
        }
        $data = [
            "items" => $item,
        ];

        return $this->response->setJSON($data);
    }
    
}
