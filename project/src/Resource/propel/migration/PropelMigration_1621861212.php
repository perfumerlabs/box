<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1621861212.
 * Generated on 2021-05-24 13:00:12 by root
 */
class PropelMigration_1621861212
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

DROP INDEX "box_document_log_i_9a6e52";

ALTER TABLE "box_document_log" RENAME COLUMN "requested_at" TO "provider_requested_at";

ALTER TABLE "box_document_log"

  ADD "provider_respond_at" TIMESTAMP,

  ADD "webhook_requested_at" TIMESTAMP;

CREATE INDEX "box_document_log_i_aad0fe" ON "box_document_log" ("provider_requested_at");

CREATE INDEX "box_document_log_i_1c2642" ON "box_document_log" ("webhook_requested_at");

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

DROP INDEX "box_document_log_i_aad0fe";

DROP INDEX "box_document_log_i_1c2642";

ALTER TABLE "box_document_log" RENAME COLUMN "provider_requested_at" TO "requested_at";

ALTER TABLE "box_document_log"

  DROP COLUMN "provider_respond_at",

  DROP COLUMN "webhook_requested_at";

CREATE INDEX "box_document_log_i_9a6e52" ON "box_document_log" ("requested_at");

COMMIT;
',
);
    }

}