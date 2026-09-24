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

    $services->set('sylius_mollie.refund.payment', \Sylius\MolliePlugin\Refund\PaymentRefund::class)
        ->args([
            service('sylius_mollie.command_bus'),
            service('sylius_mollie.refund.creator.payment_refund_command'),
            service('sylius_mollie.logger.mollie_logger_action'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Refund\PaymentRefundInterface::class, 'sylius_mollie.refund.payment');

    $services->set('sylius_mollie.refund.units.shipment_unit', \Sylius\MolliePlugin\Refund\Units\ShipmentUnitRefund::class);

    $services->alias(\Sylius\MolliePlugin\Refund\Units\ShipmentUnitRefundInterface::class, 'sylius_mollie.refund.units.shipment_unit');

    $services->set('sylius_mollie.refund.units.payment_units_item', \Sylius\MolliePlugin\Refund\Units\PaymentUnitsItemRefund::class)
        ->args([
            service('sylius_mollie.refund.generator.payment'),
            service('sylius_mollie.refund_generator.payment_new_unit'),
            service('sylius_mollie.refund.calculator.payment'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Refund\Units\PaymentUnitsItemRefundInterface::class, 'sylius_mollie.refund.units.payment_units_item');

    $services->set('sylius_mollie.refund.order', \Sylius\MolliePlugin\Refund\OrderRefund::class)
        ->args([
            service('sylius.command_bus'),
            service('sylius_mollie.refund.creator.order_refund_command'),
            service('sylius_mollie.logger.mollie_logger_action'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Refund\OrderRefundInterface::class, 'sylius_mollie.refund.order');

    $services->set('sylius_mollie.refund.units.units_item_order', \Sylius\MolliePlugin\Refund\Units\UnitsItemOrderRefund::class)
        ->args([service('sylius_refund.repository.refund')]);

    $services->alias(\Sylius\MolliePlugin\Refund\Units\UnitsItemOrderRefundInterface::class, 'sylius_mollie.refund.units.units_item_order');

    $services->set('sylius_mollie.refund.units.units_shipment_order', \Sylius\MolliePlugin\Refund\Units\UnitsShipmentOrderRefund::class)
        ->args([service('sylius_refund.repository.refund')]);

    $services->alias(\Sylius\MolliePlugin\Refund\Units\UnitsShipmentOrderRefundInterface::class, 'sylius_mollie.refund.units.units_shipment_order');

    $services->set('sylius_mollie.refund_generator.payment_new_unit', \Sylius\MolliePlugin\Refund\Generator\PaymentNewUnitRefundGenerator::class);

    $services->alias(\Sylius\MolliePlugin\Refund\Generator\PaymentNewUnitRefundGeneratorInterface::class, 'sylius_mollie.refund_generator.payment_new_unit');

    $services->set('sylius_mollie.refund.generator.payment', \Sylius\MolliePlugin\Refund\Generator\PaymentRefundedGenerator::class)
        ->args([service('sylius_refund.repository.refund')]);

    $services->alias(\Sylius\MolliePlugin\Refund\Generator\PaymentRefundedGeneratorInterface::class, 'sylius_mollie.refund.generator.payment');

    $services->set('sylius_mollie.refund.calculator.payment', \Sylius\MolliePlugin\Refund\Calculator\PaymentRefundCalculator::class);

    $services->alias(\Sylius\MolliePlugin\Refund\Calculator\PaymentRefundCalculatorInterface::class, 'sylius_mollie.refund.calculator.payment');
};
