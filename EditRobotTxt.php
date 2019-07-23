<?php
/*************************************************************************************/
/*      This file is part of the Thelia package.                                     */
/*                                                                                   */
/*      Copyright (c) OpenStudio                                                     */
/*      email : dev@thelia.net                                                       */
/*      web : http://www.thelia.net                                                  */
/*                                                                                   */
/*      For the full copyright and license information, please view the LICENSE.txt  */
/*      file that was distributed with this source code.                             */
/*************************************************************************************/

namespace EditRobotTxt;

use EditRobotTxt\Model\Robots;
use EditRobotTxt\Model\RobotsQuery;
use Propel\Runtime\Connection\ConnectionInterface;
use Thelia\Install\Database;
use Thelia\Model\LangQuery;
use Thelia\Module\BaseModule;

class EditRobotTxt extends BaseModule
{
    /** @var string */
    const DOMAIN_NAME = 'editrobottxt';

    /**
     * @param ConnectionInterface|null $con
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function postActivation(ConnectionInterface $con = null)
    {
        try {
            RobotsQuery::create()->findOne();
        }catch (\Exception $e){
            $database = new Database($con);
            $database->insertSql(null, [__DIR__ . "/Config/thelia.sql"]);

            $file = 'robots.txt';
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
                    $domain = $_SERVER['HTTP_HOST'];
                }
                $newRobots = new Robots();
                $newRobots
                    ->setDomainName($domain)
                    ->setRobotsContent($current)
                    ->save();
            }
        }
    }
}
