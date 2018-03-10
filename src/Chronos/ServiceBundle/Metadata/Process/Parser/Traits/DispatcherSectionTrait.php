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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Traits;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Chronos\ServiceBundle\Metadata\Process\Parser\Validator\ValidationManager;

/**
 * Dispatcher section trait
 *
 * This trait is used to provide the dispatcher section for FormatHandler
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait DispatcherSectionTrait
{
    /**
     * Listener validator
     *
     * Store the dispatcher listener validator
     *
     * @var ValidationManager
     */
    private $listenerValidator;

    /**
     * Get dispatcher section
     *
     * Return the tree branch for the dispatcher section of the complete tree
     *
     * @return NodeDefinition
     */
    private function getDispatcherSection() : NodeDefinition
    {
        $builder = new TreeBuilder();
        $root = $builder->root('dispatcher');

        $validationListener = \Closure::fromCallable([$this->listenerValidator, 'isValid']);

        $root->arrayPrototype()
            ->children()
            ->scalarNode('event')->isRequired()->end()
            ->arrayNode('listeners')
            ->isRequired()
            ->variablePrototype()
            ->validate()
            ->ifTrue($validationListener)
            ->thenInvalid($this->getDispatcherError())
            ->end()
            ->beforeNormalization()->castToArray()->end()
            ->end()
            ->end()
            ->end()
            ->end();

        return $root;
    }

    /**
     * Get dispatcher error
     *
     * Return the dispatcher listener error message
     *
     * @return string
     */
    private function getDispatcherError() : string
    {
        return 'Listener must be a valid callback, EventSubscriber or service and may have priority';
    }
}
