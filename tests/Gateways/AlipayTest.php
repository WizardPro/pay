<?php

namespace WizardPro\Pay\Tests\Gateways;

use Symfony\Component\HttpFoundation\Response;
use WizardPro\Pay\Pay;
use WizardPro\Pay\Tests\TestCase;

class AlipayTest extends TestCase
{
    public function testSuccess()
    {
        $success = Pay::alipay([])->success();

        $this->assertInstanceOf(Response::class, $success);
        $this->assertEquals('success', $success->getContent());
    }
}
