<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Employee extends Model
{
    protected $table      = 'tb_employee';
    protected $primaryKey = 'employee_code';
    protected $useAutoIncrement = false;
    protected $allowedFields = ['employee_code', 'employee_name', 'employee_position', 'employee_phone', 'employee_email', 'employee_address'];
}
