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
        $this->email = 'yeti@yetilab.net';
        $this->token = '823E96C4040E4C2FA5A35BA5566D9AE3';
    }

    public function getSessionId()
    {
        $fields = ['email' => $this->email,
            'token' => $this->token];

        $fields_string = '';
        foreach ($fields as $key => $field){
            $fields_string .= $key.'='.$field.'&';
        }
        rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        $xml = curl_exec($ch);
        $response = simplexml_load_string($xml);
        $resp = (array) $response;

        return $resp['id'];
    }

    public function sendAssinaturaRequest($name, $phone, $email, $assinatura_titulo, $valor, $tipo, $user_id)
    {
        switch($tipo){
            case 'MENSAL':
                $period = urlencode("Monthly");
                $valor_total = number_format($valor*12, 2);
                break;
            case 'BIMESTRAL':
                $period = urlencode("Bimonthly");
                $valor_total = number_format($valor*6, 2);
                break;
            case 'TRIMESTRAL':
                $period = urlencode("Trimonthly");
                $valor_total = number_format($valor*4, 2);
                break;
            case 'SEMESTRAL':
                $period = urlencode("Semiannually");
                $valor_total = number_format($valor*2, 2);
                break;
            case 'ANUAL':
                $period = urlencode("Yearly");
                $valor_total = number_format($valor, 2);
                break;
        }

        $valor_total = str_replace(',', '', $valor_total);
        $ch = curl_init();

        $date = date('Y-m-d', strtotime('+2 years'));

        $fields = ['email' => $this->email,
            'token' => $this->token,
            'senderName' => urlencode($name),
            'senderPhone' => urlencode($phone),
            'senderEmail' => urlencode('c47173029311466724960@sandbox.pagseguro.com.br'),
            'senderAddressStreet' => '',
            'senderAddressNumber' => '',
            'senderAddressDistrict' => '',
            'preApprovalCharge' => urlencode('auto'),
            'preApprovalName' => urlencode($assinatura_titulo),
            'preApprovalDetails' => urlencode('Pacote de assinatura - Sallus'),
            'preApprovalAmountPerPayment' => urlencode(number_format($valor, 2)),
            'preApprovalPeriod' => $period,
            'preApprovalFinalDate' => urlencode($date),
            'preApprovalMaxTotalAmount' => urlencode($valor_total),
            'reference' => urlencode($user_id),
            'redirectURL' => urlencode('http://www.sallus.net/dashboard'),
            'reviewURL' => urlencode('http://www.sallus.net/dashboard')];


        $fields_string = '';
        foreach ($fields as $key => $field){
            $fields_string .= $key.'='.$field.'&';
        }
        rtrim($fields_string, '&');
        $url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/request';
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        $xml = curl_exec($ch);
        $response = simplexml_load_string($xml);

        if ($response->code){
            $urlFinal = 'https://sandbox.pagseguro.uol.com.br/v2/pre-approvals/request.html?code='.$response->code;
            return $urlFinal;
        }
    }

    public function consultaStatusByNotificacaoAssinatura($notificationCode)
    {
        $url = "https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/notifications/".$notificationCode.'?';
        $url = $url.'email='.urlencode($this->email).'&token='.urlencode($this->token);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $xml = curl_exec($ch);
        $response = simplexml_load_string($xml);

        return $response;
    }

}