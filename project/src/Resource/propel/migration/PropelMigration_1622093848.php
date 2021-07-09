<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1622093848.
 * Generated on 2021-05-27 05:37:28 by root
 */
class PropelMigration_1622093848
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

  ADD "is_disabled" BOOLEAN DEFAULT \'f\' NOT NULL;

ALTER TABLE "box_collection"

  ADD "is_disabled" BOOLEAN DEFAULT \'f\' NOT NULL;

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

ALTER TABLE "box_client"

  DROP COLUMN "is_disabled";

ALTER TABLE "box_collection"

  DROP COLUMN "is_disabled";

COMMIT;
',
);
    }

}