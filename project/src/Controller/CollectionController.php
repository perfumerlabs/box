<?php

namespace Box\Controller;

use Box\Model\Coll;
use Box\Service\Database;

class CollectionController extends LayoutController
{
    public function post()
    {
        $this->assertAdmin();

        $name = $this->f('name');

        $this->validateNotEmpty($name, 'name');
        $this->validateRegex($name, 'name', '/^[a-z0-9_]+$/');

        /** @var Database $database */
        $database = $this->s('database');

        $con = $database->getPdo();
        $con->beginTransaction();

        try {
            $created = $database->createTable($name);

            if ($created) {
                $coll = new Coll();
                $coll->setName($name);
                $coll->save();
            }

            $con->commit();
        } catch (\Throwable $e) {
            $con->rollBack();
        }
    }
}
