<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
	public function index()
	{
		$user 					= $this->userauth(); // Return Object
		$user_faskes 			= $user['user_faskes'];

		$total_patient  		= $this->user->total_patient($user_faskes);

		$medical_current		= $this->db->query('SELECT COUNT(*) AS count_current_month FROM tb_medical WHERE EXTRACT(MONTH FROM medical_create) = EXTRACT(MONTH FROM CURRENT_TIMESTAMP) AND medical_faskes = ?', [$user_faskes]);
		$result_medical_current	= $medical_current->getResult();
		$count_current_month = $result_medical_current[0]->count_current_month;

		$invoice_current 		= $this->db->query("SELECT SUM(invoice_amount) AS sum_current_month FROM tb_invoice JOIN tb_medical 
		ON tb_invoice.invoice_medical = tb_medical.medical_code WHERE EXTRACT(MONTH FROM medical_create) = EXTRACT(MONTH FROM CURRENT_TIMESTAMP) AND medical_faskes = ?", [$user_faskes]);
		$result_invoice_current = $invoice_current->getResult();
		$sum_current_month 		= $result_invoice_current[0]->sum_current_month;

		$data = [
			'title' 				=> 'Dashboard',
			'user'  				=> $user,
			'total_patient'			=> $total_patient,
			'count_current_month'	=> $count_current_month,
			'sum_current_month'		=> $sum_current_month
		];
		return view('panel/dashboard', $data);
	}
}