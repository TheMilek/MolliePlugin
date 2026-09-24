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

    $services->set('sylius_mollie.form.extension.type.product_variant_recurring', \Sylius\MolliePlugin\Form\Extension\ProductVariantRecurringExtension::class)
        ->args([service('sylius_mollie.form.resolver.product_variant_validation_groups')])
        ->tag('form.type_extension', ['extended_type' => \Sylius\Bundle\ProductBundle\Form\Type\ProductVariantType::class]);

    $services->set('sylius_mollie.form.extension.type.payment', \Sylius\MolliePlugin\Form\Extension\PaymentTypeExtension::class)
        ->args([service(\Sylius\MolliePlugin\Payum\Checker\MollieGatewayFactoryCheckerInterface::class)])
        ->tag('form.type_extension', ['extended_type' => \Sylius\Bundle\CoreBundle\Form\Type\Checkout\PaymentType::class]);

    $services->set('sylius_mollie.form.extension.type.gateway_config', \Sylius\MolliePlugin\Form\Extension\GatewayConfigTypeExtension::class)
        ->tag('form.type_extension', ['extended_type' => \Sylius\Bundle\PaymentBundle\Form\Type\GatewayConfigType::class]);

    $services->set('sylius_mollie.form.extension.type.product_type', \Sylius\MolliePlugin\Form\Extension\ProductTypeExtension::class)
        ->tag('form.type_extension', ['extended_type' => \Sylius\Bundle\ProductBundle\Form\Type\ProductType::class]);
};
