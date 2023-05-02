<?php

namespace App\Controllers\Api;
use App\Libraries\JWTCI4;
use App\Models\Model_User;
use App\Models\Model_Medgal;

use CodeIgniter\RESTful\ResourceController;

class Diagnose extends ResourceController
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

    //Clasify
    public function clasify()
    {
        $input = $this->request->getJSON();

        $data = [
            'medgal_prediction' => json_encode($input->result)
        ];
        $tb_medgal = new Model_Medgal;
        $inserted = $this->$tb_medgal->update($input->img_id, $data);

        if ($inserted) {
            return $this->respondCreated(['message' => 'Clasified Data Success']);
        } else {
            return $this->fail('An error occurred while saving data');
        }
    }
    
}
