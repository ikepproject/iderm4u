<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_User extends Model
{
    protected $table      = 'tb_user';
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['user_email','user_password','user_role','user_faskes', 'user_patient', 'user_employee', 'user_create', 'user_edit', 'user_active', 'user_photo', 'user_name'];

    public function list_patient($user_faskes)
    {
        return $this->table('tb_user')
            ->where('user_role', '1011')
            ->where('user_faskes', $user_faskes)
            ->where('user_active', 't')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->orderBy('user_id', 'DESC')
            ->get()->getResultArray();
    }

    public function api_list_patient($user_faskes)
    {
        return $this->table('tb_user')
            ->select('tb_user.user_id as id, tb_user.user_faskes as faskes, tb_user.user_email as email, tb_user.user_photo as photo, tb_patient.*' )
            ->where('user_role', '1011')
            ->where('user_faskes', $user_faskes)
            ->where('user_active', 't')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->orderBy('patient_name', 'ASC')
            ->get()->getResult();
    }

    public function api_list_patient_like($user_faskes, $searchTerm)
    {
        return $this->table('tb_user')
            ->select('tb_user.user_id as id, tb_user.user_faskes as faskes, tb_user.user_email as email, tb_user.user_photo as photo, tb_patient.*' )
            ->where('user_role', '1011')
            ->where('user_faskes', $user_faskes)
            ->where('user_active', 't')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->where('patient_name', $searchTerm)
            ->orderBy('patient_name', 'ASC')
            ->get()->getResultArray();
    }

    public function find_patient($user_id)
    {
        return $this->table('tb_user')
            ->where('user_id', $user_id)
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->get()->getRowArray();
    }
}
