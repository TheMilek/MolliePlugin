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

    $services->set('sylius_mollie.mailer.manager.payment_link_email', \Sylius\MolliePlugin\Mailer\Manager\PaymentLinkEmailManager::class)
        ->args([
            service('sylius_mollie.repository.template_mollie_email_translation'),
            service('sylius_mollie.mailer.sender.payment_link'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Mailer\Manager\PaymentLinkEmailManagerInterface::class, 'sylius_mollie.mailer.manager.payment_link_email');
};
