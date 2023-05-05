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
        // \Midtrans\Config::$serverKey = 'SB-Mid-server-b-0mbmFYmSeynMwfpQVfusZh';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
    }

    public function token()
    {
        $medical_code                = $this->request->getVar('medical_code');
        $medical                     = $this->medical->find($medical_code);
        $medical_faskes              = $medical['medical_faskes']; 
        $faskes                      = $this->faskes->find($medical_faskes);
        $key_enc                     = $faskes['faskes_server_key'];
        $faskes_server_key           = $this->decrypt($key_enc);
        \Midtrans\Config::$serverKey = $faskes_server_key;

        
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
        } elseif($invoice_method == 'Gopay'){
            $enable_payments = array("gopay");
        } elseif($invoice_method == 'QR'){
            $enable_payments = array("gopay", "other_qris");
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

    private function getServerKeyByOrderId($order_id)
    {
        $invoice_id     = strtok($order_id, '-');
        $invoice        = $this->invoice->find($invoice_id);
        $medical_code   = $invoice['invoice_medical'];
        $medical        = $this->medical->find($medical_code);
        $medical_faskes = $medical['medical_faskes'];

        $faskes         = $this->faskes->find($medical_faskes);
        $key_enc        = $faskes['faskes_server_key'];
        $serverKey      = $this->decrypt($key_enc);

        return $serverKey;
    }

    public function hook()
    {
        $inputJSON = file_get_contents('php://input');
        $inputData = json_decode($inputJSON, true);
        if (isset($inputData['order_id'])) {
            $order_id   = $inputData['order_id'];
            $serverKey  = $this->getServerKeyByOrderId($order_id);
            // \Midtrans\Config::$serverKey = $serverKey;
        } else {
            // Handle the case where the order ID is not available in the incoming data
            // You can return an error message or throw an exception
            $serverKey = 'serverKey not found';
        }
        

        \Midtrans\Config::$serverKey = $serverKey;
        $result         = new \Midtrans\Notification();
        
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
                $invoice_id         = strtok($order_id, '-');
                $invoice            = $this->invoice->find($invoice_id);
                $medical_code       = $invoice['invoice_medical'];
                $medical            = $this->medical->find($medical_code);

                $updateMidtrans  = [
                    'status_code'       => $result->status_code,
                    'status_message'    => $result->status_message,
                    'gross_amount'      => strtok($result->gross_amount, '.'),
                    'transaction_status'=> $result->transaction_status,
                ];

                $updateInvoice  = [
                    'invoice_pay'      => strtok($result->gross_amount, '.'),
                    'invoice_status'   => 'SUCCEEDED',
                ];

                $updateMedical = [
                    'medical_status'   => 'Selesai'
                ];

                if($medical['medical_refer_type'] == 'Teledermatologi' && $medical['medical_refer_code'] != NULL){
                    $updateMedical = [
                        'medical_status'   => 'Proses'
                    ];
                }

                $this->db->transStart();
                $this->midtrans->update($order_id, $updateMidtrans);
                $this->medical->update($invoice['invoice_medical'], $updateMedical);
                $this->invoice->update($invoice_id, $updateInvoice);
                $this->db->transComplete();

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

                $this->db->transStart();
                $this->midtrans->update($order_id, $updateMidtrans);
                $this->invoice->update($invoice_id, $updateInvoice);
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
        var_dump($data);

        return $this->response->setJSON($data);

        //var_dump($serverKey);

        
    }
}
