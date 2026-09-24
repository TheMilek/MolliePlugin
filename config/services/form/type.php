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

    $services->set('sylius_mollie.form.type.mollie_gateway_configuration', \Sylius\MolliePlugin\Form\Type\MollieGatewayConfigurationType::class)
        ->args([service('sylius_mollie.client.mollie_api')])
        ->tag('sylius.gateway_configuration_type', ['type' => 'mollie', 'label' => 'sylius_mollie.ui.mollie_gateway_label'])
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.mollie_subscription_gateway_configuration', \Sylius\MolliePlugin\Form\Type\MollieSubscriptionGatewayConfigurationType::class)
        ->tag('sylius.gateway_configuration_type', ['type' => 'mollie_subscription', 'label' => 'sylius_mollie.ui.mollie_subscription_gateway_label'])
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.mollie_payment', \Sylius\MolliePlugin\Form\Type\PaymentMollieType::class)
        ->args([service('sylius_mollie.resolver.payment_methods')])
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.mollie_interval', \Sylius\MolliePlugin\Form\Type\MollieIntervalType::class)
        ->args([service('sylius_mollie.form.type.data_transformer.mollie_interval')])
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.mollie_gateway_config', \Sylius\MolliePlugin\Form\Type\MollieGatewayConfigType::class)
        ->args([
            '%sylius_mollie.model.mollie_gateway_config.class%',
            '%sylius_mollie.form.type.mollie_gateway_config.validation_groups%',
            '%sylius_locale.locale%',
        ])
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.payment_surcharge_fee', \Sylius\MolliePlugin\Form\Type\PaymentSurchargeFeeType::class)
        ->args([
            '%sylius_mollie.model.payment_surcharge_fee.class%',
            '%sylius_mollie.form.type.payment_methods.payment_surcharge_fee.validation_groups%',
        ])
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.customize_method_image', \Sylius\MolliePlugin\Form\Type\CustomizeMethodImageType::class)
        ->args(['%sylius_mollie.model.mollie_method_image.class%'])
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.product_type', \Sylius\MolliePlugin\Form\Type\ProductTypeType::class)
        ->args([
            '%sylius_mollie.model.product_type.class%',
            '%sylius_mollie.form.type.mollie.validation_groups%',
        ])
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.translation.block_translation', \Sylius\MolliePlugin\Form\Type\Translation\TemplateMollieEmailTranslationType::class)
        ->args(['%sylius_mollie.model.template_mollie_email_translation.class%'])
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.translation.payment_method_translation', \Sylius\MolliePlugin\Form\Type\Translation\MollieGatewayConfigTranslationType::class)
        ->args(['%sylius_mollie.model.mollie_gateway_config_translation.class%'])
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.countries_restriction_choice', \Sylius\MolliePlugin\Form\Type\CountriesRestrictionChoiceType::class)
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.payment_type_choice', \Sylius\MolliePlugin\Form\Type\PaymentTypeChoiceType::class)
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.payment_surcharge_type_choice', \Sylius\MolliePlugin\Form\Type\PaymentSurchargeFeeTypeChoiceType::class)
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.logger_level_choice', \Sylius\MolliePlugin\Form\Type\LoggerLevelChoiceType::class)
        ->tag('form.type');

    $services->set('sylius_mollie.form.type.payment_link', \Sylius\MolliePlugin\Form\Type\PaymentLinkType::class)
        ->tag('form.type');
};
