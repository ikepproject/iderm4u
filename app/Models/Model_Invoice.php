<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Invoice extends Model
{
    protected $table      = 'tb_invoice';
    protected $primaryKey = 'invoice_id';
    protected $allowedFields = ['invoice_code', 'invoice_medical', 'invoice_amount', 'invoice_method', 'invoice_status', 'invoice_req', 'invoice_admin_fee', 'invoice_pay'];

    public function find_medical($medical_code)
    {
        return $this->table('tb_invoice')
            ->where('invoice_medical', $medical_code)
            ->join('tb_medical', 'tb_medical.medical_code = tb_invoice.invoice_medical')
            ->get()->getRowArray();
    }

    public function find_medical_ResultArray($medical_code)
    {
        return $this->table('tb_invoice')
            ->where('invoice_medical', $medical_code)
            ->join('tb_medical', 'tb_medical.medical_code = tb_invoice.invoice_medical')
            ->get()->getResultArray();
    }
}
