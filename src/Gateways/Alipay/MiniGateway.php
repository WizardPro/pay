<?php

namespace WizardPro\Pay\Gateways\Alipay;

use WizardPro\Pay\Events;
use WizardPro\Pay\Exceptions\GatewayException;
use WizardPro\Pay\Exceptions\InvalidArgumentException;
use WizardPro\Pay\Exceptions\InvalidConfigException;
use WizardPro\Pay\Exceptions\InvalidSignException;
use WizardPro\Pay\Gateways\Alipay;
use WizardPro\Supports\Collection;

class MiniGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author xiaozan <i@xiaozan.me>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws InvalidSignException
     *
     * @see https://docs.alipay.com/mini/introduce/pay
     *
     * @return Collection
     */
    public function pay($endpoint, array $payload): Collection
    {
        $biz_array = json_decode($payload['biz_content'], true);
        if (empty($biz_array['buyer_id'])) {
            throw new InvalidArgumentException('buyer_id required');
        }
        if ((Alipay::MODE_SERVICE === $this->mode) && (!empty(Support::getInstance()->pid))) {
            $biz_array['extend_params'] = is_array($biz_array['extend_params']) ? array_merge(['sys_service_provider_id' => Support::getInstance()->pid], $biz_array['extend_params']) : ['sys_service_provider_id' => Support::getInstance()->pid];
        }
        $payload['biz_content'] = json_encode($biz_array);
        $payload['method'] = 'alipay.trade.create';
        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\PayStarted('Alipay', 'Mini', $endpoint, $payload));

        return Support::requestApi($payload);
    }
}
