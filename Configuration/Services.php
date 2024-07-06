<?php

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator, ContainerBuilder $containerBuilder): void {
    $services = $containerConfigurator->services();
    $services->defaults()
        ->private()
        ->autowire()
        ->autoconfigure();

    $services->load('CReifenscheid\\RteCkeditorTextpartlanguage\\', __DIR__ . '/../Classes/');

    $services->set(\CReifenscheid\RteCkeditorTextpartlanguage\EventListener\RteConfigEnhancer::class)
        ->tag('event.listener');
};
