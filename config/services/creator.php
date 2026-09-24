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

    $services->set('sylius_mollie.creator.abandoned_payment_link', \Sylius\MolliePlugin\Creator\AbandonedPaymentLinkCreator::class)
        ->args([
            service('sylius_mollie.resolver.payment_link'),
            service('sylius_mollie.repository.query.order.abandoned'),
            service('sylius_mollie.repository.query.payment_method.mollie_based'),
            service('sylius.repository.channel'),
            service('doctrine.orm.entity_manager'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Creator\AbandonedPaymentLinkCreatorInterface::class, 'sylius_mollie.creator.abandoned_payment_link');

    $services->set('sylius_mollie.creator.mollie_methods', \Sylius\MolliePlugin\Creator\MollieMethodsCreator::class)
        ->args([
            service('sylius_mollie.factory.methods'),
            service('doctrine.orm.default_entity_manager'),
            service('sylius_mollie.custom_factory.mollie_gateway_config'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Creator\MollieMethodsCreatorInterface::class, 'sylius_mollie.creator.mollie_methods');

    $services->set('sylius_mollie.creator.api_keys_test', \Sylius\MolliePlugin\Creator\ApiKeysTestCreator::class)
        ->args([
            service('sylius_mollie.client.mollie_api'),
            service('translator'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Creator\ApiKeysTestCreatorInterface::class, 'sylius_mollie.creator.api_keys_test');

    $services->set('sylius_mollie.creator.payment_data', \Sylius\MolliePlugin\Creator\PaymentDataCreator::class)
        ->args([
            service('sylius_mollie.converter.int_to_string'),
            service('router'),
            service('sylius_mollie.provider.payment_description'),
            service('sylius_mollie.resolver.payment_locale'),
            service('sylius_mollie.provider.divisor'),
            service('sylius_mollie.repository.mollie_gateway_config'),
            service('sylius_mollie.converter.order'),
            '%locale%',
        ]);

    $services->alias(\Sylius\MolliePlugin\Creator\PaymentDataCreatorInterface::class, 'sylius_mollie.creator.payment_data');
};
