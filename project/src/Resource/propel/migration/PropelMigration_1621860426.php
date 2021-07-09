<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1621860426.
 * Generated on 2021-05-24 12:47:06 by root
 */
class PropelMigration_1621860426
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

DROP TABLE IF EXISTS "box_provider_log" CASCADE;

CREATE TABLE "box_request_log"
(
    "id" bigserial NOT NULL,
    "document_log_id" INT8 NOT NULL,
    "type" INT2 NOT NULL,
    "request_url" VARCHAR(255),
    "request_method" VARCHAR(255),
    "request_headers" TEXT,
    "request_body" TEXT,
    "response_status_code" INTEGER,
    "response_headers" TEXT,
    "response_body" TEXT,
    "response_error" TEXT,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id")
);

CREATE INDEX "box_request_log_i_5acaf5" ON "box_request_log" ("document_log_id");

ALTER TABLE "box_request_log" ADD CONSTRAINT "box_request_log_fk_73f605"
    FOREIGN KEY ("document_log_id")
    REFERENCES "box_document_log" ("id")
    ON DELETE CASCADE;

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

DROP TABLE IF EXISTS "box_request_log" CASCADE;

CREATE TABLE "box_provider_log"
(
    "id" bigserial NOT NULL,
    "document_log_id" INT8 NOT NULL,
    "request_url" VARCHAR(255),
    "request_method" VARCHAR(255),
    "request_headers" TEXT,
    "request_body" TEXT,
    "response_status_code" INTEGER,
    "response_headers" TEXT,
    "response_body" TEXT,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    "response_error" TEXT,
    PRIMARY KEY ("id")
);

CREATE INDEX "box_provider_log_i_5acaf5" ON "box_provider_log" ("document_log_id");

ALTER TABLE "box_provider_log" ADD CONSTRAINT "box_provider_log_fk_73f605"
    FOREIGN KEY ("document_log_id")
    REFERENCES "box_document_log" ("id")
    ON DELETE CASCADE;

COMMIT;
',
);
    }

}