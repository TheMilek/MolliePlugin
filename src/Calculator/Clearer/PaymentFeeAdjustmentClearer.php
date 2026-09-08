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

namespace Sylius\MolliePlugin\Calculator\Clearer;

use Sylius\Component\Order\Model\OrderInterface;
use Sylius\MolliePlugin\Model\AdjustmentInterface;
use Sylius\MolliePlugin\Provider\PaymentSurchargeAdjustmentsProviderInterface;

final class PaymentFeeAdjustmentClearer implements PaymentFeeAdjustmentClearerInterface
{
    /** The three types this cleared before the provider told it which types exist. */
    private const BUILT_IN_TYPES = [
        AdjustmentInterface::FIXED_AMOUNT_ADJUSTMENT,
        AdjustmentInterface::PERCENTAGE_ADJUSTMENT,
        AdjustmentInterface::PERCENTAGE_AND_AMOUNT_ADJUSTMENT,
    ];

    public function __construct(
        private readonly ?PaymentSurchargeAdjustmentsProviderInterface $surchargeAdjustmentsProvider = null,
    ) {
        if (null === $this->surchargeAdjustmentsProvider) {
            trigger_deprecation(
                'sylius/mollie-plugin',
                '3.4',
                'Not passing PaymentSurchargeAdjustmentsProviderInterface to %s is deprecated and will be required in 4.0. ' .
                'Without it only the three built in surcharge adjustment types are cleared.',
                self::class,
            );
        }
    }

    public function clear(OrderInterface $order): void
    {
        $types = $this->surchargeAdjustmentsProvider?->getTypes() ?? self::BUILT_IN_TYPES;

        foreach ($types as $type) {
            $order->removeAdjustments($type);
        }
    }
}
