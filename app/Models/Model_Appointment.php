<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Appointment extends Model
{
    protected $table      = 'tb_appointment';
    protected $primaryKey = 'appointment_id';
    protected $allowedFields = ['appointment_code', 'appointment_faskes', 'appointment_user', 'appointment_status', 'appointment_type', 'appointment_create', 'appointment_date_expect', 'appointment_date_fix', 'appointment_medical', 'appointment_link', 'appointment_note_user', 'appointment_note_faskes'];
}
