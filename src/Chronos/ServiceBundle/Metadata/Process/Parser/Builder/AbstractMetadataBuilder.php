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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Builder;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Abstract metadata builder
 *
 * This class is used as placeholder for option resolver instanciation
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
abstract class AbstractMetadataBuilder implements MetadataBuilderInterface
{
    /**
     * Resolver
     *
     * The OptionsResolver to use at metadata resolution time
     *
     * @var OptionsResolver
     */
    protected $resolver;

    /**
     * Construct
     *
     * The default MetadataBuilder constructor
     *
     * @param OptionsResolver $resolver [optional] The OptionsResolver to use. If none, new one will be instanciated
     *
     * @return void
     */
    public function __construct(OptionsResolver $resolver = null)
    {
        if (!$resolver) {
            $resolver = new OptionsResolver();
        }

        $this->configureOptions($resolver);
        $this->resolver = $resolver;
    }

    /**
     * Configure options
     *
     * Configure the option resolver to lock the expected arguments
     *
     * @param OptionsResolver $resolver The OptionsResolver instance to configure
     *
     * @return void
     */
    abstract protected function configureOptions(OptionsResolver $resolver) : void;
}
