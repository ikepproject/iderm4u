<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Visitor extends Model
{
    protected $table      = 'tb_visitor';
    protected $primaryKey = 'visitor_id';
    protected $allowedFields = ['visitor_user', 'visitor_ip', 'visitor_login', 'visitor_exp'];

}
