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

    $services->set('sylius_mollie.refund.checker.duplicate_refund_the_same_amount', \Sylius\MolliePlugin\Refund\Checker\DuplicateRefundTheSameAmountChecker::class)
        ->args([
            service('sylius_mollie.repository.query.credit_memo.by_order_id_date_time_and_amount'),
            service('sylius_refund.filter.unit_refund'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Refund\Checker\DuplicateRefundTheSameAmountCheckerInterface::class, 'sylius_mollie.refund.checker.duplicate_refund_the_same_amount');

    $services->set('sylius_mollie.refund.checker.mollie_order_refund', \Sylius\MolliePlugin\Refund\Checker\MollieOrderRefundChecker::class);

    $services->alias(\Sylius\MolliePlugin\Refund\Checker\MollieOrderRefundCheckerInterface::class, 'sylius_mollie.refund.checker.mollie_order_refund');
};
