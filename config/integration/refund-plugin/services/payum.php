<?php

/*
 * This file is part of the Sylius Mollie Plugin package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services();

    $services->defaults()
        ->public();

    $services->set('sylius_mollie.payum.action.refund.refund', \Sylius\MolliePlugin\Payum\Action\Refund\RefundAction::class)
        ->args([
            service('sylius_mollie.logger.mollie_logger_action'),
            service('sylius_mollie.refund.converter.refund_data'),
        ])
        ->tag('payum.action', ['factory' => 'mollie', 'alias' => 'payum.action.refund'])
        ->tag('payum.action', ['factory' => 'mollie_subscription', 'alias' => 'payum.action.refund_subscription']);

    $services->set('sylius_mollie.payum.action.refund.refund.refund_order', \Sylius\MolliePlugin\Payum\Action\Refund\RefundOrderAction::class)
        ->args([
            service('sylius_mollie.logger.mollie_logger_action'),
            service('sylius_mollie.refund.converter.refund_data'),
        ])
        ->tag('payum.action', ['factory' => 'mollie', 'alias' => 'payum.action.refund_order']);

    $services->set('sylius_mollie.payum.action.status', \Sylius\MolliePlugin\Payum\Action\StatusAction::class)
        ->args([
            service('sylius_mollie.refund.payment'),
            service('sylius_mollie.refund.order'),
            service('sylius_mollie.logger.mollie_logger_action'),
            service('sylius_mollie.voucher.updater.order_voucher_adjustment'),
            service('sylius_mollie.refund.checker.mollie_order_refund'),
        ])
        ->tag('payum.action', ['factory' => 'mollie', 'alias' => 'payum.action.status'])
        ->tag('payum.action', ['factory' => 'mollie_subscription', 'alias' => 'payum.action.status_subscription']);
};
