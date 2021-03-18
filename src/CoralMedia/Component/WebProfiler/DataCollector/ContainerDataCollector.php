<?php


namespace CoralMedia\Component\WebProfiler\DataCollector;


use Symfony\Bundle\FrameworkBundle\DataCollector\AbstractDataCollector;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class ContainerDataCollector
 * @package CoralMedia\Component\WebProfiler\DataCollector
 * @author Vincent Bouzeran <vincent.bouzeran@elao.com>
 * @author Rafael Espinosa <rernesto.espinosa@gmail.com>
 */
class ContainerDataCollector extends AbstractDataCollector
{

    /**
     * @var Kernel
     */
    protected $kernel;

    /**
     * @var ContainerBuilder
     */
    protected $containerBuilder;

    public function __construct(KernelInterface $kernel, $displayInWdt=true)
    {
        $this->kernel = $kernel;
        $this->data['display_in_wdt'] = $displayInWdt;
    }

    /**
     * Gets the Kernel
     *
     * @return object The Kernel Object
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * Collect information about services and parameters from the cached dumped xml container
     *
     * @param Request $request The Request Object
     * @param Response $response The Response Object
     * @param \Throwable $exception The Exception
     */
    public function collect(Request $request, Response $response, \Throwable $exception = null)
    {
        $parameters = array();
        $services = array();

        $this->loadContainerBuilder();

        if ($this->containerBuilder !== false) {
            foreach ($this->containerBuilder->getParameterBag()->all() as $key => $value) {
                $service = substr($key, 0, strpos($key, '.'));
                if (!isset($parameters[$service])) {
                    $parameters[$service] = array();
                }
                $parameters[$service][$key] = $value;
            }

            $serviceIds = $this->containerBuilder->getServiceIds();
            foreach ($serviceIds as $serviceId) {
                $definition = $this->resolveServiceDefinition($serviceId);

                if ($definition instanceof Definition && $definition->isPublic()) {
                    $services[$serviceId] = array('class' => $definition->getClass());
                } elseif ($definition instanceof Alias) {
                    $services[$serviceId] = array('alias' => $definition);
                } else {
                    continue;    // We don't want private services
                }
            }

            ksort($services);
            ksort($parameters);
        }
        $this->data['parameters'] = $parameters;
        $this->data['services'] = $services;
    }

    /**
     * Resets this data collector to its initial state.
     */
    public function reset(): void
    {
        $this->data = ['display_in_wdt' => $this->data['display_in_wdt']];
    }

    /**
     * Returns the Parameters Information
     *
     * @return array Collection of Parameters
     */
    public function getParameters()
    {
        return $this->data['parameters'];
    }

    /**
     * Returns the amount of Services
     *
     * @return integer Amount of Services
     */
    public function getServiceCount()
    {
        return count($this->getServices());
    }

    /**
     * Returns the Services Information
     *
     * @return array Collection of the Services
     */
    public function getServices()
    {
        return $this->data['services'];
    }

    public function getDisplayInWdt()
    {
        return $this->data['display_in_wdt'];
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'container';
    }

    /**
     * Loads the ContainerBuilder from the cache.
     *
     * @author Ryan Weaver <ryan@thatsquality.com>
     *
     */
    private function loadContainerBuilder()
    {
        if ($this->containerBuilder !== null) {
            return;
        }
        $container = $this->kernel->getContainer();
        if (!$this->getKernel()->isDebug()
            || !$container->hasParameter('debug.container.dump')
            || !file_exists($cachedFile = $container->getParameter('debug.container.dump'))
        ) {
            $this->containerBuilder = false;
            return;
        }

        $containerBuilder = new ContainerBuilder();

        $loader = new XmlFileLoader($containerBuilder, new FileLocator());
        $loader->load($cachedFile);

        $this->containerBuilder = $containerBuilder;
    }

    /**
     * Given an array of service IDs, this returns the array of corresponding
     * Definition and Alias objects that those ids represent.
     *
     * @param string $serviceId The service id to resolve
     *
     * @author Ryan Weaver <ryan@thatsquality.com>
     *
     * @return \Symfony\Component\DependencyInjection\Definition|\Symfony\Component\DependencyInjection\Alias
     */
    private function resolveServiceDefinition($serviceId)
    {
        if ($this->containerBuilder->hasDefinition($serviceId)) {
            return $this->containerBuilder->getDefinition($serviceId);
        }

        // Some service IDs don't have a Definition, they're simply an Alias
        if ($this->containerBuilder->hasAlias($serviceId)) {
            return $this->containerBuilder->getAlias($serviceId);
        }

        // the service has been injected in some special way, just return the service
        return $this->containerBuilder->get($serviceId);
    }
}