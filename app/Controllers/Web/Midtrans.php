<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use Midtrans\Notification;
use App\Libraries\Veritrans;

class Midtrans extends BaseController
{
    protected $db, $builder;

    public function __construct()
    {
        \Midtrans\Config::$serverKey = 'SB-Mid-server-b-0mbmFYmSeynMwfpQVfusZh';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    }

    public function token()
    {
        $medical_code   = $this->request->getVar('medical_code');
        $invoice_id     = $this->request->getVar('invoice_id');
        $invoice_code   = $this->request->getVar('invoice_code');
        $invoice_method = $this->request->getVar('invoice_method');
        $patient_name   = $this->request->getVar('patient_name');
        $email          = $this->request->getVar('email');
        $phone          = $this->request->getVar('phone');
        $address        = $this->request->getVar('address');
        $amount         = $this->request->getVar('amount');

        $order_id       = $invoice_id . '-' . substr($invoice_code,4) . '-' . time();

        $transaction_details = [
            'order_id'      => $order_id,
            'gross_amount'  => $amount, // no decimal allowed for creditcard
        ];

        // Optional
        $item1_details = [
            'id'        => $medical_code,
            'price'     => $amount,
            'quantity'  => 1,
            'name'      => $medical_code
        ];

        // Optional
        // $item2_details = array(
        //     'id' => 'a2',
        //     'price' => 50000,
        //     'quantity' => 1,
        //     'name' => "Orange"
        // );

        // Optional
        $item_details = [$item1_details];

        // Optional
        $billing_address = [
            'first_name'    => $patient_name,
            'address'       => $address,
            'phone'         => $phone,
            'country_code'  => 'IDN'
        ];

        // Optional
        $customer_details = [
            'first_name'        => $patient_name,
            'email'             => $email,
            'phone'             => $phone,
            'billing_address'   => $billing_address,
        ];

        // Optional, remove this to display all available payment methods
        // $enable_payments = array('credit_card', 'cimb_clicks', 'mandiri_clickpay', 'echannel');

        if ($invoice_method == 'VA') {
            $enable_payments = array("echannel", "permata_va","bca_va", "bni_va", "bri_va", "other_va");
        } else{
            $enable_payments = array("gopay");
        }

        // Fill transaction details
        $transaction = [
            'enabled_payments'    => $enable_payments,
            'transaction_details' => $transaction_details,
            'customer_details'    => $customer_details,
            'item_details'        => $item_details,
        ];

        error_log(json_encode($transaction));
        $snapToken = \Midtrans\Snap::getSnapToken($transaction);
        error_log($snapToken);
        echo $snapToken;

        // Update Invoice
        $updateInvoice = [
            'invoice_snap_token'    => $snapToken
        ];

        $this->invoice->update($invoice_id, $updateInvoice);

    }

    public function finish()
    {
        $result         = json_decode($this->request->getVar('result_data'), true);
        
        $invoice_id     = strtok($result['order_id'], '-');
        $invoice        = $this->invoice->find($invoice_id);

        if ($result['payment_type'] == 'echannel') {
            $saveMidtrans = [
                'order_id'          => $result['order_id'],
                'transaction_id'    => $result['transaction_id'],
                'status_code'       => $result['status_code'],
                'status_message'    => $result['status_message'],
                'gross_amount'      => strtok($result['gross_amount'], '.'),
                'payment_type'      => $result['payment_type'],
                'transaction_time'  => $result['transaction_time'],
                'transaction_status'=> $result['transaction_status'],
                'fraud_status'      => $result['fraud_status'],
                'bank'              => 'mandiri',
                'va_number'         => $result['bill_key'],
                'code'              => $result['biller_code'],    
            ];
        } elseif (isset($result['permata_va_number'])) {
            $saveMidtrans = [
                'order_id'          => $result['order_id'],
                'transaction_id'    => $result['transaction_id'],
                'status_code'       => $result['status_code'],
                'status_message'    => $result['status_message'],
                'gross_amount'      => strtok($result['gross_amount'], '.'),
                'payment_type'      => $result['payment_type'],
                'transaction_time'  => $result['transaction_time'],
                'transaction_status'=> $result['transaction_status'],
                'fraud_status'      => $result['fraud_status'],
                'bank'              => 'permata',
                'va_number'         => $result['permata_va_number'],
                
            ];
        } elseif ($result['payment_type'] == 'gopay' || $result['payment_type'] == 'qris') {
            $saveMidtrans = [
                'order_id'          => $result['order_id'],
                'transaction_id'    => $result['transaction_id'],
                'status_code'       => $result['status_code'],
                'status_message'    => $result['status_message'],
                'gross_amount'      => strtok($result['gross_amount'], '.'),
                'payment_type'      => $result['payment_type'],
                'transaction_time'  => $result['transaction_time'],
                'transaction_status'=> $result['transaction_status'],
                'fraud_status'      => $result['fraud_status'],
            ];
        } else {
            $saveMidtrans = [
                'order_id'          => $result['order_id'],
                'transaction_id'    => $result['transaction_id'],
                'status_code'       => $result['status_code'],
                'status_message'    => $result['status_message'],
                'gross_amount'      => strtok($result['gross_amount'], '.'),
                'payment_type'      => $result['payment_type'],
                'transaction_time'  => $result['transaction_time'],
                'transaction_status'=> $result['transaction_status'],
                'fraud_status'      => $result['fraud_status'],
                'bank'              => $result['va_numbers'][0]['bank'],
                'va_number'         => $result['va_numbers'][0]['va_number'],
                
            ];
        }

        // $this->db->transStart();
        if ($result['transaction_status'] == 'pending') {
            $this->midtrans->insert($saveMidtrans);
            $updateInvoice  = [
                'invoice_midtrans' => $result['order_id'],
            ];
            $this->invoice->update($invoice_id, $updateInvoice);
        } elseif ($result['transaction_status'] == 'settlement') {
            $check_order_id = $this->midtrans->count_order_id($result['order_id']);

            if ($check_order_id['order_id'] == 0) {
                $this->midtrans->insert($saveMidtrans);
                $updateInvoice  = [
                    'invoice_pay'      => strtok($result['gross_amount'], '.'),
                    'invoice_status'   => 'SUCCEEDED',
                    'invoice_midtrans' => $result['order_id'],
                ];
                $this->invoice->update($invoice_id, $updateInvoice);
                $updateMedical = [
                    'medical_status'   => 'Selesai'
                ];
                $this->medical->update($invoice['invoice_medical'], $updateMedical);
                
            } else {
                $this->midtrans->update($result['order_id'], $saveMidtrans);
                $updateInvoice  = [
                    'invoice_pay'      => strtok($result['gross_amount'], '.'),
                    'invoice_status'   => 'SUCCEEDED',
                    'invoice_midtrans' => $result['order_id'],
                ];
                $this->invoice->update($invoice_id, $updateInvoice);
                $updateMedical = [
                    'medical_status'   => 'Selesai'
                ];
                $this->medical->update($invoice['invoice_medical'], $updateMedical);
            }
            
        }
        // $this->db->transComplete();

        $url_redirect = '/transaction/checkout' . '/' . $invoice['invoice_medical'];
        $this->session->setFlashData('pesan', '');
        return redirect()->to($url_redirect);

        // var_dump($saveMidtrans);

        
    }

    public function hook()
    {
        $result         =new \Midtrans\Notification();

        $serverKey      = 'SB-Mid-server-b-0mbmFYmSeynMwfpQVfusZh';

        $order_id       = $result->order_id;
        $status_code    = $result->status_code;
        $gross_amount   = $result->gross_amount;
        $signature_key  = $result->signature_key;

        $signature      = hash('sha512', $order_id.$status_code.$gross_amount.$serverKey);

        if ($signature_key != $signature) {
            $data = [
                "message" => 'Invalid Signature',
            ];
        } else {
            $transaction_status = $result->transaction_status;

            if ($transaction_status == 'settlement') {
                $invoice_id     = strtok($order_id, '-');
                $invoice        = $this->invoice->find($invoice_id);

                $updateMidtrans  = [
                    'status_code'       => $result->status_code,
                    'status_message'    => $result->status_message,
                    // 'gross_amount'      => strtok($result->gross_amount, '.'),
                    'transaction_status'=> $result->transaction_status,
                ];

                $updateInvoice  = [
                    // 'invoice_pay'      => strtok($result->gross_amount, '.'),
                    'invoice_status'   => 'SUCCEEDED',
                ];
                
                $updateMedical = [
                    'medical_status'   => 'Selesai'
                ];

                // $this->db->transStart();
                $this->midtrans->update($order_id, $updateMidtrans);
                $this->medical->update($invoice['invoice_medical'], $updateMedical);
                $this->invoice->update($invoice_id, $updateInvoice);
                // $this->db->transComplete();

                $data = [
                    "message" => 'Transaction Paid',
                ];

            } elseif ($transaction_status == 'expire') {
                $invoice_id     = strtok($order_id, '-');
                $invoice        = $this->invoice->find($invoice_id);

                $updateMidtrans  = [
                    'status_code'       => $result->status_code,
                    'status_message'    => $result->status_message,
                    'transaction_status'=> $result->transaction_status,
                ];

                $updateInvoice  = [
                    'invoice_midtrans'   => NULL,
                ];

                // $this->db->transStart();
                $this->midtrans->update($order_id, $updateMidtrans);
                $this->invoice->update($invoice_id, $updateInvoice);
                // $this->db->transComplete();

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

        // var_dump($saveMidtrans);

        
    }

    public function hook2()
    {
        $this->veritrans = new Veritrans;
        echo 'test notification handler';
		$json_result    = file_get_contents('php://input');
		$result         = json_decode($json_result);

		if($result){
		$notif = $this->veritrans->status($result->order_id);
		}

		error_log(print_r($result,TRUE));

		//notification handler sample

		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;

		if ($transaction == 'settlement'){
		  // TODO set payment status in merchant's database to 'Settlement'
            $Midtrans  = [
                'order_id'       => 'Tes-'. time() ,
            ];
            $this->midtrans->insert($Midtrans);
            $data = [
                "message" => "Transaction order_id: " . $order_id ." successfully transfered using " . $type,
            ];
            error_log(json_encode($data));
		  } 
		  else if($transaction == 'pending'){
		  // TODO set payment status in merchant's database to 'Pending'
		  echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
            $data = [
                "message" => "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type,
            ];
            error_log(json_encode($data));
		  } 
		  else if ($transaction == 'deny') {
		  // TODO set payment status in merchant's database to 'Denied'
		  echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
            $data = [
                "message" => "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.",
            ];
            error_log(json_encode($data));
		}
    }
}
