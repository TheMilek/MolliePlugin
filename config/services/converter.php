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

    $services->set('sylius_mollie.converter.int_to_string', \Sylius\MolliePlugin\Converter\IntToStringConverter::class)
        ->args([service('sylius_mollie.provider.divisor')]);

    $services->alias(\Sylius\MolliePlugin\Converter\IntToStringConverterInterface::class, 'sylius_mollie.converter.int_to_string');

    $services->set('sylius_mollie.converter.order', \Sylius\MolliePlugin\Converter\OrderConverter::class)
        ->args([
            service('sylius_mollie.converter.int_to_string'),
            service('sylius_mollie.calculator.calculate_tax_amount'),
            service('sylius_mollie.resolver.meal_voucher'),
            service('sylius.resolver.tax_rate'),
            service('sylius.matcher.zone'),
            service('request_stack'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Converter\OrderConverterInterface::class, 'sylius_mollie.converter.order');

    $services->set('sylius_mollie.converter.price_to_amount', \Sylius\MolliePlugin\Converter\PriceToAmountConverter::class)
        ->args([
            service('sylius.context.currency'),
            service('sylius.context.locale'),
            service('sylius.formatter.money'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Converter\PriceToAmountConverterInterface::class, 'sylius_mollie.converter.price_to_amount');
};
