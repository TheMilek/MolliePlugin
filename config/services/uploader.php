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

    $services->set('sylius_mollie.uploader.payment_method_logo', \Sylius\MolliePlugin\Uploader\PaymentMethodLogoUploader::class)
        ->public()
        ->args([service(\Sylius\Component\Core\Filesystem\Adapter\FilesystemAdapterInterface::class)]);

    $services->alias(\Sylius\MolliePlugin\Uploader\PaymentMethodLogoUploaderInterface::class, 'sylius_mollie.uploader.payment_method_logo');
};
