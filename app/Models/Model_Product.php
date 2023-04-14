<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Product extends Model
{
    protected $table      = 'tb_product';
    protected $primaryKey = 'product_code';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['product_code', 'product_name', 'product_price', 'product_qty', 'product_unit', 'product_description', 'product_faskes', 'product_create', 'product_edit', 'product_status', 'product_type'];

    public function list($user_faskes)
    {
        return $this->table('tb_product')
            ->where('product_faskes', $user_faskes)
            ->orderBy('product_code', 'DESC')
            ->get()->getResultArray();
    }

    public function list_active($user_faskes)
    {
        return $this->table('tb_product')
            ->where('product_faskes', $user_faskes)
            ->where('product_status', 't')
            ->orderBy('product_name', 'ASC')
            ->get()->getResultArray();
    }
}
