<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Midtrans extends Model
{
    protected $table      = 'tb_midtrans';
    protected $primaryKey = 'order_id';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['transaction_id', 'status_code', 'status_message', 'payment_type', 'gross_amount', 'transaction_time', 'transaction_status', 'fraud_status', 'bank', 'va_number', 'code'];

    public function count_order_id($order_id)
    {
        return $this->table('tb_midtrans')
            ->selectCount('order_id')
            ->where('order_id', $order_id)
            ->get()->getRowArray();
    }
}
