<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Type extends Model
{
    protected $table      = 'tb_type';
    protected $primaryKey = 'type_id';
    protected $allowedFields = ['type_name', 'type_category', 'type_faskes', 'type_status', 'type_create'];

    public function list($category, $faskes)
    {
        return $this->table('tb_type')
            ->where('type_category', $category)
            ->where('type_faskes', $faskes)
            ->where('type_status', 't')
            ->orderBy('type_name', 'ASC')
            ->get()->getResultArray();
    }
}
