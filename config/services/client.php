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

    $services->set('sylius_mollie.client.mollie_api', \Sylius\MolliePlugin\Client\MollieApiClient::class);

    $services->set('sylius_mollie.client.parser.api_exception', \Sylius\MolliePlugin\Client\Parser\ApiExceptionParser::class)
        ->public();

    $services->alias(\Sylius\MolliePlugin\Client\Parser\ApiExceptionParserInterface::class, 'sylius_mollie.client.parser.api_exception');
};
