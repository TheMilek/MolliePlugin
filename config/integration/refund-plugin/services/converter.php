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

    $services->set('sylius_mollie.refund.converter.refund_data', \Sylius\MolliePlugin\Refund\Converter\RefundDataConverter::class)
        ->args([service('sylius_mollie.converter.int_to_string')]);

    $services->alias(\Sylius\MolliePlugin\Refund\Converter\RefundDataConverterInterface::class, 'sylius_mollie.refund.converter.refund_data');
};
