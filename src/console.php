<?php

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

$console = new Application('My Silex Application', 'n/a');
$console
->register('twig:cache:delete')
->setDefinition(array(
        // new InputOption('some-option', null, InputOption::VALUE_NONE, 'Some help'),
    ))
->setDescription('Delete twig cache files')
->setCode(function (InputInterface $input, OutputInterface $output) use ($app) {
        $cachePath = $app["twig.options"]["cache"];
        $dir = new \DirectoryIterator($cachePath);
        foreach($dir as $file){
            if($file->isDot())continue;
            exec("rm -rf ".$file->getRealPath());
        }
        $output->writeln("$cachePath is now empty.");
})
;


// Configure Doctrine ORM tool for Console cli
use Symfony\Component\Console\Helper\HelperSet;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
$em = $app["em"];
$console->setHelperSet(new HelperSet(array(
    "em" => new EntityManagerHelper($em),
    "db" => new ConnectionHelper($em->getConnection()),
    )
)
);
Doctrine\ORM\Tools\Console\ConsoleRunner::addCommands($console);

return $console;
