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
    $parameters->set('sylius_mollie.twig.functions', ['sylius_mollie_render_email_template']);

    $services->set('sylius_mollie.twig.parser.content', \Sylius\MolliePlugin\Twig\Parser\ContentParser::class)
        ->public()
        ->args([
            service('twig'),
            '%sylius_mollie.twig.functions%',
            service('translator'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Twig\Parser\ContentParserInterface::class, 'sylius_mollie.twig.parser.content');

    $services->set('sylius_mollie.twig.extension.mollie_plugin_latest_version', \Sylius\MolliePlugin\Twig\Extension\MolliePluginLatestVersion::class)
        ->tag('twig.extension');

    $services->set('sylius_mollie.twig.extension.customer_credit_cards', \Sylius\MolliePlugin\Twig\Extension\CustomerCreditCards::class)
        ->args([
            service('sylius_mollie.repository.mollie_customer'),
            service('sylius.context.customer'),
        ])
        ->tag('twig.extension');

    $services->set('sylius_mollie.twig.extension.apple_pay_direct_enabled', \Sylius\MolliePlugin\Twig\Extension\ApplePayDirectEnabled::class)
        ->args([service('sylius_mollie.apple_pay.checker.apple_pay_enabled')])
        ->tag('twig.extension');

    $services->set('sylius_mollie.twig.extension.divisor_provider', \Sylius\MolliePlugin\Twig\Extension\DivisorProvider::class)
        ->args([service('sylius_mollie.provider.divisor')])
        ->tag('twig.extension');

    $services->set('sylius_mollie.twig.extension.legacy_refund', \Sylius\MolliePlugin\Twig\Extension\LegacyRefundExtension::class)
        ->args([service('sylius_mollie.payum.checker.mollie_gateway_factory')])
        ->tag('twig.extension');

    $services->set('sylius_mollie.twig.component.email_template.form', \Sylius\Bundle\UiBundle\Twig\Component\ResourceFormComponent::class)
        ->args([
            service('sylius_mollie.repository.template_mollie_email'),
            service('form.factory'),
            '%sylius_mollie.model.template_mollie_email.class%',
            \Sylius\MolliePlugin\Form\Type\TemplateMollieEmailType::class,
        ])
        ->tag('sylius.live_component.admin', ['key' => 'sylius_mollie:admin:email_template:form']);

    $services->set('sylius_mollie.twig.component.order.cancel_subscription', \Sylius\MolliePlugin\Twig\Component\Order\CancelSubscriptionComponent::class)
        ->args([
            service('sylius_mollie.repository.mollie_subscription'),
            service('sylius_abstraction.state_machine'),
        ])
        ->tag('sylius.twig_component', ['key' => 'sylius_mollie:shop:order:cancel_subscription']);
};
