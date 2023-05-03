<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Medtreat extends Model
{
    protected $table      = 'tb_medical_treatment';
    protected $primaryKey = 'medtreat_id';
    protected $allowedFields = ['medtreat_medical', 'medtreat_treatment', 'medtreat_description', 'medtreat_price', 'medtreat_name', 'medtreat_discount', 'medtreat_discount_price'];

    public function find_medical($medical_code)
    {
        return $this->table('tb_medical_treatment')
            ->where('medtreat_medical', $medical_code)
            ->join('tb_medical', 'tb_medical.medical_code = tb_medical_treatment.medtreat_medical')
            ->join('tb_treatment', 'tb_treatment.treatment_code = tb_medical_treatment.medtreat_treatment')
            ->get()->getResultArray();
    }

    public function report($user_faskes, $month, $year)
    {
        return $this->table('tb_medical_treatment')
            ->join('tb_medical', 'tb_medical.medical_code = tb_medical_treatment.medtreat_medical')
            // ->join('tb_user', 'tb_user.user_id = tb_medical.medical_user')
            // ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->join('tb_invoice', 'tb_invoice.invoice_medical = tb_medical.medical_code')
            ->where('medical_faskes', $user_faskes)
            ->where('EXTRACT(MONTH FROM medical_create)', $month)
            ->where('EXTRACT(YEAR FROM medical_create)', $year)
            ->orderBy('medical_create', 'DESC')
            ->get()->getResultArray();
    }

    public function report_year($user_faskes, $year)
    {
        return $this->table('tb_medical_treatment')
            ->join('tb_medical', 'tb_medical.medical_code = tb_medical_treatment.medtreat_medical')
            // ->join('tb_user', 'tb_user.user_id = tb_medical.medical_user')
            // ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->join('tb_invoice', 'tb_invoice.invoice_medical = tb_medical.medical_code')
            ->where('medical_faskes', $user_faskes)
            ->where('EXTRACT(YEAR FROM medical_create)', $year)
            ->orderBy('medical_create', 'DESC')
            ->get()->getResultArray();
    }
}
