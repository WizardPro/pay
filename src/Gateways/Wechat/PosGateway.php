<?php

namespace WizardPro\Pay\Gateways\Wechat;

use WizardPro\Pay\Events;
use WizardPro\Pay\Exceptions\GatewayException;
use WizardPro\Pay\Exceptions\InvalidArgumentException;
use WizardPro\Pay\Exceptions\InvalidSignException;
use WizardPro\Supports\Collection;

class PosGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     *
     * @return Collection
     */
    public function pay($endpoint, array $payload): Collection
    {
        unset($payload['trade_type'], $payload['notify_url']);

        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\PayStarted('Wechat', 'Pos', $endpoint, $payload));

        return Support::requestApi('pay/micropay', $payload);
    }

    /**
     * Get trade type config.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     */
    protected function getTradeType(): string
    {
        return 'MICROPAY';
    }
}
