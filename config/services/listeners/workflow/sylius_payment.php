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

    $services->set('sylius_mollie.listener.workflow.payment.subscription_payment_fail', \Sylius\MolliePlugin\EventListener\Workflow\Payment\SubscriptionPaymentFailListener::class)
        ->args([service('sylius_mollie.subscription.processor.subscription_payment')])
        ->tag('kernel.event_listener', ['event' => 'workflow.sylius_payment.completed.fail', 'priority' => -100])
        ->tag('kernel.event_listener', ['event' => 'workflow.sylius_payment.completed.cancel', 'priority' => -100]);

    $services->set('sylius_mollie.listener.workflow.payment.subscription_payment_success', \Sylius\MolliePlugin\EventListener\Workflow\Payment\SubscriptionPaymentSuccessListener::class)
        ->args([service('sylius_mollie.subscription.processor.subscription_payment')])
        ->tag('kernel.event_listener', ['event' => 'workflow.sylius_payment.completed.complete', 'priority' => -100]);

    $services->set('sylius_mollie.listener.workflow.payment.refund_guard', \Sylius\MolliePlugin\EventListener\Workflow\Payment\PaymentRefundGuardListener::class)
        ->args([service('sylius_mollie.refund.guard.mollie_payment_refund')])
        ->tag('kernel.event_listener', ['event' => 'workflow.sylius_payment.guard.refund', 'priority' => 0]);
};
