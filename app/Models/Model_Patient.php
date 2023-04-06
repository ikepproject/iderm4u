<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Patient extends Model
{
    protected $table      = 'tb_patient';
    protected $primaryKey = 'patient_code';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['patient_code', 'patient_name', 'patient_gender', 'patient_type', 'patient_birth', 'patient_address', 'patient_other', 'patient_create', 'patient_edit'];

    //Patient - getData
    public function list()
    {
        return $this->table('tb_patient')
            ->orderBy('patient_create', 'DESC')
            ->get()->getResultArray();
    }
}
