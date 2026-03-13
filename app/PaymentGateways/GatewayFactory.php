<?php

namespace App\PaymentGateways;

class GatewayFactory
{

    public static function make($method)
    {

        if($method == 'online'){
            return new InternalGateway();
        }

        return null;

    }

}