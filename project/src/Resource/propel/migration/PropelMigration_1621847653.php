<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1621847653.
 * Generated on 2021-05-24 09:14:13 by root
 */
class PropelMigration_1621847653
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

CREATE TABLE "box_document_log"
(
    "id" bigserial NOT NULL,
    "collection_id" INTEGER NOT NULL,
    "client_id" INTEGER NOT NULL,
    "document_id" INT8 NOT NULL,
    "uuid" VARCHAR(255) NOT NULL,
    "event" VARCHAR(255) NOT NULL,
    "status" INT2 NOT NULL,
    "created_at" TIMESTAMP,
    "updated_at" TIMESTAMP,
    PRIMARY KEY ("id")
);

CREATE INDEX "box_document_log_i_228481" ON "box_document_log" ("collection_id");

CREATE INDEX "box_document_log_i_0c2750" ON "box_document_log" ("client_id");

CREATE INDEX "box_document_log_i_36c49e" ON "box_document_log" ("uuid");

CREATE INDEX "box_document_log_i_7db7d8" ON "box_document_log" ("event");

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
    PRIMARY KEY ("id")
);

CREATE INDEX "box_provider_log_i_5acaf5" ON "box_provider_log" ("document_log_id");

ALTER TABLE "box_document_log" ADD CONSTRAINT "box_document_log_fk_455815"
    FOREIGN KEY ("client_id")
    REFERENCES "box_client" ("id");

ALTER TABLE "box_document_log" ADD CONSTRAINT "box_document_log_fk_08edab"
    FOREIGN KEY ("collection_id")
    REFERENCES "box_collection" ("id");

ALTER TABLE "box_provider_log" ADD CONSTRAINT "box_provider_log_fk_73f605"
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

DROP TABLE IF EXISTS "box_document_log" CASCADE;

DROP TABLE IF EXISTS "box_provider_log" CASCADE;

COMMIT;
',
);
    }

}