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
 * @category Command
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
namespace Chronos\ApiBundle\Command;

use Symfony\Component\Console\Command\Command;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Config\FileLocator;
use Doctrine\Common\DataFixtures\Purger\MongoDBPurger;
use Doctrine\Common\DataFixtures\Executor\MongoDBExecutor;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;

/**
 * Fixture loader command
 *
 * This command is used to load the data fixtures of the application
 *
 * @category Command
 * @package  Chronos
 * @author   matthieu vallance <matthieu.vallance@cscfa.fr>
 * @license  MIT <https://opensource.org/licenses/MIT>
 * @link     http://cscfa.fr
 */
class FixtureLoaderCommand extends Command
{
    /**
     * Object manager
     *
     * The application object manager
     *
     * @var ObjectManager
     */
    private $dbExecutor;

    /**
     * File locator
     *
     * The application file locator
     *
     * @var FileLocator
     */
    private $fileLocator;

    /**
     * Loader
     *
     * The fixture loader instance
     *
     * @var Loader
     */
    private $loader;

    /**
     * Bundle list
     *
     * The application bundle list
     *
     * @var array
     */
    private $bundleList;

    /**
     * Construct
     *
     * The default FixtureLoaderCommand construct
     *
     * @param MongoDBExecutor $executor    The mongoDB fixture executor
     * @param Loader          $loader      The fixture loader
     * @param FileLocator     $fileLoactor The application file locator
     * @param array           $bundles     The application bundle list
     *
     * @return void
     */
    public function __construct(MongoDBExecutor $executor, Loader $loader, FileLocator $fileLoactor, array $bundles)
    {
        $this->dbExecutor = $executor;
        $this->fileLocator = $fileLoactor;
        $this->loader = $loader;
        $this->bundleList = array_keys($bundles);

        parent::__construct();
    }

    /**
     * Configure
     *
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('app:fixture:load')
            ->setDescription('Load the application fixtures')
            ->setHelp('This command load the application fixtures')
            ->setHidden(false)
            ->addOption('dry-run', 'd', InputOption::VALUE_NONE, 'Display the available fixtures');
    }

    /**
     * Executes the current command.
     *
     * This method is not abstract because you can use this class
     * as a concrete class. In this case, instead of defining the
     * execute() method, you set the code to execute by passing
     * a Closure to the setCode() method.
     *
     * @param InputInterface  $input  The command input
     * @param OutputInterface $output The command output
     *
     * @return null|int null or 0 if everything went fine, or an error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->bundleList as $bundleName) {
            $directoryLocator = sprintf('@%s/Resources/Fixtures', $bundleName);

            try {
                $this->loader->loadFromDirectory(
                    $this->fileLocator->locate($directoryLocator)
                );

                if ($input->getOption('dry-run') || $output->isVerbose()) {
                    $output->writeln(sprintf('<info>Load fixture %s</info>', $directoryLocator));
                }
            } catch (\InvalidArgumentException $exception) {
                if ($output->isVeryVerbose()) {
                    $output->writeln(sprintf('<info>No fixture in %s</info>', $bundleName));
                }
            }
        }

        if (!$input->getOption('dry-run')) {
            if ($output->isVerbose()) {
                $output->writeln('<info>Executing fixtures</info>');
            }

            $this->dbExecutor->execute($this->loader->getFixtures());
        }
    }
}
