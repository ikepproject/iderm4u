<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Medtreat extends Model
{
    protected $table      = 'tb_medical_treatment';
    protected $primaryKey = 'medtreat_id';
    protected $allowedFields = ['medtreat_medical', 'medtreat_treatment', 'medtreat_description', 'medtreat_price', 'medtreat_name'];

    public function find_medical($medical_code)
    {
        return $this->table('tb_medical_treatment')
            ->where('medtreat_medical', $medical_code)
            ->join('tb_medical', 'tb_medical.medical_code = tb_medical_treatment.medtreat_medical')
            ->join('tb_treatment', 'tb_treatment.treatment_code = tb_medical_treatment.medtreat_treatment')
            ->get()->getResultArray();
    }
}
