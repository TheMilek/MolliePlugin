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

    $services->set('sylius_mollie.custom_factory.mollie_gateway_config', \Sylius\MolliePlugin\Factory\MollieGatewayConfigFactory::class)
        ->decorate('sylius_mollie.factory.mollie_gateway_config')
        ->args([
            service('.inner'),
            service('sylius_mollie.repository.mollie_gateway_config'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Factory\MollieGatewayConfigFactoryInterface::class, 'sylius_mollie.custom_factory.mollie_gateway_config');

    $services->set('sylius_mollie.custom_factory.mollie_logger', \Sylius\MolliePlugin\Factory\MollieLoggerFactory::class)
        ->decorate('sylius_mollie.factory.mollie_logger')
        ->args([service('.inner')]);

    $services->alias(\Sylius\MolliePlugin\Factory\MollieLoggerFactoryInterface::class, 'sylius_mollie.custom_factory.mollie_logger');

    $services->set('sylius_mollie.custom_factory.mollie_subscription', \Sylius\MolliePlugin\Factory\MollieSubscriptionFactory::class)
        ->decorate('sylius_mollie.factory.mollie_subscription')
        ->args([
            service('.inner'),
            service('router'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Factory\MollieSubscriptionFactoryInterface::class, 'sylius_mollie.custom_factory.mollie_subscription');

    $services->set('sylius_mollie.custom_factory.mollie_subscription_schedule', \Sylius\MolliePlugin\Factory\MollieSubscriptionScheduleFactory::class)
        ->decorate('sylius_mollie.factory.mollie_subscription_schedule')
        ->args([service('.inner')]);

    $services->alias(\Sylius\MolliePlugin\Factory\MollieSubscriptionScheduleFactoryInterface::class, 'sylius_mollie.custom_factory.mollie_subscription_schedule');

    $services->set('sylius_mollie.factory.methods', \Sylius\MolliePlugin\Factory\MethodsFactory::class);

    $services->alias(\Sylius\MolliePlugin\Factory\MethodsFactoryInterface::class, 'sylius_mollie.factory.methods');

    $services->set('sylius_mollie.factory.date_period', \Sylius\MolliePlugin\Factory\DatePeriodFactory::class);

    $services->alias(\Sylius\MolliePlugin\Factory\DatePeriodFactoryInterface::class, 'sylius_mollie.factory.date_period');

    $services->set('sylius_mollie.factory.payment_details', \Sylius\MolliePlugin\Factory\PaymentDetailsFactory::class);

    $services->alias(\Sylius\MolliePlugin\Factory\PaymentDetailsFactoryInterface::class, 'sylius_mollie.factory.payment_details');
};
