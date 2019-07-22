<?php
/**
 * Created by PhpStorm.
 * User: nicolasbarbey
 * Date: 19/07/2019
 * Time: 15:37
 */

namespace EditRobotTxt\Command;


use EditRobotTxt\Form\EditForm;
use EditRobotTxt\Model\Robots;
use Propel\Runtime\Propel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Thelia\Command\ContainerAwareCommand;
use Thelia\Model\LangQuery;
use Thelia\Model\Map\OrderTableMap;

class InitDbCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName("EditRobotTxt:init:db")
            ->setDescription("Initialize robots database.");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = 'web/robos.txt';
        if (file_exists($file)){
            $current = file_get_contents($file);
        }else{
            $current = "";
        }

        $langQuery = LangQuery::create();

        $langQuery
            ->select(['url'])
            ->setDistinct()
            ->findByActive(true);

        foreach ($langQuery->find() as $domain){
            if ("" === $domain){
                $output->writeln(sprintf('<error>There is no url in lang table</error>'));
                break;
            }
            $output->writeln(sprintf('<info>Add : '.$domain. '</info>'));
            $newRobots = new Robots();
            $newRobots
                ->setDomainName($domain)
                ->setRobotsContent($current)
                ->save();
        }
        $output->writeln(sprintf("<info>End</info>"));
    }


}