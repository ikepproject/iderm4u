<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Product_Stock extends Model
{
    protected $table      = 'tb_product_stock';
    protected $primaryKey = 'stock_id';
    protected $allowedFields = ['stock_product', 'stock_type', 'stock_qty', 'stock_create', 'stock_description'];

    public function list($product_code)
    {
        return $this->table('tb_product_stock')
            ->where('stock_product', $product_code)
            ->orderBy('stock_create', 'DESC')
            ->get()->getResultArray();
    }
}
