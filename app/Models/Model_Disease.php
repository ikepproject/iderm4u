<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Disease extends Model
{
    protected $table      = 'tb_disease';
    protected $primaryKey = 'disease_id';
    protected $allowedFields = ['disease_code', 'disease_name'];

    public function list()
    {
        return $this->table('tb_type')
            ->orderBy('disease_id', 'ASC')
            ->get()->getResultArray();
    }
}
