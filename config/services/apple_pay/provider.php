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

    $services->set('sylius_mollie.apple_pay.provider.apple_pay_direct', \Sylius\MolliePlugin\ApplePay\Provider\ApplePayDirectProvider::class)
        ->args([
            service('sylius_mollie.apple_pay.resolver.address'),
            service('sylius_mollie.apple_pay.provider.order_payment_apple_pay_direct'),
            service('sylius_mollie.provider.customer'),
            service('sylius_mollie.apple_pay.provider.apple_pay_direct_payment'),
        ]);

    $services->alias(\Sylius\MolliePlugin\ApplePay\Provider\ApplePayDirectProviderInterface::class, 'sylius_mollie.apple_pay.provider.apple_pay_direct');

    $services->set('sylius_mollie.apple_pay.provider.order_payment_apple_pay_direct', \Sylius\MolliePlugin\ApplePay\Provider\OrderPaymentApplePayDirectProvider::class)
        ->args([
            service('sylius.custom_factory.payment'),
            service('sylius_abstraction.state_machine'),
            service('sylius.repository.payment_method'),
            service('sylius.repository.gateway_config'),
            service('sylius_mollie.payum.provider.payment_token'),
            service('payum'),
        ]);

    $services->alias(\Sylius\MolliePlugin\ApplePay\Provider\OrderPaymentApplePayDirectProviderInterface::class, 'sylius_mollie.apple_pay.provider.order_payment_apple_pay_direct');

    $services->set('sylius_mollie.apple_pay.provider.apple_pay_direct_payment', \Sylius\MolliePlugin\ApplePay\Provider\ApplePayDirectPaymentProvider::class)
        ->args([service('sylius_mollie.apple_pay.resolver.apple_pay_direct_payment_type')]);

    $services->alias(\Sylius\MolliePlugin\ApplePay\Provider\ApplePayDirectPaymentProviderInterface::class, 'sylius_mollie.apple_pay.provider.apple_pay_direct_payment');
};
