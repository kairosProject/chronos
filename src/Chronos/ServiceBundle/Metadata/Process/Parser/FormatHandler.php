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
namespace Chronos\ServiceBundle\Metadata\Process\Parser;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;
use Chronos\ServiceBundle\Metadata\Process\Parser\Traits\FormatterSectionTrait;
use Chronos\ServiceBundle\Metadata\Process\Parser\Traits\ProviderSectionTrait;
use Chronos\ServiceBundle\Metadata\Process\Parser\Traits\DispatcherSectionTrait;
use Chronos\ServiceBundle\Metadata\Process\Parser\Traits\ControllerSectionTrait;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationPayloadInterface;

/**
 * Format handler
 *
 * This class is used as default representation of the FormatHandlerInterface. It act to validate and merge a set of
 * given data to normalized object
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FormatHandler implements FormatHandlerInterface
{
    use FormatterSectionTrait,
        ProviderSectionTrait,
        DispatcherSectionTrait,
        ControllerSectionTrait;

    /**
     * Listener validator
     *
     * Store the dispatcher listener validator
     *
     * @var ValidationManager
     */
    private $listenerValidator;

    /**
     * Construct
     *
     * The default FormatHanfler constructor
     *
     * @param ValidationManager $manager The validation manager for the dispatcher listener
     *
     * @return void
     */
    public function __construct(ValidationManager $manager)
    {
        $this->listenerValidator = $manager;
    }

    /**
     * Handle data
     *
     * Perform the data handling with all configuration without leading 'process' key. As it, a set of data without all
     * leading 'process' key are able to be given for parsing and validation.
     *
     * @param array                      $data    The data to handle
     * @param ValidationPayloadInterface $payload An optional validation payload
     *
     * @return array
     */
    public function handleData(array $data, ValidationPayloadInterface $payload = null) : array
    {
        $tree = $this->configureFormat()->buildTree();

        $currentConfig = [];
        foreach ($data as $config) {
            if ($payload) {
                $payload->setConfig($config);
            }

            $config = $tree->normalize($config);
            $currentConfig = $tree->merge($currentConfig, $config);
        }

        return $tree->finalize($currentConfig);
    }

    /**
     * Configure format
     *
     * Return an instance of TreeBuilder with the definition of the format already loaded
     *
     * @return TreeBuilder
     */
    private function configureFormat() : TreeBuilder
    {
        $builder = new TreeBuilder();
        $root = $builder->root('process');

        $root->useAttributeAsKey('name');

        $root->arrayPrototype()
            ->append($this->getFormatterSection())
            ->append($this->getProviderSection())
            ->append($this->getDispatcherSection())
            ->append($this->getControllerSection())
            ->end();

        return $builder;
    }
}
