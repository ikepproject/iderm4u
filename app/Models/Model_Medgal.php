<?php

namespace App\Models;

use CodeIgniter\Model;

class Model_Medgal extends Model
{
    protected $table      = 'tb_medical_gallery';
    protected $primaryKey = 'medgal_id';
    protected $allowedFields = ['medgal_medical', 'medgal_create', 'medgal_filename'];

    public function find_medical($medical_code)
    {
        return $this->table('tb_medical_gallery')
            ->where('medgal_medical', $medical_code)
            ->join('tb_medical', 'tb_medical.medical_code = tb_medical_gallery.medgal_medical')
            ->get()->getResultArray();
    }
}
