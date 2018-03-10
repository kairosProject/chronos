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
 * Formatter section trait
 *
 * This trait is used to provide the format section for FormatHandler
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
trait FormatterSectionTrait
{
    /**
     * Get formatter section
     *
     * Return the tree branch for the formatter section of the complete tree
     *
     * @return NodeDefinition
     */
    private function getFormatterSection() : NodeDefinition
    {
        $builder = new TreeBuilder();
        $root = $builder->root('formatter');
        $root->isRequired();

        $root->children()
            ->scalarNode('format')->isRequired()->end()
            ->scalarNode('response')->isRequired()->end()
            ->arrayNode('context')
            ->variablePrototype()->end()
            ->end()
            ->arrayNode('serializer')
            ->children()
            ->arrayNode('converter')
            ->variablePrototype()
            ->end()
            ->end()
            ->arrayNode('context')
            ->variablePrototype()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();

        return $root;
    }
}
