<?php

namespace Account\Infra;

use Account\Infra\Controller\AccountController;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
        ];
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        // PHP equivalent of config/packages/framework.yaml
        $container->extension('framework', [
            'secret' => 'S0ME_SECRET'
        ]);
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->add('signup', '/signup')->controller([AccountController::class, 'signup'])->methods(["POST"]);
        $routes->add('getAccountById', '/account/accountId/{accountId}')->controller([AccountController::class, 'getById'])->methods(["GET"]);
        $routes->add('getAccountByEmail', '/account/email/{email}')->controller([AccountController::class, 'getByEmail'])->methods(["GET"]);
        $routes->add('activateAccount', '/account/activate/{verificationCode}')->controller([AccountController::class, 'activate'])->methods(["GET"]);
    }
}