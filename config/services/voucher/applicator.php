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

    $services->set('sylius_mollie.voucher.applicator.units_promotion_adjustments', \Sylius\MolliePlugin\Voucher\Applicator\UnitsVouchersApplicator::class)
        ->args([
            service('sylius.custom_factory.adjustment'),
            service('sylius.distributor.integer'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Voucher\Applicator\UnitsVouchersApplicatorInterface::class, 'sylius_mollie.voucher.applicator.units_promotion_adjustments');

    $services->set('sylius_mollie.voucher.applicator.order_vouchers', \Sylius\MolliePlugin\Voucher\Applicator\OrderVouchersApplicator::class)
        ->args([
            service('sylius.distributor.proportional_integer'),
            service('sylius_mollie.voucher.applicator.units_promotion_adjustments'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Voucher\Applicator\OrderVouchersApplicatorInterface::class, 'sylius_mollie.voucher.applicator.order_vouchers');
};
