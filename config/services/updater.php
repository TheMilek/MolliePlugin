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
    $parameters = $container->parameters();
    $parameters->set('sylius_mollie.mollie_payment_methods_refresh_ttl', 7200);

    $services->defaults()
        ->public();

    $services->set('sylius_mollie.updater.mollie_payment_method_position', \Sylius\MolliePlugin\Updater\MolliePaymentMethodPositionUpdater::class)
        ->args([
            service('sylius_mollie.repository.mollie_gateway_config'),
            service('doctrine.orm.entity_manager'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Updater\MolliePaymentMethodPositionUpdaterInterface::class, 'sylius_mollie.updater.mollie_payment_method_position');

    $services->set('sylius_mollie.updater.mollie_methods', \Sylius\MolliePlugin\Updater\MollieMethodsUpdater::class)
        ->args([
            service('cache.app'),
            service('sylius_mollie.provider.methods.mollie_methods'),
            service('sylius_mollie.repository.mollie_gateway_config'),
            service('sylius_mollie.factory.mollie_gateway_config'),
            service('sylius_mollie.factory.methods'),
            service('doctrine.orm.default_entity_manager'),
            '%sylius_mollie.mollie_payment_methods_refresh_ttl%',
        ]);

    $services->alias(\Sylius\MolliePlugin\Updater\MollieMethodsUpdaterInterface::class, 'sylius_mollie.updater.mollie_methods');

    $services->set('sylius_mollie.synchronizer.mollie_payment_methods', \Sylius\MolliePlugin\Updater\MolliePaymentMethodsSynchronizer::class)
        ->args([
            service('sylius.repository.payment_method'),
            service('sylius.context.channel'),
            service('sylius_mollie.updater.mollie_methods'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Updater\MolliePaymentMethodsSynchronizerInterface::class, 'sylius_mollie.synchronizer.mollie_payment_methods');
};
