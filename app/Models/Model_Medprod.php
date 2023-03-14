<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Medprod extends Model
{
    protected $table      = 'tb_medical_product';
    protected $primaryKey = 'medprod_id';
    protected $allowedFields = ['medprod_medical', 'medprod_product', 'medprod_qty', 'medprod_description', 'medprod_discount'];

    public function find_medical($medical_code)
    {
        return $this->table('tb_medical_product')
            ->where('medprod_medical', $medical_code)
            ->join('tb_medical', 'tb_medical.medical_code = tb_medical_product.medprod_medical')
            ->join('tb_product', 'tb_product.product_code = tb_medical_product.medprod_product')
            ->get()->getResultArray();
    }
}
