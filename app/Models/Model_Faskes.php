<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Faskes extends Model
{
    protected $table      = 'tb_faskes';
    protected $primaryKey = 'faskes_code';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['faskes_code', 'faskes_name', 'faskes_initial', 'faskes_type', 'faskes_phone', 'faskes_province', 'faskes_city', 'faskes_address', 'faskes_key', 'faskes_refer_price', 'faskes_refer_note', 'faskes_server_key', 'faskes_client_key','faskes_refersf_price'];

    public function list_faskes()
    {
        return $this->table('tb_faskes')
            ->where('faskes_type', 'Rumah Sakit')
            ->get()->getResultArray();
    }
}
