<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1621588200.
 * Generated on 2021-05-21 15:10:00 by root
 */
class PropelMigration_1621588200
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

ALTER TABLE "box_access"

  ADD "updated_at" TIMESTAMP;

ALTER TABLE "box_client"

  ADD "updated_at" TIMESTAMP;

ALTER TABLE "box_collection"

  ADD "type" INT2 DEFAULT 0 NOT NULL,

  ADD "handler" VARCHAR(255),

  ADD "updated_at" TIMESTAMP;

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

ALTER TABLE "box_access"

  DROP COLUMN "updated_at";

ALTER TABLE "box_client"

  DROP COLUMN "updated_at";

ALTER TABLE "box_collection"

  DROP COLUMN "type",

  DROP COLUMN "handler",

  DROP COLUMN "updated_at";

COMMIT;
',
);
    }

}