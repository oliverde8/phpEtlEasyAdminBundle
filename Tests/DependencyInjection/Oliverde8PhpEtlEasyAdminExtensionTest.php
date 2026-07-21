<?php

declare(strict_types=1);

namespace Oliverde8\PhpEtlEasyAdminBundle\Tests\DependencyInjection;

use Oliverde8\PhpEtlEasyAdminBundle\Controller\Admin\EtlDashboardController;
use Oliverde8\PhpEtlEasyAdminBundle\Controller\Admin\EtlDownloadFileController;
use Oliverde8\PhpEtlEasyAdminBundle\Controller\Admin\EtlExecutionCrudController;
use Oliverde8\PhpEtlEasyAdminBundle\DependencyInjection\Oliverde8PhpEtlEasyAdminExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Smoke test for the bundle's DI wiring.
 *
 * Loading the extension parses services.yml, resolves its resource/exclude
 * globs and reflects over every registered class. That catches an unparseable
 * services.yml, a mistyped resource path, or a service that references a class
 * removed upstream (e.g. an EasyAdmin 4 API dropped in 5) — all at build time
 * rather than on the first admin page load.
 */
class Oliverde8PhpEtlEasyAdminExtensionTest extends TestCase
{
    public function testLoadRegistersControllerServices(): void
    {
        $container = new ContainerBuilder();

        (new Oliverde8PhpEtlEasyAdminExtension())->load([], $container);

        $this->assertTrue(
            $container->hasDefinition(EtlExecutionCrudController::class),
            'The CRUD controller should be registered as a service.'
        );
        $this->assertTrue(
            $container->hasDefinition(EtlDashboardController::class),
            'The dashboard controller should be registered as a service.'
        );
        $this->assertTrue(
            $container->hasDefinition(EtlDownloadFileController::class),
            'The download controller should be registered as a service.'
        );
    }
}
