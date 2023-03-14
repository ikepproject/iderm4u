<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;

class Transaction extends BaseController
{
	public function checkout($modul, $medical_code)
    {
        $user               = $this->userauth(); //Return array
        $invoice_count      = count($this->invoice->find_medical_ResultArray($medical_code));
        
        if ($invoice_count != 0) {
            $medical        = $this->medical->find($medical_code);
            $faskes_code    = $medical['medical_faskes'];
            $faskes         = $this->faskes->find($faskes_code);
            $faskes_name    = $faskes['faskes_name'];
            $user_patient_id= $medical['medical_user'];
            $user_patient   = $this->user->find($user_patient_id);
            $patient_code   = $user_patient['user_patient'];
            $patient        = $this->patient->find($patient_code);

            $medtreat       = $this->medtreat->find_medical($medical_code);
            $medprod        = $this->medprod->find_medical($medical_code);
            $medoth         = $this->medoth->find_medical($medical_code);
            $medgal         = $this->medgal->find_medical($medical_code);
            $invoice        = $this->invoice->find_medical($medical_code);

            if ($modul == 'checkout') {
                $title = 'Checkout';
            } else {
                $title = 'Invoice';
            }

            $data = [
                'title'         => $title,
                'modul'         => $modul,
                'user'          => $user,
                'faskes_name'   => $faskes_name,
                'user_patient'  => $user_patient,
                'patient'       => $patient,
                'medical'       => $medical,
                'medtreat'      => $medtreat,
                'medprod'       => $medprod,
                'medoth'        => $medoth,
                'medgal'        => $medgal,
                'invoice'       => $invoice
            ];
            return view('panel_faskes/medical/checkout', $data);
        } else {
            $data = [
                'title' => '404 Page not found',
                'message' => NULL,
                'code'  => '404',
            ];
            echo view('errors/404', $data);
        }
        
    }

    public function cash()
    {
        if ($this->request->isAJAX()) {
            $invoice_id     = $this->request->getVar('invoice_id');
            $invoice_amount = $this->request->getVar('invoice_amount');
            $medical_code   = $this->request->getVar('medical_code');    

            $updateInvoice = [
                'invoice_status' => 'SUCCEEDED',
                'invoice_pay'    => $invoice_amount
            ];
            $updateMedical = [
                'medical_status' => 'Selesai',
            ];
            $this->invoice->update($invoice_id, $updateInvoice);
            $this->medical->update($medical_code, $updateMedical);

            $response = [
                'success' => 'Data Berhasil Disimpan',
            ];

            echo json_encode($response);
        }
    }

    // public function formcash()
    // {
    //     if ($this->request->isAJAX()) {
    //         $medical_code = $this->request->getVar('medical_code');
    //         $invoice_code = $this->request->getVar('invoice_code');
    //         $invoice      = $this->invoice->find_medical($medical_code);

    //         $data = [
    //             'title'     => 'Masukan Pembayaran Uang Tunai',
    //             'invoice'   => $invoice,
    //         ];
    //         $response = [
    //             'data' => view('panel_faskes/medical/cash', $data)
    //         ];
    //         echo json_encode($response);
    //     }
    // }

}