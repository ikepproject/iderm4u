<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Medical extends Model
{
    protected $table      = 'tb_medical';
    protected $primaryKey = 'medical_code';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['medical_code', 'medical_faskes', 'medical_create', 'medical_type', 'medical_description', 'medical_employee', 'medical_user', 'medical_status', 'medical_creator_type', 'medical_refer_type', 'medical_refer_origin', 'medical_refer_code'];

    //Medical - getData (Klinik)
    public function list($user_faskes)
    {
        return $this->table('tb_medical')
            ->where('medical_faskes', $user_faskes)
            ->where('medical_creator_type', 'Admin')
            ->orderBy('medical_create', 'DESC')
            ->join('tb_user', 'tb_user.user_id = tb_medical.medical_user')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->get()->getResultArray();
    }

    //Medical - getData (RS)
    public function list_rs($user_faskes)
    {
        return $this->table('tb_medical')
            ->where('medical_faskes', $user_faskes)
            ->where('medical_creator_type', 'Admin')
            ->where('medical_refer_type', NULL)
            ->orderBy('medical_create', 'DESC')
            ->join('tb_user', 'tb_user.user_id = tb_medical.medical_user')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->get()->getResultArray();
    }

    //Patient - Detail
    public function list_by_user($medical_user)
    {
        return $this->table('tb_medical')
            ->where('medical_user', $medical_user)
            ->orderBy('medical_create', 'DESC')
            ->join('tb_user', 'tb_user.user_id = tb_medical.medical_user')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->join('tb_invoice', 'tb_invoice.invoice_medical = tb_medical.medical_code')
            ->get()->getResultArray();
    }

    //Refer - getData (Klinik)
    public function list_refer_klinik($user_faskes)
    {
        return $this->table('tb_medical')
            ->where('medical_refer_origin', $user_faskes)
            ->where('medical_creator_type', 'Admin')
            ->orderBy('medical_create', 'DESC')
            ->join('tb_user', 'tb_user.user_id = tb_medical.medical_user')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->join('tb_appointment', 'tb_appointment.appointment_medical = tb_medical.medical_code')
            ->get()->getResultArray();
    }

    //Refer - getData (RS)
    public function list_refer_rs($user_faskes)
    {
        return $this->table('tb_medical')
            ->where('medical_faskes', $user_faskes)
            ->where('medical_refer_type !=', NULL)
            ->where('medical_creator_type', 'Admin')
            ->orderBy('medical_create', 'DESC')
            ->join('tb_user', 'tb_user.user_id = tb_medical.medical_user')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->join('tb_appointment', 'tb_appointment.appointment_medical = tb_medical.medical_code')
            ->get()->getResultArray();
    }

    //Product Order - getData (Klinik)
    public function list_product_order($user_faskes)
    {
        return $this->table('tb_medical')
            ->where('medical_faskes', $user_faskes)
            ->where('medical_type', 'Product')
            ->where('medical_creator_type', 'Patient')
            ->orderBy('medical_create', 'DESC')
            ->join('tb_user', 'tb_user.user_id = tb_medical.medical_user')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->get()->getResultArray();
    }
}
