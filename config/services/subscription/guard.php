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

    $services->set('sylius_mollie.subscription.guard.subscription', \Sylius\MolliePlugin\Subscription\Guard\SubscriptionGuard::class)
        ->public();

    $services->alias(\Sylius\MolliePlugin\Subscription\Guard\SubscriptionGuardInterface::class, 'sylius_mollie.subscription.guard.subscription');
};
