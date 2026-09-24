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

    $services->set('sylius_mollie.api.payment_configuration_provider.mollie', \Sylius\MolliePlugin\Api\MolliePaymentConfigurationProvider::class)
        ->args([service('router')])
        ->tag('sylius.api.payment_method_handler');

    $services->set('sylius_mollie.api.controller.get_mollie_methods', \Sylius\MolliePlugin\Api\Controller\GetMollieMethodsAction::class)
        ->public()
        ->args([
            service('sylius_mollie.repository.query.order.by_token_for_available_methods'),
            service('sylius_mollie.payum.checker.mollie_gateway_factory'),
            service('sylius_mollie.resolver.payment_methods'),
            service('liip_imagine.cache.manager'),
        ]);

    $services->set('sylius_mollie.api.controller.select_mollie_method', \Sylius\MolliePlugin\Api\Controller\SelectMollieMethodAction::class)
        ->public()
        ->args([
            service('sylius.repository.order'),
            service('doctrine.orm.entity_manager'),
            service('sylius_mollie.resolver.mollie_api_client_key'),
            service('sylius_mollie.payum.checker.mollie_gateway_factory'),
            service('sylius_mollie.repository.mollie_customer'),
            service('sylius_mollie.custom_factory.mollie_subscription'),
            service('sylius_mollie.repository.mollie_subscription'),
            service('sylius_mollie.creator.payment_data'),
            service('sylius_mollie.logger.mollie_logger_action'),
            service('sylius_mollie.resolver.payment_methods'),
        ]);

    $services->set('sylius_mollie.api.controller.update_payment_status', \Sylius\MolliePlugin\Api\Controller\UpdatePaymentStatusAction::class)
        ->public()
        ->args([
            service('sylius.repository.order'),
            service('doctrine.orm.entity_manager'),
            service('sylius_mollie.resolver.mollie_api_client_key'),
            service('sylius_abstraction.state_machine'),
            service('sylius_mollie.logger.mollie_logger_action'),
        ]);

    $services->set('sylius_mollie.api.open_api.mollie_documentation_modifier', \Sylius\MolliePlugin\Api\OpenApi\MollieDocumentationModifier::class)
        ->args(['%sylius.security.api_shop_route%'])
        ->tag('sylius.open_api.modifier');
};
