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

    $services->set('sylius_mollie.cloner.order_item', \Sylius\MolliePlugin\Cloner\OrderItemCloner::class)
        ->args([
            service('sylius.factory.order_item'),
            service('sylius.factory.order_item_unit'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Cloner\OrderItemClonerInterface::class, 'sylius_mollie.cloner.order_item');

    $services->set('sylius_mollie.cloner.adjustment', \Sylius\MolliePlugin\Cloner\AdjustmentCloner::class)
        ->args([service('sylius.factory.adjustment')]);

    $services->alias(\Sylius\MolliePlugin\Cloner\AdjustmentClonerInterface::class, 'sylius_mollie.cloner.adjustment');

    $services->set('sylius_mollie.cloner.shipment', \Sylius\MolliePlugin\Cloner\ShipmentCloner::class)
        ->args([service('sylius.factory.shipment')]);

    $services->alias(\Sylius\MolliePlugin\Cloner\ShipmentClonerInterface::class, 'sylius_mollie.cloner.shipment');

    $services->set('sylius_mollie.cloner.subscription_order', \Sylius\MolliePlugin\Cloner\SubscriptionOrderCloner::class)
        ->args([
            service('sylius_mollie.cloner.order_item'),
            service('sylius.factory.order'),
            service('sylius.random_generator'),
            service('sylius_mollie.cloner.adjustment'),
            service('sylius_mollie.cloner.shipment'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Cloner\SubscriptionOrderClonerInterface::class, 'sylius_mollie.cloner.subscription_order');
};
