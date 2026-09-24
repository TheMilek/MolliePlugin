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

    $services->set('sylius_mollie.resolver.payment_methods', \Sylius\MolliePlugin\Resolver\MolliePaymentsMethodResolver::class)
        ->args([
            service('sylius_mollie.repository.mollie_gateway_config'),
            service('sylius_mollie.resolver.mollie_countries_restriction'),
            service('sylius_mollie.voucher.checker.product_voucher_type'),
            service('sylius_mollie.resolver.order.payment_checkout_order'),
            service('sylius_mollie.repository.query.payment_method.mollie_based'),
            service('sylius_mollie.resolver.mollie_allowed_methods'),
            service('sylius_mollie.logger.mollie_logger_action'),
            service('sylius_mollie.resolver.mollie_factory_name'),
            service('sylius_mollie.provider.divisor'),
            service('sylius_mollie.calculator.payment_fee.charged_surcharge_matcher'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Resolver\MolliePaymentsMethodResolverInterface::class, 'sylius_mollie.resolver.payment_methods');

    $services->set('sylius_mollie.resolver.payment_methods_image', \Sylius\MolliePlugin\Resolver\MolliePaymentMethodImageResolver::class);

    $services->alias(\Sylius\MolliePlugin\Resolver\MolliePaymentMethodImageResolverInterface::class, 'sylius_mollie.resolver.payment_methods_image');

    $services->set('sylius_mollie.resolver.payment_config', \Sylius\MolliePlugin\Resolver\PaymentMethodConfigResolver::class)
        ->args([service('sylius_mollie.repository.mollie_gateway_config')]);

    $services->alias(\Sylius\MolliePlugin\Resolver\PaymentMethodConfigResolverInterface::class, 'sylius_mollie.resolver.payment_config');

    $services->set('sylius_mollie.resolver.payment_locale', \Sylius\MolliePlugin\Resolver\PaymentLocaleResolver::class);

    $services->alias(\Sylius\MolliePlugin\Resolver\PaymentLocaleResolverInterface::class, 'sylius_mollie.resolver.payment_locale');

    $services->set('sylius_mollie.resolver.payment_link', \Sylius\MolliePlugin\Resolver\PaymentLinkResolver::class)
        ->args([
            service('sylius_mollie.client.mollie_api'),
            service('sylius_mollie.converter.int_to_string'),
            service('sylius.repository.order'),
            service('sylius_mollie.mailer.manager.payment_link_email'),
            service('sylius_mollie.payum.provider.payment_token'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Resolver\PaymentLinkResolverInterface::class, 'sylius_mollie.resolver.payment_link');

    $services->set('sylius_mollie.resolver.mollie_countries_restriction', \Sylius\MolliePlugin\Resolver\MollieCountriesRestrictionResolver::class)
        ->args([service('sylius_mollie.resolver.payment_methods_image')]);

    $services->alias(\Sylius\MolliePlugin\Resolver\MollieCountriesRestrictionResolverInterface::class, 'sylius_mollie.resolver.mollie_countries_restriction');

    $services->set('sylius_mollie.resolver.mollie_factory_name', \Sylius\MolliePlugin\Resolver\MollieFactoryNameResolver::class)
        ->args([service('sylius.context.cart')]);

    $services->alias(\Sylius\MolliePlugin\Resolver\MollieFactoryNameResolverInterface::class, 'sylius_mollie.resolver.mollie_factory_name');

    $services->set('sylius_mollie.resolver.meal_voucher', \Sylius\MolliePlugin\Resolver\MealVoucherResolver::class);

    $services->alias(\Sylius\MolliePlugin\Resolver\MealVoucherResolverInterface::class, 'sylius_mollie.resolver.meal_voucher');

    $services->set('sylius_mollie.resolver.mollie_api_client_key', \Sylius\MolliePlugin\Resolver\MollieApiClientKeyResolver::class)
        ->args([
            service('sylius_mollie.client.mollie_api'),
            service('sylius_mollie.logger.mollie_logger_action'),
            service('sylius_mollie.repository.query.payment_method.mollie_based'),
            service('sylius.context.channel'),
            service('sylius_mollie.resolver.mollie_factory_name'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Resolver\MollieApiClientKeyResolverInterface::class, 'sylius_mollie.resolver.mollie_api_client_key');

    $services->set('sylius_mollie.resolver.api_keys_test', \Sylius\MolliePlugin\Resolver\ApiKeysTestResolver::class)
        ->args([service('sylius_mollie.creator.api_keys_test')]);

    $services->alias(\Sylius\MolliePlugin\Resolver\ApiKeysTestResolverInterface::class, 'sylius_mollie.resolver.api_keys_test');

    $services->set('sylius_mollie.resolver.order.payment_checkout_order', \Sylius\MolliePlugin\Resolver\Order\PaymentCheckoutOrderResolver::class)
        ->args([
            service('request_stack'),
            service('sylius.context.cart'),
            service('sylius.repository.order'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Resolver\Order\PaymentCheckoutOrderResolverInterface::class, 'sylius_mollie.resolver.order.payment_checkout_order');

    $services->set('sylius_mollie.resolver.mollie_methods', \Sylius\MolliePlugin\Resolver\MollieMethodsResolver::class)
        ->args([
            service('sylius_mollie.logger.mollie_logger_action'),
            service('sylius_mollie.client.mollie_api'),
            service('sylius.repository.gateway_config'),
            service('sylius_mollie.creator.mollie_methods'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Resolver\MollieMethodsResolverInterface::class, 'sylius_mollie.resolver.mollie_methods');

    $services->set('sylius_mollie.resolver.mollie_allowed_methods', \Sylius\MolliePlugin\Resolver\MollieAllowedMethodsResolver::class)
        ->args([
            service('sylius_mollie.resolver.mollie_api_client_key'),
            service('sylius_mollie.resolver.payment_locale'),
            service('sylius_mollie.converter.int_to_string'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Resolver\MollieAllowedMethodsResolverInterface::class, 'sylius_mollie.resolver.mollie_allowed_methods');

    $services->set('sylius_mollie.payment_methods_resolver.mollie_payment', \Sylius\MolliePlugin\Resolver\PaymentMethodResolver::class)
        ->decorate('sylius.resolver.payment_methods.default')
        ->args([
            service('.inner'),
            service('sylius_mollie.repository.query.payment_method.mollie_based'),
            service('sylius_mollie.resolver.mollie_factory_name'),
            service('sylius_mollie.filter.mollie_method'),
            service('doctrine.orm.entity_manager'),
            service('sylius_mollie.calculator.payment_fee.charged_surcharge_matcher'),
            service('sylius_mollie.payum.checker.mollie_gateway_factory'),
            service('sylius_mollie.logger.mollie_logger_action'),
        ])
        ->tag('sylius.payment_method_resolver', ['type' => 'mollie', 'label' => 'Mollie', 'priority' => 2]);
};
