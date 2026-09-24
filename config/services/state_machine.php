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

    $services->set('sylius_mollie.state_machine.applicator.subscription_and_payment_id', \Sylius\MolliePlugin\StateMachine\Applicator\SubscriptionAndPaymentIdApplicator::class)
        ->args([
            service('sylius_mollie.client.mollie_api'),
            service('sylius_abstraction.state_machine'),
        ]);

    $services->alias(\Sylius\MolliePlugin\StateMachine\Applicator\SubscriptionAndPaymentIdApplicatorInterface::class, 'sylius_mollie.state_machine.applicator.subscription_and_payment_id');

    $services->set('sylius_mollie.state_machine.applicator.subscription_and_sylius_payment', \Sylius\MolliePlugin\StateMachine\Applicator\SubscriptionAndSyliusPaymentApplicator::class)
        ->args([service('sylius_abstraction.state_machine')]);

    $services->alias(\Sylius\MolliePlugin\StateMachine\Applicator\SubscriptionAndSyliusPaymentApplicatorInterface::class, 'sylius_mollie.state_machine.applicator.subscription_and_sylius_payment');

    $services->set('sylius_mollie.state_machine.order_set_status', \Sylius\MolliePlugin\StateMachine\Applicator\MollieOrderStatesApplicator::class)
        ->args([
            service('sylius_abstraction.state_machine'),
            service('sylius.repository.order'),
        ]);

    $services->alias(\Sylius\MolliePlugin\StateMachine\Applicator\MollieOrderStatesApplicatorInterface::class, 'sylius_mollie.state_machine.order_set_status');
};
