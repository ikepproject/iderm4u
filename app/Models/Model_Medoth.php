<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Medoth extends Model
{
    protected $table      = 'tb_medical_other';
    protected $primaryKey = 'medoth_id';
    protected $allowedFields = ['medoth_medical', 'medoth_name', 'medoth_qty', 'medoth_price', 'medoth_description'];

    public function find_medical($medical_code)
    {
        return $this->table('tb_medical_other')
            ->where('medoth_medical', $medical_code)
            ->join('tb_medical', 'tb_medical.medical_code = tb_medical_other.medoth_medical')
            ->get()->getResultArray();
    }
}
