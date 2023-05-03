<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Medprod extends Model
{
    protected $table      = 'tb_medical_product';
    protected $primaryKey = 'medprod_id';
    protected $allowedFields = ['medprod_medical', 'medprod_product', 'medprod_qty', 'medprod_description', 'medprod_price', 'medprod_name'];

    public function find_medical($medical_code)
    {
        return $this->table('tb_medical_product')
            ->where('medprod_medical', $medical_code)
            ->join('tb_medical', 'tb_medical.medical_code = tb_medical_product.medprod_medical')
            ->join('tb_product', 'tb_product.product_code = tb_medical_product.medprod_product')
            ->get()->getResultArray();
    }

    public function report($user_faskes, $month, $year)
    {
        return $this->table('tb_medical_product')
            ->join('tb_medical', 'tb_medical.medical_code = tb_medical_product.medprod_medical')
            // ->join('tb_user', 'tb_user.user_id = tb_medical.medical_user')
            // ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->join('tb_product', 'tb_product.product_code = tb_medical_product.medprod_product')
            ->join('tb_invoice', 'tb_invoice.invoice_medical = tb_medical.medical_code')
            ->where('medical_faskes', $user_faskes)
            ->where('EXTRACT(MONTH FROM medical_create)', $month)
            ->where('EXTRACT(YEAR FROM medical_create)', $year)
            ->orderBy('medical_create', 'DESC')
            ->get()->getResultArray();
    }

    public function report_year($user_faskes, $year)
    {
        return $this->table('tb_medical_product')
            ->join('tb_medical', 'tb_medical.medical_code = tb_medical_product.medprod_medical')
            // ->join('tb_user', 'tb_user.user_id = tb_medical.medical_user')
            // ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->join('tb_product', 'tb_product.product_code = tb_medical_product.medprod_product')
            ->join('tb_invoice', 'tb_invoice.invoice_medical = tb_medical.medical_code')
            ->where('medical_faskes', $user_faskes)
            ->where('EXTRACT(YEAR FROM medical_create)', $year)
            ->orderBy('medical_create', 'DESC')
            ->get()->getResultArray();
    }
}
