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

    $services->set('sylius_mollie.apple_pay.resolver.address', \Sylius\MolliePlugin\ApplePay\Resolver\AddressResolver::class)
        ->args([
            service('sylius_mollie.apple_pay.validator.apple_pay_address'),
            service('sylius.repository.customer'),
            service('sylius.custom_factory.address'),
            service('sylius.factory.customer'),
        ]);

    $services->alias(\Sylius\MolliePlugin\ApplePay\Resolver\AddressResolverInterface::class, 'sylius_mollie.apple_pay.resolver.address');

    $services->set('sylius_mollie.apple_pay.resolver.apple_pay_direct_api_order_payment', \Sylius\MolliePlugin\ApplePay\Resolver\ApplePayDirectApiOrderPaymentResolver::class)
        ->args([
            service('sylius_mollie.client.mollie_api'),
            service('sylius_mollie.resolver.mollie_api_client_key'),
            service('sylius_mollie.converter.order'),
            service('sylius_mollie.apple_pay.provider.order_payment_apple_pay_direct'),
            service('sylius_mollie.resolver.payment_locale'),
            service('sylius_mollie.provider.divisor'),
        ]);

    $services->alias(\Sylius\MolliePlugin\ApplePay\Resolver\ApplePayDirectApiOrderPaymentResolverInterface::class, 'sylius_mollie.apple_pay.resolver.apple_pay_direct_api_order_payment');

    $services->set('sylius_mollie.apple_pay.resolver.apple_pay_direct_api_payment', \Sylius\MolliePlugin\ApplePay\Resolver\ApplePayDirectApiPaymentResolver::class)
        ->args([
            service('sylius_mollie.client.mollie_api'),
            service('sylius_mollie.resolver.mollie_api_client_key'),
            service('sylius_mollie.apple_pay.provider.order_payment_apple_pay_direct'),
        ]);

    $services->alias(\Sylius\MolliePlugin\ApplePay\Resolver\ApplePayDirectApiPaymentResolverInterface::class, 'sylius_mollie.apple_pay.resolver.apple_pay_direct_api_payment');

    $services->set('sylius_mollie.apple_pay.resolver.apple_pay_direct_payment_type', \Sylius\MolliePlugin\ApplePay\Resolver\ApplePayDirectPaymentTypeResolver::class)
        ->args([
            service('sylius_mollie.apple_pay.resolver.apple_pay_direct_api_payment'),
            service('sylius_mollie.apple_pay.resolver.apple_pay_direct_api_order_payment'),
            service('sylius_mollie.converter.int_to_string'),
        ]);

    $services->alias(\Sylius\MolliePlugin\ApplePay\Resolver\ApplePayDirectPaymentTypeResolverInterface::class, 'sylius_mollie.apple_pay.resolver.apple_pay_direct_payment_type');
};
