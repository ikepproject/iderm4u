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
use App\Models\Model_Role;
use App\Models\Model_Treatment;
use App\Models\Model_User;
use App\Models\Model_Visitor;
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
}
