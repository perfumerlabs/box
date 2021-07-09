<?php

namespace Box\Command;

use Perfumer\Framework\Controller\PlainController;
use Perfumer\Framework\Router\ConsoleRouterControllerHelpers;

class InitCommand extends PlainController
{
    use ConsoleRouterControllerHelpers;

    public function action()
    {
        $host = $this->o('host');
        $username = $this->o('username');
        $password = $this->o('password');
        $database = $this->o('database');

        $dbh = new \PDO("pgsql:host=$host", $username, $password);

        $dbh->exec("CREATE DATABASE \"$database\";");
    }
}
