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

    $services->set('sylius_mollie.repository.query.order.abandoned', \Sylius\MolliePlugin\Repository\Query\AbandonedOrdersQuery::class)
        ->args([service('sylius.repository.order')]);

    $services->alias(\Sylius\MolliePlugin\Repository\Query\AbandonedOrdersQueryInterface::class, 'sylius_mollie.repository.query.order.abandoned');

    $services->set('sylius_mollie.repository.query.payment_method.mollie_based', \Sylius\MolliePlugin\Repository\Query\MollieBasedPaymentMethodQuery::class)
        ->args([service('sylius.repository.payment_method')]);

    $services->alias(\Sylius\MolliePlugin\Repository\Query\MollieBasedPaymentMethodQueryInterface::class, 'sylius_mollie.repository.query.payment_method.mollie_based');

    $services->set('sylius_mollie.repository.query.order.by_token_for_available_methods', \Sylius\MolliePlugin\Repository\Query\OrderByTokenForAvailableMethodsQuery::class)
        ->args([service('sylius.repository.order')]);

    $services->alias(\Sylius\MolliePlugin\Repository\Query\OrderByTokenForAvailableMethodsQueryInterface::class, 'sylius_mollie.repository.query.order.by_token_for_available_methods');
};
