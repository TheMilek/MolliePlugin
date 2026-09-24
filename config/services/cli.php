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

    $services->set('sylius_mollie.console.command.send_abandoned_payment_link', \Sylius\MolliePlugin\Console\Command\SendAbandonedPaymentLink::class)
        ->args([service('sylius_mollie.creator.abandoned_payment_link')])
        ->tag('console.command');

    $services->set('sylius_mollie.console.command.subscription.begin_processing', \Sylius\MolliePlugin\Console\Command\BeginProcessingSubscriptions::class)
        ->args([
            service('sylius_mollie.repository.mollie_subscription'),
            service('sylius_abstraction.state_machine'),
        ])
        ->tag('console.command');

    $services->set('sylius_mollie.console.command.subscription.process', \Sylius\MolliePlugin\Console\Command\ProcessSubscriptions::class)
        ->args([
            service('sylius_mollie.repository.mollie_subscription'),
            service('sylius_abstraction.state_machine'),
            service('sylius_mollie.subscription.processor.subscription'),
            service('router'),
        ])
        ->tag('console.command');
};
