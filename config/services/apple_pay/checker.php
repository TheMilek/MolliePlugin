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

    $services->set('sylius_mollie.apple_pay.checker.apple_pay_enabled', \Sylius\MolliePlugin\ApplePay\Checker\ApplePayEnabledChecker::class)
        ->public()
        ->args([
            service('sylius_mollie.repository.mollie_gateway_config'),
            service('sylius.payment_methods_resolver.default')->nullOnInvalid(),
        ]);

    $services->alias(\Sylius\MolliePlugin\ApplePay\Checker\ApplePayEnabledCheckerInterface::class, 'sylius_mollie.apple_pay.checker.apple_pay_enabled');
};
