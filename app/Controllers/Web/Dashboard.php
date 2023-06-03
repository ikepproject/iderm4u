<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
	public function index()
	{
		$user 					= $this->userauth(); // Return Object
		$user_faskes 			= $user['user_faskes'];
		$user_id 				= $user['user_id'];

		/**--- HEALTHCARE DASHBOARD DATA ---*/
		$total_patient  		= $this->user->total_patient($user_faskes);

		$medical_current		= $this->db->query('SELECT COUNT(*) AS count_current_month FROM tb_medical WHERE EXTRACT(MONTH FROM medical_create) = EXTRACT(MONTH FROM CURRENT_TIMESTAMP) AND medical_faskes = ?', [$user_faskes]);
		$result_medical_current	= $medical_current->getResult();
		$count_current_month = $result_medical_current[0]->count_current_month;

		$medical_current_year		= $this->db->query('SELECT COUNT(*) AS count_current_year FROM tb_medical WHERE EXTRACT(YEAR FROM medical_create) = EXTRACT(YEAR FROM CURRENT_TIMESTAMP) AND medical_faskes = ?', [$user_faskes]);
		$result_medical_current_year	= $medical_current_year->getResult();
		$count_current_year = $result_medical_current_year[0]->count_current_year;

		$invoice_current 		= $this->db->query("SELECT SUM(invoice_amount) AS sum_current_month FROM tb_invoice JOIN tb_medical 
		ON tb_invoice.invoice_medical = tb_medical.medical_code WHERE EXTRACT(MONTH FROM medical_create) = EXTRACT(MONTH FROM CURRENT_TIMESTAMP) AND medical_faskes = ?", [$user_faskes]);
		$result_invoice_current = $invoice_current->getResult();
		$sum_current_month 		= $result_invoice_current[0]->sum_current_month;

		// Get the current year
		$currentYear = date('Y');

		// Retrieve the counts for each month in the current year
		$medical_counts_chart = $this->db->query('SELECT COUNT(*) AS count_current_month, EXTRACT(MONTH FROM medical_create) AS month FROM tb_medical WHERE EXTRACT(YEAR FROM medical_create) = ? AND medical_faskes = ? GROUP BY EXTRACT(MONTH FROM medical_create)', [$currentYear, $user_faskes]);
		$result_medical_counts_chart = $medical_counts_chart->getResult();

		// Prepare the data for the chart
		$chartData = [];
		foreach ($result_medical_counts_chart as $row) {
			$month = $row->month;
			$count = $row->count_current_month;

			// Map the month number to the corresponding month name
			$monthName = date('F', mktime(0, 0, 0, $month, 1));

			// Add the chartData point to the chart
			$chartData[] = [
				'x' => $monthName,
				'y' => $count,
			];
		}

		/**--- PATIENT DASHBOARD DATA ---*/
		$p1query = $this->db->query('SELECT COUNT(*) AS patient_medical FROM tb_medical WHERE medical_user = ? AND medical_creator_type = \'Admin\'', [$user_id]);
		$p1result = $p1query->getRow();
		$patient_medical = $p1result->patient_medical;

		$p2query = $this->db->query('SELECT COUNT(*) AS patient_order FROM tb_medical WHERE medical_user = ? AND medical_creator_type = \'Patient\'', [$user_id]);
		$p2result = $p2query->getRow();
		$patient_order = $p2result->patient_order;

		$p3query = $this->db->query('SELECT COUNT(*) AS patient_appointment FROM tb_appointment WHERE appointment_user = ? AND appointment_type = \'Lokal\'', [$user_id]);
		$p3result = $p3query->getRow();
		$patient_appointment = $p3result->patient_appointment;

		$data = [
			'title' 				=> 'Dashboard',
			'user'  				=> $user,
			'total_patient'			=> $total_patient,
			'count_current_month'	=> $count_current_month,
			'count_current_year'	=> $count_current_year,
			'sum_current_month'		=> $sum_current_month,
			'chartData'				=> json_encode($chartData),
			'patient_medical' 		=> $patient_medical,
			'patient_order'			=> $patient_order,
			'patient_appointment'	=> $patient_appointment,
			'treatment_discount'	=> $this->treatment->list_discount($user_faskes),
		];
		return view('panel/dashboard', $data);
	}
}