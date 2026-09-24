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

    $services->set('sylius_mollie.calculator.calculate_tax_amount', \Sylius\MolliePlugin\Calculator\CalculateTaxAmount::class)
        ->public()
        ->args([service('sylius_mollie.converter.int_to_string')]);

    $services->alias(\Sylius\MolliePlugin\Calculator\CalculateTaxAmountInterface::class, 'sylius_mollie.calculator.calculate_tax_amount');

    $services->set('sylius_mollie.calculator.payment_fee.fixed_amount', \Sylius\MolliePlugin\Calculator\PaymentFee\FixedAmountCalculator::class)
        ->args([
            service('sylius.factory.adjustment'),
            service('sylius_mollie.provider.divisor'),
        ])
        ->tag('sylius_mollie.payment_fee.calculator');

    $services->set('sylius_mollie.calculator.payment_fee.percentage', \Sylius\MolliePlugin\Calculator\PaymentFee\PercentageCalculator::class)
        ->args([
            service('sylius.factory.adjustment'),
            service('sylius_mollie.provider.divisor'),
        ])
        ->tag('sylius_mollie.payment_fee.calculator');

    $services->set('sylius_mollie.calculator.payment_fee.fixed_amount_and_percentage', \Sylius\MolliePlugin\Calculator\PaymentFee\FixedAmountAndPercentageCalculator::class)
        ->args([
            service('sylius.factory.adjustment'),
            service('sylius_mollie.calculator.payment_fee.percentage'),
            service('sylius_mollie.calculator.payment_fee.fixed_amount'),
            service('sylius_mollie.provider.divisor'),
        ])
        ->tag('sylius_mollie.payment_fee.calculator');

    $services->set('sylius_mollie.calculator.payment_fee.no_fee', \Sylius\MolliePlugin\Calculator\PaymentFee\NoFeeCalculator::class)
        ->tag('sylius_mollie.payment_fee.calculator');

    $services->set('sylius_mollie.calculator.payment_fee.composite', \Sylius\MolliePlugin\Calculator\PaymentFee\CompositePaymentSurchargeCalculator::class)
        ->args([tagged_iterator('sylius_mollie.payment_fee.calculator')]);

    $services->alias(\Sylius\MolliePlugin\Calculator\PaymentFee\PaymentSurchargeCalculatorInterface::class, 'sylius_mollie.calculator.payment_fee.composite');

    $services->alias(\Sylius\MolliePlugin\Calculator\PaymentFee\PaymentSurchargeAmountCalculatorInterface::class, 'sylius_mollie.calculator.payment_fee.composite');

    $services->set('sylius_mollie.calculator.payment_fee.charged_surcharge_matcher', \Sylius\MolliePlugin\Calculator\PaymentFee\ChargedSurchargeMatcher::class)
        ->args([
            service('sylius_mollie.provider.payment_surcharge_adjustments'),
            service('sylius_mollie.calculator.payment_fee.composite'),
            service('sylius_mollie.repository.mollie_gateway_config'),
        ]);

    $services->alias(\Sylius\MolliePlugin\Calculator\PaymentFee\ChargedSurchargeMatcherInterface::class, 'sylius_mollie.calculator.payment_fee.charged_surcharge_matcher');

    $services->set('sylius_mollie.calculator.clearer.payment_fee_adjustment', \Sylius\MolliePlugin\Calculator\Clearer\PaymentFeeAdjustmentClearer::class)
        ->args([service('sylius_mollie.provider.payment_surcharge_adjustments')]);

    $services->alias(\Sylius\MolliePlugin\Calculator\Clearer\PaymentFeeAdjustmentClearerInterface::class, 'sylius_mollie.calculator.clearer.payment_fee_adjustment');
};
