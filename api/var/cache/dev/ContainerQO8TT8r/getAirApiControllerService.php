<?php

namespace ContainerQO8TT8r;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getAirApiControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\AirApiController' shared autowired service.
     *
     * @return \App\Controller\AirApiController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/AirApiController.php';
        include_once \dirname(__DIR__, 4) . '/src/Services/GetAirportsDataService.php';

        $container->services['App\\Controller\\AirApiController'] = $instance = new \App\Controller\AirApiController(new \App\Services\GetAirportsDataInterface(($container->privates['http_client'] ?? $container->load('getHttpClientService')), ($container->services['doctrine.orm.default_entity_manager'] ?? $container->getDoctrine_Orm_DefaultEntityManagerService()), ($container->services['.container.private.serializer'] ?? $container->get_Container_Private_SerializerService()), ($container->services['.container.private.validator'] ?? $container->get_Container_Private_ValidatorService())));

        $instance->setContainer(($container->privates['.service_locator.GNc8e5B'] ?? $container->load('get_ServiceLocator_GNc8e5BService'))->withContext('App\\Controller\\AirApiController', $container));

        return $instance;
    }
}