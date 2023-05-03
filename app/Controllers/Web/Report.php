<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Report extends BaseController
{
    public function report_treatment()
	{
		$user        = $this->userauth(); //Return array
        $user_faskes = $user['user_faskes'];

        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 2 && array_key_exists('month', $params) && array_key_exists('year', $params)) {
            $month = $params['month'];
            $year  = $params['year'];

            if (is_string($year)) {
                $year = date('Y');
            }

            if (ctype_alpha($month) && $month != 'all') {
                $month = date('m');
            }

            if ($month >= 1 && $month <= 9) { 
                $month = str_pad($month, 2, '0', STR_PAD_LEFT);
            }

            if ($month == 'all') {
                $list  = $this->medtreat->report_year($user_faskes, $year);
            } else {
                $list  = $this->medtreat->report($user_faskes, $month, $year);
            }
            
        } else{
            $month = date('m');
            $year  = date('Y');
            $list  = $this->medtreat->report($user_faskes, $month, $year);
        }

        $query_month    = $this->db->query('SELECT DISTINCT EXTRACT(MONTH FROM medical.medical_create) AS month_number, to_char(medical.medical_create, \'Month\') AS month_name FROM tb_medical_treatment medtreat JOIN tb_medical medical ON medtreat.medtreat_medical = medical.medical_code');
        $query_year     = $this->db->query('SELECT DISTINCT EXTRACT(YEAR FROM medical.medical_create) AS year FROM tb_medical_treatment medtreat JOIN tb_medical medical ON medtreat.medtreat_medical = medical.medical_code');

        $unique_month   = $query_month->getResultArray();
        $unique_year    = $query_year->getResultArray();

		$data = [
			'title'         => 'Laporan Treatment',
			'user'          => $user,
            'unique_month'  => $unique_month,
            'unique_year'   => $unique_year,
            'month'         => $month,
            'year'          => $year,
            'list'          => $list
		];
		return view('panel_faskes/report/treatment', $data);
	}

    public function report_treatment_filter()
    {
        $month_filter = $this->request->getVar('month_filter'); 
        $year_filter = $this->request->getVar('year_filter');

        $queryParam = 'month=' . $month_filter . '&year=' . $year_filter;

        $newUrl = 'report-treatment?' . $queryParam; 

        return redirect()->to($newUrl);
    }

    public function report_product()
	{
		$user        = $this->userauth(); //Return array
        $user_faskes = $user['user_faskes'];

        $uri            = new \CodeIgniter\HTTP\URI(current_url(true));
        $queryString    = $uri->getQuery();
        $params         = [];
        parse_str($queryString, $params);

        if (count($params) == 2 && array_key_exists('month', $params) && array_key_exists('year', $params)) {
            $month = $params['month'];
            $year  = $params['year'];

            if (is_string($year)) {
                $year = date('Y');
            }

            if (ctype_alpha($month) && $month != 'all') {
                $month = date('m');
            }

            if ($month >= 1 && $month <= 9) { 
                $month = str_pad($month, 2, '0', STR_PAD_LEFT);
            }

            if ($month == 'all') {
                $list  = $this->medprod->report_year($user_faskes, $year);
            } else {
                $list  = $this->medprod->report($user_faskes, $month, $year);
            }
            
        } else{
            $month = date('m');
            $year  = date('Y');
            $list  = $this->medprod->report($user_faskes, $month, $year);
        }

        $query_month    = $this->db->query('SELECT DISTINCT EXTRACT(MONTH FROM medical.medical_create) AS month_number, to_char(medical.medical_create, \'Month\') AS month_name FROM tb_medical_product medprod JOIN tb_medical medical ON medprod.medprod_medical = medical.medical_code');
        $query_year     = $this->db->query('SELECT DISTINCT EXTRACT(YEAR FROM medical.medical_create) AS year FROM tb_medical_product medprod JOIN tb_medical medical ON medprod.medprod_medical = medical.medical_code');


        $unique_month   = $query_month->getResultArray();
        $unique_year    = $query_year->getResultArray();

		$data = [
			'title'         => 'Laporan Product',
			'user'          => $user,
            'unique_month'  => $unique_month,
            'unique_year'   => $unique_year,
            'month'         => $month,
            'year'          => $year,
            'list'          => $list
		];
		return view('panel_faskes/report/product', $data);
	}

    public function report_product_filter()
    {
        $month_filter = $this->request->getVar('month_filter'); 
        $year_filter = $this->request->getVar('year_filter');

        $queryParam = 'month=' . $month_filter . '&year=' . $year_filter;

        $newUrl = 'report-product?' . $queryParam; 

        return redirect()->to($newUrl);
    }
}