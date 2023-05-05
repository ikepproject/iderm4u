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

    public function flow($user_faskes, $month, $year)
    {
        return $this->table('tb_product_stock')
            ->join('tb_product', 'tb_product.product_code = tb_product_stock.stock_product')
            ->where('product_faskes', $user_faskes)
            ->where('EXTRACT(MONTH FROM stock_create)', $month)
            ->where('EXTRACT(YEAR FROM stock_create)', $year)
            ->orderBy('stock_create', 'DESC')
            ->get()->getResultArray();
    }

    public function flow_year($user_faskes, $year)
    {
        return $this->table('tb_product_stock')
            ->join('tb_product', 'tb_product.product_code = tb_product_stock.stock_product')
            ->where('product_faskes', $user_faskes)
            ->where('EXTRACT(YEAR FROM stock_create)', $year)
            ->orderBy('stock_create', 'DESC')
            ->get()->getResultArray();
    }
}
