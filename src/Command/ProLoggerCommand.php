<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Psr\Log\LoggerInterface;

/**
 * Class ProLoggerCommand
 * Used to extend/replace -v -vv -vvv with ETC and writing in different sections
 * @package App\Command
 */
class ProLoggerCommand extends Command
{

    /**
     * Estimated Time of Completion
     */
    const ETC = 0.2;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * ProLoggerCommand constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

        // you *must* call the parent constructor
        parent::__construct();
    }

    /**
     *  str, typ, lib input argument that are used
     */
    protected function configure(): void
    {
        $this->addArgument('str', InputArgument::REQUIRED)
            ->addArgument('typ', InputArgument::REQUIRED)
            ->addArgument('lib', InputArgument::OPTIONAL);
    }


    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // input string
        $str = $input->getArgument('str');
        // Debug, Info, Warning, Error
        $typ = $input->getArgument('typ');
        // e-mail, file system, server APIs
        $lib = $input->getArgument('lib');

        $process = new Process(['ls', '-lsa']);
        $process->setTimeout(ProLoggerCommand::ETC);
        $process->start();

        while ($process->isRunning()) {
            // waiting for process to finish
            switch ($typ) {
                case 1:
                    $this->logger->debug($str);
                    $this->logger->info($str);
                    $this->logger->critical($str);
                    $this->logger->error($str);
                    break;
                case 2:
                    $this->logger->info($str);
                    $this->logger->critical($str);
                    $this->logger->error($str);
                    break;
                case 3:
                    $this->logger->critical();
                    $this->logger->error($str);
                    break;
                case 4:
                    $this->logger->error($str);
                    break;
                default;

            }
        }


        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }

}
