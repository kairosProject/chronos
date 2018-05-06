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
 * @category Bundle
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ServiceBundle\Metadata\Process\Parser;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Loader\PHPLoader;
use Chronos\ServiceBundle\Metadata\Process\Parser\Loader\YamlLoader;
use Symfony\Component\Yaml\Yaml;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationPayload;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\Factory\HandlerManagerFactory;
use Chronos\ServiceBundle\Metadata\Process\Parser\Builder\Factory\BuilderFactory;

/**
 * Yaml file parser
 *
 * This class is used to load metadatas from file list
 *
 * @category Bundle
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class YamlFileLoader
{
    /**
     * Yaml loader
     *
     * The yaml file loader instance
     *
     * @var YamlLoader
     */
    private $yamlLoader;

    /**
     * Payload
     *
     * The payload validation
     *
     * @var ValidationPayload
     */
    private $payload;

    /**
     * Builder factory
     *
     * The metadata builder factory
     *
     * @var BuilderFactory
     */
    private $builderFactory;

    /**
     * Format handler
     *
     * The metadata format handler
     *
     * @var FormatHandler
     */
    private $formatHandler;

    /**
     * Get YamlLoader
     *
     * Return an instance of YamlLoader
     *
     * @return YamlLoader
     */
    protected function getYamlLoader() : YamlLoader
    {
        if (!$this->yamlLoader) {
            $phpLoader = new PHPLoader();
            return new YamlLoader($phpLoader, new Yaml(), Yaml::PARSE_CONSTANT);
        }

        return $this->yamlLoader;
    }

    /**
     * Get payload
     *
     * Return a ValidationPayload instance
     *
     * @return ValidationPayload
     */
    protected function getPayload() : ValidationPayload
    {
        if (!$this->payload) {
            $this->payload = new ValidationPayload();
        }

        return $this->payload;
    }

    /**
     * Get BuilderFactory
     *
     * Return an instance of BuilderFactory
     *
     * @return BuilderFactory
     */
    protected function getBuilderFactory() : BuilderFactory
    {
        if (!$this->builderFactory) {
            return new BuilderFactory();
        }

        return $this->builderFactory;
    }

    /**
     * Get FormatHandler
     *
     * Return an instance of FormatHandler
     *
     * @param ContainerBuilder $container The application container
     *
     * @return FormatHandler
     */
    protected function getFormatHandler(ContainerBuilder $container) : FormatHandler
    {
        if (!$this->formatHandler) {
            $managerFactory = new HandlerManagerFactory();
            return new FormatHandler($managerFactory->getManager($this->getPayload(), $container));
        }

        return $this->formatHandler;
    }

    /**
     * Set YamlLoader
     *
     * Set the YamlLoader instance
     *
     * @param YamlLoader $yamlLoader The yaml loader instance
     *
     * @return $this
     */
    public function setYamlLoader(YamlLoader $yamlLoader) : self
    {
        $this->yamlLoader = $yamlLoader;

        return $this;
    }

    /**
     * Set Payload
     *
     * Set the ValidationPayload instance
     *
     * @param ValidationPayload $payload the ValidationPayload instance
     *
     * @return $this
     */
    public function setPayload(ValidationPayload $payload) : self
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Set BuilderFactory
     *
     * Set the BuilderFactory instance
     *
     * @param BuilderFactory $builderFactory The BuilderFactory instance
     *
     * @return $this
     */
    public function setBuilderFactory(BuilderFactory $builderFactory) : self
    {
        $this->builderFactory = $builderFactory;

        return $this;
    }

    /**
     * Set FormatHandler
     *
     * Set the FormatHandler instance
     *
     * @param FormatHandler $formatHandler The FormatHandler instance
     *
     * @return $this
     */
    public function setFormatHandler(FormatHandler $formatHandler) : self
    {
        $this->formatHandler = $formatHandler;

        return $this;
    }

    /**
     * Get metadatas
     *
     * Process the definition files to metadatas
     *
     * @param array            $files     The files to process
     * @param ContainerBuilder $container The application container
     *
     * @return mixed
     */
    public function getMetadatas(array $files, ContainerBuilder $container)
    {
        $yamlLoader = $this->getYamlLoader();

        foreach ($files as $file) {
            if ($yamlLoader->support($file)) {
                $yamlLoader->addMetadata($file);
            }
        }

        $data = $yamlLoader->load();

        $metadatas = $this->getFormatHandler($container)->handleData($data, $this->getPayload());

        $builder = $this->getBuilderFactory()->getBuilder();

        return $builder->buildFromData($metadatas);
    }
}
