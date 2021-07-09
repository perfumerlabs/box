<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1621858132.
 * Generated on 2021-05-24 12:08:52 by root
 */
class PropelMigration_1621858132
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

CREATE INDEX "box_document_log_i_9a6e52" ON "box_document_log" ("requested_at");

ALTER TABLE "box_provider_log"

  ADD "response_error" TEXT;

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

DROP INDEX "box_document_log_i_9a6e52";

ALTER TABLE "box_provider_log"

  DROP COLUMN "response_error";

COMMIT;
',
);
    }

}