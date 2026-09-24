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

    $services->set('sylius_mollie.grid.filter.mollie_logger_level', \Sylius\MolliePlugin\Grid\Filter\MollieLoggerLevel::class)
        ->tag('sylius.grid_filter', ['type' => 'log_level', 'form_type' => \Sylius\MolliePlugin\Form\Type\MollieLoggerLevelFilterType::class]);

    $services->set('sylius_mollie.grid.filter.mollie_subscription_state', \Sylius\MolliePlugin\Grid\Filter\MollieSubscriptionState::class)
        ->tag('sylius.grid_filter', ['type' => 'subscription_state', 'form_type' => \Sylius\MolliePlugin\Form\Type\MollieSubscriptionStateGridFilterType::class]);
};
