<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1604655308.
 * Generated on 2020-11-06 09:35:08 by box
 */
class PropelMigration_1604655308
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

CREATE TABLE "box_client"
(
    "id" serial NOT NULL,
    "name" VARCHAR(255),
    "secret" VARCHAR(255),
    "is_admin" BOOLEAN DEFAULT \'f\' NOT NULL,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id"),
    CONSTRAINT "box_client_u_998256" UNIQUE ("secret")
);

CREATE TABLE "box_access"
(
    "id" serial NOT NULL,
    "collection_id" INTEGER NOT NULL,
    "client_id" INTEGER NOT NULL,
    "level" INT2 NOT NULL,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id")
);

CREATE TABLE "box_collection"
(
    "id" serial NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id"),
    CONSTRAINT "box_collection_u_d94269" UNIQUE ("name")
);

ALTER TABLE "box_access" ADD CONSTRAINT "box_access_fk_455815"
    FOREIGN KEY ("client_id")
    REFERENCES "box_client" ("id");

ALTER TABLE "box_access" ADD CONSTRAINT "box_access_fk_08edab"
    FOREIGN KEY ("collection_id")
    REFERENCES "box_collection" ("id");

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

DROP TABLE IF EXISTS "box_client" CASCADE;

DROP TABLE IF EXISTS "box_access" CASCADE;

DROP TABLE IF EXISTS "box_collection" CASCADE;

COMMIT;
',
        );
    }

}