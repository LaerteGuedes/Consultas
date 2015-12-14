<?php
namespace App\Services;


use App\Custom\Debug;
use Illuminate\Support\Facades\Redirect;

class PagSeguroService
{
    protected $email;
    protected $token;

    public function __construct()
    {
        $this->email = 'laerteguedes8@gmail.com';
        $this->token = 'CC83C3FC76004EBF89A0861E5002080B';
    }

    public function sendAssinaturaRequest($name, $phone, $email, $assinatura_titulo, $valor, $assinatura_id)
    {
        $ch = curl_init();
        $valor_total = $valor*12;

        $fields = ['email' => $this->email,
                    'token' => $this->token,
                    'senderName' => urlencode($name),
                    'senderPhone' => urlencode($phone),
                    'senderEmail' => urlencode($email),
                    'senderAddressStreet' => '',
                    'senderAddressNumber' => '',
                    'senderAddressDistrict' => '',
                    'preApprovalCharge' => urlencode('auto'),
                    'preApprovalName' => urlencode($assinatura_titulo),
                    'preApprovalDetails' => urlencode('Pacote de assinatura - Sallus'),
                    'preApprovalAmountPerPayment' => urlencode('100.00'),
                    'preApprovalPeriod' => urlencode('Monthly'),
                    'preApprovalFinalDate' => urlencode('2016-01-21T00:00:000-03:00'),
                    'preApprovalMaxTotalAmount' => urlencode('1200.00'),
                    'reference' => urlencode($name.'-'.$assinatura_id),
                    'redirectURL' => urlencode('http://www.sallus.net/dashboard'),
                    'reviewURL' => urlencode('http://www.sallus.net/dashboard')];

        $fields_string = '';
        foreach ($fields as $key => $field){
            $fields_string .= $key.'='.$field.'&';
        }
        rtrim($fields_string, '&');
        $url = 'https://ws.pagseguro.uol.com.br/v2/pre-approvals/request';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        $xml = curl_exec($ch);
        $response = simplexml_load_string($xml);


        if ($response->code){
            $urlFinal = 'https://pagseguro.uol.com.br/v2/pre-approvals/request.html?code='.$response->code;
            return $urlFinal;
        }
    }

}