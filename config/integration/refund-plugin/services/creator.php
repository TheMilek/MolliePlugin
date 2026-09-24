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

    $services->set('sylius_mollie.refund.creator.payment_refund_command', \Sylius\MolliePlugin\Refund\Creator\PaymentRefundCommandCreator::class)
        ->args([
            service('sylius.repository.order'),
            service('sylius_refund.repository.refund'),
            service('sylius_mollie.refund.units.payment_units_item'),
            service('sylius_mollie.refund.units.shipment_unit'),
            service(\Sylius\RefundPlugin\Provider\RefundPaymentMethodsProviderInterface::class),
            service('sylius_mollie.provider.divisor'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Refund\Creator\PaymentRefundCommandCreatorInterface::class, 'sylius_mollie.refund.creator.payment_refund_command');

    $services->set('sylius_mollie.refund.creator.order_refund_command', \Sylius\MolliePlugin\Refund\Creator\OrderRefundCommandCreator::class)
        ->args([
            service('sylius.repository.order'),
            service('sylius_mollie.refund.units.units_item_order'),
            service('sylius_mollie.refund.units.units_shipment_order'),
            service(\Sylius\RefundPlugin\Provider\RefundPaymentMethodsProviderInterface::class),
        ]);

    $services->alias(\Sylius\MolliePlugin\Refund\Creator\OrderRefundCommandCreatorInterface::class, 'sylius_mollie.refund.creator.order_refund_command');
};
