<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Appointment extends Model
{
    protected $table      = 'tb_appointment';
    protected $primaryKey = 'appointment_id';
    protected $allowedFields = ['appointment_code', 'appointment_faskes', 'appointment_user', 'appointment_status', 'appointment_type', 'appointment_create', 'appointment_date_expect', 'appointment_date_fix', 'appointment_medical', 'appointment_link', 'appointment_note_user', 'appointment_note_faskes'];

    public function list($user_faskes)
    {
        return $this->table('tb_appointment')
            ->where('appointment_faskes', $user_faskes)
            ->join('tb_user', 'tb_user.user_id = tb_appointment.appointment_user')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->get()->getResultArray();
    }

    public function find_medical($medical_code)
    {
        return $this->table('tb_appointment')
            ->where('appointment_medical', $medical_code)
            ->join('tb_user', 'tb_user.user_id = tb_appointment.appointment_user')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->get()->getRowArray();
    }

    // Appointment Menu - Patient Role
    public function list_patient($user_id)
    {
        return $this->table('tb_appointment')
            ->where('appointment_user', $user_id)
            ->join('tb_user', 'tb_user.user_id = tb_appointment.appointment_user')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->join('tb_faskes', 'tb_faskes.faskes_code = tb_appointment.appointment_faskes')
            ->orderBy('appointment_id', 'DESC')
            ->get()->getResultArray();
    }

    // Appointment Menu - Patient Role
    public function appointment_pending($user_id)
    {
        return $this->table('tb_appointment')
            ->where('appointment_user', $user_id)
            ->where('appointment_status', 'Diajukan')
            ->get()->getResultArray();
    }
    
    // Appointment Menu - Patient Role
    public function find_id($appointment_id)
    {
        return $this->table('tb_appointment')
            ->where('appointment_id', $appointment_id)
            ->join('tb_user', 'tb_user.user_id = tb_appointment.appointment_user')
            ->join('tb_patient', 'tb_patient.patient_code = tb_user.user_patient')
            ->join('tb_faskes', 'tb_faskes.faskes_code = tb_appointment.appointment_faskes')
            ->get()->getRowArray();
    }
}
