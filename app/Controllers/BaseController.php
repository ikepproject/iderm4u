<?php

namespace App\Controllers;
use App\Libraries\JWTCI4;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */
use CodeIgniter\Controller;
use App\Models\Model_Employee;
use App\Models\Model_Faskes;
use App\Models\Model_Invoice;
use App\Models\Model_Medgal;
use App\Models\Model_Medical;
use App\Models\Model_Medoth;
use App\Models\Model_Medprod;
use App\Models\Model_Medtreat;
use App\Models\Model_Patient;
use App\Models\Model_Product;
use App\Models\Model_Product_Stock;
use App\Models\Model_Role;
use App\Models\Model_Treatment;
use App\Models\Model_User;
use App\Models\Model_Visitor;
use App\Models\Model_Appointment;
use CodeIgniter\Model;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'url', 'cookie', 'Tgl_indo'];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		$this->session 		= \Config\Services::session();
		$this->user 		= new Model_User;
		$this->visitor 		= new Model_Visitor;
		$this->role 		= new Model_Role;
		$this->faskes		= new Model_Faskes;
		$this->patient		= new Model_Patient;
		$this->employee 	= new Model_Employee;
		$this->product 		= new Model_Product;
		$this->treatment 	= new Model_Treatment;
		$this->medical 	 	= new Model_Medical;
		$this->medprod 		= new Model_Medprod;
		$this->medtreat 	= new Model_Medtreat;
		$this->medoth 		= new Model_Medoth;
		$this->medgal 		= new Model_Medgal;
		$this->invoice 		= new Model_Invoice;
		$this->product_stock= new Model_Product_Stock();
		$this->appointment	= new Model_Appointment();
		$this->db 			= \Config\Database::connect();
	}

	public function userauth(){
		$token   = get_cookie('gem');
		$jwt     = new JWTCI4;
		$user	 = $jwt->decodeweb($token);
		$user_id = $user->uid;
		$userdata= $this->user->find($user_id);
		return $userdata;
	}

	public function generate_patient_code()
	{
        $user_faskes 		= $this->request->getVar('user_faskes');
        $last        		= $this->user->last_patient_code($user_faskes);
        $faskes      		= $this->faskes->find($user_faskes);
        $initial     		= $faskes['faskes_initial'];
		if ($last == NULL) {
            $last           = '00001';
            $patient_code   = $initial . '-'  . $last;
        } else {
            $last           = $last['patient_code'];
            $code0          = substr($last, -5); // get last 5 char
            $code1          = substr($last,0, 3); // get 3 first char
            $code2          = $code0 + 1;
            $code2          = str_pad($code2,5,"0",STR_PAD_LEFT);
            $patient_code   = $code1 . $code2;
        }
		return $patient_code;
	}

    public function generate_medical_code()
    {
        $user               = $this->userauth(); // Return array
        $user_faskes        = $user['user_faskes'];
        $faskes             = $this->faskes->find($user_faskes);
        $initial            = $faskes['faskes_initial'];
        $last               = $this->medical->where('medical_faskes', $user_faskes )->orderBy('medical_code', 'desc')->first();
        
        if ($last == NULL) {
            $last           = '0000001';
            $medical_code   = 'MED-' . $initial . '-'  . $last;
        } else {
            $last           = $last['medical_code'];
            $code0          = substr($last, -7); // get last 7 char
            $code1          = substr($last,0, 7); // get 7 first char
            $code2          = $code0 + 1;
            $code2          = str_pad($code2,7,"0",STR_PAD_LEFT);
            $medical_code   = $code1 . $code2;
        }
        return $medical_code;
    }

	public function generate_medical_code_rujukan($faskes_code, $faskes_initial)
    {
        $initial            = $faskes_initial;
        $last               = $this->medical->where('medical_faskes', $faskes_code )->orderBy('medical_code', 'desc')->first();
        
        if ($last == NULL) {
            $last           = '0000001';
            $medical_code   = 'MED-' . $initial . '-'  . $last;
        } else {
            $last           = $last['medical_code'];
            $code0          = substr($last, -7); // get last 7 char
            $code1          = substr($last,0, 7); // get 7 first char
            $code2          = $code0 + 1;
            $code2          = str_pad($code2,7,"0",STR_PAD_LEFT);
            $medical_code   = $code1 . $code2;
        }
        return $medical_code;
    }

	public function generate_appointment_code_rujukan($faskes_code, $faskes_initial)
    {
        $initial            = $faskes_initial;
        $last               = $this->medical->where('medical_faskes', $faskes_code )->orderBy('medical_code', 'desc')->first();
        
        if ($last == NULL) {
            $last           = '00001';
            $medical_code   = 'AP-' . $initial . '-'  . $last;
        } else {
            $last           = $last['medical_code'];
            $code0          = substr($last, -5); // get last 5 char
            $code1          = substr($last,0, 6); // get 6 first char
            $code2          = $code0 + 1;
            $code2          = str_pad($code2,5,"0",STR_PAD_LEFT);
            $medical_code   = $code1 . $code2;
        }
        return $medical_code;
    }
}
