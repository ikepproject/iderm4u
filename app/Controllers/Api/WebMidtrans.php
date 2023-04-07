<?php

namespace App\Controllers\Api;
use App\Libraries\JWTCI4;
use CodeIgniter\HTTP\IncomingRequest;

use App\Models\Model_User;
use App\Models\Model_Invoice;
use App\Models\Model_Midtrans;
use App\Models\Model_Medical;

use CodeIgniter\RESTful\ResourceController;

class WebMidtrans extends ResourceController
{
    protected $helpers = ['form', 'url', 'cookie'];

    public function userauth(){
		$token   = get_cookie('gem');
		$jwt     = new JWTCI4;
		$user	 = $jwt->decodeweb($token);
		$user_id = $user->uid;
        $tb_user = new Model_User;
		$userdata= $tb_user->find($user_id);
		return $userdata;
	}

    public function __construct()
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-b-0mbmFYmSeynMwfpQVfusZh';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
    }

    public function hook()
    {
        $tb_invoice     = new Model_Invoice;
        $tb_midtrans    = new Model_Midtrans;
        $tb_medical     = new Model_Medical;
        $this->db 	    = \Config\Database::connect();

        $notif          = new \Midtrans\Notification();

        $serverKey      = 'SB-Mid-server-b-0mbmFYmSeynMwfpQVfusZh';

        $order_id       = $notif->order_id;
        $status_code    = $notif->status_code;
        $gross_amount   = $notif->gross_amount;
        $signature_key  = $notif->signature_key;

        $signature      = hash('sha512', $order_id.$status_code.$gross_amount.$serverKey);
        if ($signature_key != $signature) {
            $data = [
                "message" => 'Invalid Signature',
            ];
        } else {
            $transaction_status = $notif->transaction_status;

            if ($transaction_status == 'settlement') {
                $invoice_id     = strtok($order_id, '-');
                $invoice        = $tb_invoice->find($invoice_id);

                $updateMidtrans  = [
                    'status_code'       => $notif->status_code,
                    'status_message'    => $notif->status_message,
                    'gross_amount'      => strtok($notif->gross_amount, '.'),
                    'transaction_status'=> $notif->transaction_status,
                ];

                $updateInvoice  = [
                    'invoice_pay'      => strtok($notif->gross_amount, '.'),
                    'invoice_status'   => 'SUCCEEDED',
                ];
                
                $updateMedical = [
                    'medical_status'   => 'Selesai'
                ];

                $this->db->transStart();
                $tb_midtrans->update($order_id, $updateMidtrans);
                $tb_medical->update($invoice['invoice_medical'], $updateMedical);
                $tb_invoice->update($invoice_id, $updateInvoice);
                $this->db->transComplete();

                $data = [
                    "message" => 'Transaction Paid',
                ];

            } elseif ($transaction_status == 'expire') {
                $invoice_id     = strtok($order_id, '-');
                $invoice        = $tb_invoice->find($invoice_id);

                $updateMidtrans  = [
                    'status_code'       => $notif->status_code,
                    'status_message'    => $notif->status_message,
                    'transaction_status'=> $notif->transaction_status,
                ];

                $updateInvoice  = [
                    'invoice_midtrans'   => NULL,
                ];

                $this->db->transStart();
                $tb_midtrans->update($order_id, $updateMidtrans);
                $tb_invoice->update($invoice_id, $updateInvoice);
                $this->db->transComplete();

                $data = [
                    "message" => 'Transaction Expired',
                ];

            } else {
                $data = [
                    "message" => 'Transaction Status Unpaid',
                ];
            }
        }

        error_log(json_encode($data));

        return $this->response->setJSON($data);

    }
    
}
