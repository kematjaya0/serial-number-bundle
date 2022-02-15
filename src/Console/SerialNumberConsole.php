<?php

namespace Kematjaya\SerialNumberBundle\Console;

use Kematjaya\SerialNumber\Builder\SerialNumberBuilderInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
/**
 * Description of SerialNumberConsole
 *
 * @author Nur Hidayatullah <kematjaya0@gmail.com>
 */
class SerialNumberConsole extends Command 
{
    
    protected static $defaultName = 'kmj:serial-number:generate';
    
    /**
     * 
     * @var SerialNumberBuilderInterface
     */
    private $serialNumberBuilder;
    
    function __construct(SerialNumberBuilderInterface $serialNumberBuilder, mixed $name = null) 
    {
        parent::__construct($name);
        $this->serialNumberBuilder = $serialNumberBuilder;
    }
    
    protected function configure()
    {
        $this
            ->setDescription('generate serial number.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $serialNumber = $this->serialNumberBuilder->generateSerialNumber();
        $output->writeln('serial number : ' . $serialNumber->getNumber());
        
        return self::SUCCESS;
    }
}
