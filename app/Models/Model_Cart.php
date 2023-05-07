<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Cart extends Model
{
    protected $table      = 'tb_cart';
    protected $primaryKey = 'cart_id';
    protected $allowedFields = ['cart_user', 'cart_product', 'cart_qty', 'cart_create'];

    public function list($user_id)
    {
        return $this->table('tb_cart')
            ->where('cart_user', $user_id)
            ->orderBy('cart_create', 'DESC')
            ->get()->getResultArray();
    }

    public function find_user($user_id)
    {
        return $this->table('tb_cart')
            ->where('cart_user', $user_id)
            ->join('tb_product', 'tb_product.product_code = tb_cart.cart_product')
            ->orderBy('cart_create', 'DESC')
            ->get()->getResultArray();
    }
}
