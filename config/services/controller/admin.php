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

    $services->set('sylius_mollie.controller.admin.refund', \Sylius\MolliePlugin\Controller\Admin\RefundAction::class)
        ->args([
            service('sylius.repository.payment'),
            service('payum'),
            service('request_stack'),
            service('sylius_abstraction.state_machine'),
            service('sylius.manager.payment'),
            service('sylius_mollie.logger.mollie_logger_action'),
        ]);

    $services->set('sylius_mollie.controller.admin.methods', \Sylius\MolliePlugin\Controller\Admin\MethodsAction::class)
        ->args([
            service('sylius_mollie.logger.mollie_logger_action'),
            service('request_stack'),
            service('sylius_mollie.updater.mollie_methods'),
            service('sylius.repository.gateway_config'),
        ]);

    $services->set('sylius_mollie.controller.admin.delete_payment_method_image', \Sylius\MolliePlugin\Controller\Admin\DeletePaymentMethodImageAction::class)
        ->args([
            service('sylius_mollie.uploader.payment_method_logo'),
            service('sylius_mollie.repository.mollie_gateway_config'),
            service('sylius.manager.gateway_config'),
            service('sylius_mollie.logger.mollie_logger_action'),
        ]);

    $services->set('sylius_mollie.controller.admin.generate_payment_link', \Sylius\MolliePlugin\Controller\Admin\GeneratePaymentLinkAction::class)
        ->args([
            service('sylius.repository.order'),
            service('twig'),
            service('request_stack'),
            service('router'),
            service('form.factory'),
            service('sylius_mollie.resolver.payment_link'),
            service('sylius_mollie.logger.mollie_logger_action'),
        ]);

    $services->alias('sylius_mollie.controller.admin.mollie_subscription', 'sylius_mollie.controller.mollie_subscription');

    $services->set('sylius_mollie.controller.admin.test_api_keys', \Sylius\MolliePlugin\Controller\Admin\TestApiKeysAction::class)
        ->args([
            service('sylius_mollie.resolver.api_keys_test'),
            service('twig'),
        ]);

    $services->set('sylius_mollie.controller.admin.change_position_payment_method', \Sylius\MolliePlugin\Controller\Admin\ChangePositionPaymentMethodAction::class)
        ->args([service('sylius_mollie.updater.mollie_payment_method_position')]);

    $services->set('sylius_mollie.controller.admin.onboarding_wizard.status', \Sylius\MolliePlugin\Controller\Admin\OnboardingWizard\StatusAction::class)
        ->args([service('sylius_mollie.context.admin_user')]);

    $services->set('sylius_mollie.controller.admin.onboarding_wizard.completed', \Sylius\MolliePlugin\Controller\Admin\OnboardingWizard\CompletedAction::class)
        ->args([
            service('sylius_mollie.context.admin_user'),
            service('doctrine.orm.entity_manager'),
        ]);
};
