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
    $parameters->set('sylius_mollie.payment_surcharge_adjustments', [\Sylius\MolliePlugin\Model\AdjustmentInterface::FIXED_AMOUNT_ADJUSTMENT, \Sylius\MolliePlugin\Model\AdjustmentInterface::PERCENTAGE_ADJUSTMENT, \Sylius\MolliePlugin\Model\AdjustmentInterface::PERCENTAGE_AND_AMOUNT_ADJUSTMENT]);

    $services->defaults()
        ->public();

    $services->set('sylius_mollie.provider.divisor', \Sylius\MolliePlugin\Provider\DivisorProvider::class);

    $services->alias(\Sylius\MolliePlugin\Provider\DivisorProviderInterface::class, 'sylius_mollie.provider.divisor');

    $services->set('sylius_mollie.provider.payment_surcharge_adjustments', \Sylius\MolliePlugin\Provider\PaymentSurchargeAdjustmentsProvider::class)
        ->args(['%sylius_mollie.payment_surcharge_adjustments%']);

    $services->alias(\Sylius\MolliePlugin\Provider\PaymentSurchargeAdjustmentsProviderInterface::class, 'sylius_mollie.provider.payment_surcharge_adjustments');

    $services->set('sylius_mollie.provider.customer', \Sylius\MolliePlugin\Provider\CustomerProvider::class)
        ->args([
            service('sylius.repository.customer'),
            service('sylius.factory.customer'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Provider\CustomerProviderInterface::class, 'sylius_mollie.provider.customer');

    $services->set('sylius_mollie.provider.payment_description', \Sylius\MolliePlugin\Provider\PaymentDescriptionProvider::class)
        ->args([service('sylius_payum.provider.payment_description')]);

    $services->alias(\Sylius\MolliePlugin\Provider\PaymentDescriptionProviderInterface::class, 'sylius_mollie.provider.payment_description');

    $services->set('sylius_mollie.provider.methods.mollie_methods', \Sylius\MolliePlugin\Provider\Methods\MollieMethodsProvider::class)
        ->args([
            service('sylius_mollie.client.mollie_api'),
            service('sylius_mollie.logger.mollie_logger_action'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Provider\Methods\MollieMethodsProviderInterface::class, 'sylius_mollie.provider.methods.mollie_methods');
};
