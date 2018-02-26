<?php
declare(strict_types=1);
/**
 * This file is part of the chronos project.
 *
 * As each files provides by the CSCFA, this file is licensed
 * under the MIT license.
 *
 * PHP version 5.6
 *
 * @category Formatter
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\Formatter\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Psr\Log\LoggerInterface;
use Monolog\Logger;

/**
 * Json response factory
 *
 * This class is used to generate a new JsonResponse instance
 *
 * @category Formatter
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class JsonResponseFactory implements ResponseFactoryInterface
{
    /**
     * Logger
     *
     * The application logger
     *
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Construct
     *
     * The default JsonResponseFactory constructor
     *
     * @param LoggerInterface $logger The application logger
     *
     * @return void
     */
    public function __construct(LoggerInterface $logger)
    {
        if ($logger instanceof Logger) {
            $logger = $logger->withName('JSON.RESPONSE_FACTORY');
        }
        $this->logger = $logger;
    }

    /**
     * Create response
     *
     * This method create and return a response instance
     *
     * @param array $context The creation context
     *
     * @return JsonResponse
     */
    public function createResponse(array $context) : Response
    {
        $options = $this->getResolver()->resolve($context);
        $this->logger->debug('rendering response', ['options' => $options]);

        return new JsonResponse($options['data'], $options['status'], $options['headers'], $options['isJson']);
    }

    /**
     * Get resolver
     *
     * Return a configured instance of option resolver
     *
     * @return OptionsResolver
     */
    private function getResolver() : OptionsResolver
    {
        $resolver = new OptionsResolver();
        $this->configureResolver($resolver);
        return $resolver;
    }

    /**
     * Configure resolver
     *
     * Configure the option resolver
     *
     * @param OptionsResolver $resolver The option resolver to configure
     *
     * @return void
     */
    private function configureResolver(OptionsResolver $resolver) : void
    {
        $resolver->setRequired(['data']);
        $resolver->setDefault('status', 200);
        $resolver->setDefault('headers', []);
        $resolver->setDefault('isJson', false);

        $resolver->setAllowedTypes('status', 'int');
        $resolver->setAllowedTypes('headers', 'array');
        $resolver->setAllowedTypes('isJson', 'bool');
        return;
    }
}

