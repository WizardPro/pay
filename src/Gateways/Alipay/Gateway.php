<?php

namespace WizardPro\Pay\Gateways\Alipay;

use WizardPro\Pay\Contracts\GatewayInterface;
use WizardPro\Pay\Exceptions\InvalidArgumentException;
use WizardPro\Supports\Collection;

abstract class Gateway implements GatewayInterface
{
    /**
     * Mode.
     *
     * @var string
     */
    protected $mode;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @throws InvalidArgumentException
     */
    public function __construct()
    {
        $this->mode = Support::getInstance()->mode;
    }

    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @return Collection
     */
    abstract public function pay($endpoint, array $payload);
}
