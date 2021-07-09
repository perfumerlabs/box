<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1622438347.
 * Generated on 2021-05-31 05:19:07 by root
 */
class PropelMigration_1622438347
{
    public $comment = '';

    public function preUp(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postUp(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    public function preDown(MigrationManager $manager)
    {
        // add the pre-migration code here
    }

    public function postDown(MigrationManager $manager)
    {
        // add the post-migration code here
    }

    /**
     * Get the SQL statements for the Up migration
     *
     * @return array list of the SQL strings to execute for the Up migration
     *               the keys being the datasources
     */
    public function getUpSQL()
    {
        return array (
  'box' => '
BEGIN;

ALTER TABLE "box_client"

  ADD "description" VARCHAR(255);

ALTER TABLE "box_client" ADD CONSTRAINT "box_client_u_d94269" UNIQUE ("name");

ALTER TABLE "box_collection"

  ADD "description" VARCHAR(255);

COMMIT;
',
);
    }

    /**
     * Get the SQL statements for the Down migration
     *
     * @return array list of the SQL strings to execute for the Down migration
     *               the keys being the datasources
     */
    public function getDownSQL()
    {
        return array (
  'box' => '
BEGIN;

ALTER TABLE "box_client" DROP CONSTRAINT "box_client_u_d94269";

ALTER TABLE "box_client"

  DROP COLUMN "description";

ALTER TABLE "box_collection"

  DROP COLUMN "description";

COMMIT;
',
);
    }

}