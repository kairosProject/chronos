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

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * Controller section trait
 *
 * This trait is used to provide the controller section for FormatHandler
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait ControllerSectionTrait
{
    /**
     * Get controller section
     *
     * Return the tree branch for the controller section of the complete tree
     *
     * @return NodeDefinition
     */
    private function getControllerSection() : NodeDefinition
    {
        $builder = new TreeBuilder();
        $root = $builder->root('controller');

        $root->isRequired()
            ->children()
            ->scalarNode('service')->isRequired()->end()
            ->arrayNode('arguments')
            ->variablePrototype()
            ->end()
            ->end();

        return $root;
    }
}
