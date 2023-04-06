<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Treatment_Discount extends Model
{
    protected $table      = 'tb_treatment_discount';
    protected $primaryKey = 'discount_id';
    protected $allowedFields = ['discount_treatment', 'discount_status', 'discount_create', 'discount_price_normal', 'discount_price', 'discount_description', 'discount_user'];

    public function list($treatment_code)
    {
        return $this->table('tb_treatment_discount')
            ->where('discount_treatment', $treatment_code)
            ->orderBy('discount_create', 'DESC')
            ->get()->getResultArray();
    }
}
