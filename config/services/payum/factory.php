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

    $services->set('sylius_mollie.payum.gateway_factory.mollie_gateway', \Sylius\MolliePlugin\Payum\Factory\MollieGatewayFactory::class);

    $services->set('sylius_mollie.payum.gateway_factory.mollie_subscription_gateway', \Sylius\MolliePlugin\Payum\Factory\MollieSubscriptionGatewayFactory::class);

    $services->set('sylius_mollie.payum.gateway_factory.builder.mollie', \Payum\Core\Bridge\Symfony\Builder\GatewayFactoryBuilder::class)
        ->args([service('sylius_mollie.payum.gateway_factory.mollie_gateway')])
        ->tag('payum.gateway_factory_builder', ['factory' => 'mollie']);

    $services->set('sylius_mollie.payum.gateway_factory.builder.mollie_subscription', \Payum\Core\Bridge\Symfony\Builder\GatewayFactoryBuilder::class)
        ->args([service('sylius_mollie.payum.gateway_factory.mollie_subscription_gateway')])
        ->tag('payum.gateway_factory_builder', ['factory' => 'mollie_subscription']);

    $services->set('sylius_mollie.payum.factory.create_customer', \Sylius\MolliePlugin\Payum\Factory\CreateCustomerFactory::class);

    $services->alias(\Sylius\MolliePlugin\Payum\Factory\CreateCustomerFactoryInterface::class, 'sylius_mollie.payum.factory.create_customer');

    $services->set('sylius_mollie.payum.checker.mollie_gateway_factory', \Sylius\MolliePlugin\Payum\Checker\MollieGatewayFactoryChecker::class)
        ->public();

    $services->alias(\Sylius\MolliePlugin\Payum\Checker\MollieGatewayFactoryCheckerInterface::class, 'sylius_mollie.payum.checker.mollie_gateway_factory');

    $services->set('sylius_mollie.payum.resolver.existing_mollie_session', \Sylius\MolliePlugin\Payum\Resolver\ExistingMollieSessionResolver::class);

    $services->alias(\Sylius\MolliePlugin\Payum\Resolver\ExistingMollieSessionResolverInterface::class, 'sylius_mollie.payum.resolver.existing_mollie_session');
};
