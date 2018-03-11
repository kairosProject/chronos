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
namespace Chronos\ServiceBundle\Metadata\Process\Parser\Loader;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

/**
 * Yaml loader
 *
 * This class is used as metadata loader for yaml serialized file
 *
 * @category Metadata
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class YamlLoader implements MetadataLoaderInterface, MetadataAggregatorInterface, MetadataSupportInterface
{
    use MetadataAggregatorTrait;

    /**
     * Yaml
     *
     * A YAML file parser
     *
     * @var Yaml
     */
    private $yaml;

    /**
     * Loader
     *
     * A native PHP metadata loader
     *
     * @var PHPLoader
     */
    private $loader;

    /**
     * Construct
     *
     * The default YamlLoader constructor
     *
     * @param PHPLoader $loader A native PHP metadata loader
     * @param Yaml      $yaml   A YAML file parser
     *
     * @return void
     */
    public function __construct(PHPLoader $loader, Yaml $yaml)
    {
        $this->loader = $loader;
        $this->yaml = $yaml;
    }

    /**
     * Load
     *
     * Load the data from source data
     *
     * @param mixed|null $data The source data
     *
     * @return array
     */
    public function load($data = null) : array
    {
        if ($data) {
            $this->addMetadata($data);
        }

        $contents = $this->loadFileContents();
        foreach ($contents as $content) {
            $this->loader->addMetadata($content);
        }

        return $this->loader->load();
    }

    /**
     * Support
     *
     * Indicate if the instance support the given metadata
     *
     * @param mixed $data The data to be supported
     *
     * @return bool
     */
    public function support($data) : bool
    {
        if (is_string($data) && file_exists($data)) {
            try {
                return $this->loader->support($this->yaml->parseFile($data));
            } catch (ParseException $e) {
                return false;
            }
        }

        return false;
    }

    /**
     * Load file contents
     *
     * Yield each file contents
     *
     * @return \Generator
     */
    private function loadFileContents()
    {
        foreach ($this->data as $filename) {
            yield $this->yaml->parseFile($filename);
        }
    }
}
