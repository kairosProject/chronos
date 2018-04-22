<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 7.2
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Metadata\Process\Builder;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\ProviderMetadataInterface;
use Symfony\Component\DependencyInjection\Definition;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\DependencyInjection\Reference;
use Chronos\ServiceBundle\Metadata\Process\Builder\Traits\ServiceNameTrait;
use Chronos\ApiBundle\Provider\GenericDocumentProvider;
use Chronos\ServiceBundle\Metadata\Process\Builder\Bag\ProcessBuilderBagInterface;

/**
 * Provider service builder
 *
 * This class is the default implementation of ProviderServiceBuilderInterface
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class ProviderServiceBuilder implements ProviderServiceBuilderInterface
{
    use ServiceNameTrait;

    /**
     * Service name
     *
     * The default service name to be used at definition registration time
     *
     * @var string
     */
    private const SERVICE_NAME = 'provider';

    /**
     * Construct
     *
     * The default ProviderServiceBuilder constructor
     *
     * @param string $serviceName The original process service name
     *
     * @return void
     */
    public function __construct(
        string $serviceName = self::SERVICE_NAME
    ) {
        $this->serviceName = $serviceName;
    }

    /**
     * Build process service
     *
     * Inject services according to metadata into the container
     *
     * @param ContainerBuilder           $container  The application container builder
     * @param ProviderMetadataInterface  $metadata   The provider metadata
     * @param ProcessBuilderBagInterface $processBag A process builder bag
     *
     * @return void
     */
    public function buildProcessServices(
        ContainerBuilder $container,
        ProviderMetadataInterface $metadata,
        ProcessBuilderBagInterface $processBag
    ) : void {
        $repository = new Definition(DocumentRepository::class);
        $repository->setFactory(
            [
                    new Reference($metadata->getFactory()),
                    'getRepository'
                ]
        )->addArgument($metadata->getEntity());

        $processName = $processBag->getProcessName();
        $repositoryName = $this->buildServiceName(sprintf('%s_repository', $processName));

        $container->setDefinition($repositoryName, $repository);

        $provider = new Definition(GenericDocumentProvider::class);
        $provider->addArgument(new Reference($repositoryName))
            ->addArgument(new Reference('logger'));

        $providerName = $this->buildServiceName($processName);

        $container->setDefinition($providerName, $provider);
    }
}
