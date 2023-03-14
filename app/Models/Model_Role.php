<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Role extends Model
{
    protected $table      = 'tb_role';
    protected $primaryKey = 'role_code';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['role_code', 'role_name', 'role_create', 'role_edit'];
}
