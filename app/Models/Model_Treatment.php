<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Treatment extends Model
{
    protected $table      = 'tb_treatment';
    protected $primaryKey = 'treatment_code';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['treatment_code', 'treatment_name', 'treatment_price', 'treatment_description', 'treatment_faskes', 'treatment_create', 'treatment_edit', 'treatment_status', 'treatment_discount', 'treatment_discount_price', 'treatment_type'];

    public function list($user_faskes)
    {
        return $this->table('tb_treatment')
            ->where('treatment_faskes', $user_faskes)
            ->orderBy('treatment_code', 'DESC')
            ->get()->getResultArray();
    }

    public function list_active($user_faskes)
    {
        return $this->table('tb_treatment')
            ->where('treatment_faskes', $user_faskes)
            ->where('treatment_status', 't')
            ->orderBy('treatment_type', 'ASC')
            ->orderBy('treatment_name', 'ASC')
            ->get()->getResultArray();
    }
}
