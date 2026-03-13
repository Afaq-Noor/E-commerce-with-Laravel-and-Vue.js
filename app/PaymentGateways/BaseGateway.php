<?php

namespace App\PaymentGateways;

abstract class BaseGateway
{
    abstract public function pay($order);
}