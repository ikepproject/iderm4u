<?php

namespace App\Controllers\Api;
use App\Libraries\JWTCI4;
use App\Models\Model_User;
use App\Models\Model_Medgal;
use App\Models\Model_Faskes;

use CodeIgniter\RESTful\ResourceController;

class Test extends ResourceController
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

    public function encrypt()
    {
        $config         = new \Config\Encryption();
        $config->key    = getenv("encrypt_key");
        // ENCRYPTION
        $encrypter  = \Config\Services::encrypter($config, false);
        $plainText  = 't';
        $enc        = $encrypter->encrypt($plainText);
        $enc2       = base64_encode($enc);
        var_dump($enc2);
    }

    public function decrypt()
    {
        $config         = new \Config\Encryption();
        $config->key    = getenv("encrypt_key");
        // $config->rawData = false;

        // ENCRYPTION
        $encrypter  = \Config\Services::encrypter($config, false);
        $enc        = 'IN3XGnxX+bf6dDjpMWJrpIbRFKmodlsBUFEu0teVtgznqSyybReHUUvmeUW1fczE3Ho5OIjWpV3ZaMAQePPkJFLucNdU8sYn3xHx2kA3H8kaQit7SlUlS0y6DA4oua/NW1MhhzlBxdDXUf/m3+dV8nJglhT3Tw==';
        $dec        = $encrypter->decrypt(base64_decode($enc));
        var_dump($dec);
    }

    public function check()
    {
        // $tb_faskes = new Model_Faskes;
		// $user               = $this->userauth(); 
        // $user_faskes        = $user['user_faskes'];
        // $faskes             = $tb_faskes->find($user_faskes);
        // $faskes_client_key  = $faskes['faskes_client_key'];
        // var_dump($faskes_client_key);

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        $mobile_agents = array(
            'Mobile', 'Android', 'Silk/', 'Kindle', 'BlackBerry', 
            'Opera Mini', 'Opera Mobi'
        );
        foreach ($mobile_agents as $mobile_agent) {
            if (strpos($user_agent, $mobile_agent) !== false) {
                $result = 'hp';
            } else {
                $result = 'pc';
            }
        }
        var_dump(getenv("MidtransisProduction"));
    }
    
}
