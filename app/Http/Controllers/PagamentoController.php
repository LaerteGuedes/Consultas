<?php

namespace App\Http\Controllers;

use App\Custom\Debug;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;


class PagamentoController extends Controller
{

    public function assinatura()
    {
        $paymentRequest = new \PagSeguroPaymentRequest();
        $paymentRequest->addItem('0001', 'Notebook', 1, 2430.00);
        $sedexCode = \PagSeguroShippingType::getCodeByType('SEDEX');
        $paymentRequest->setShippingType($sedexCode);
        $paymentRequest->setShippingAddress(
            '01452002',
            'Av. Brig. Faria Lima',
            '1384',
            'apto. 114',
            'Jardim Paulistano',
            'São Paulo',
            'SP',
            'BRA'
        );
        $paymentRequest->setSender(
            'João Comprador',
            'email@comprador.com.br',
            '11',
            '56273440',
            'CPF',
            '156.009.442-76'
        );
        $paymentRequest->setCurrency("BRL");
        $paymentRequest->setReference("REF123");
        $paymentRequest->addPaymentMethodConfig('CREDIT_CARD', 1.00, 'DISCOUNT_PERCENT');

        try {

            $credentials = \PagSeguroConfig::getAccountCredentials(); // getApplicationCredentials()
            $checkoutUrl = $paymentRequest->register($credentials);

        } catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }
    }


}
