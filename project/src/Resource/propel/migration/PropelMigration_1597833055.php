<?php

use Propel\Generator\Manager\MigrationManager;

/**
 * Data object containing the SQL and PHP code to migrate the database
 * up to version 1597833055.
 * Generated on 2020-08-19 16:30:55 by root
 */
class PropelMigration_1597833055
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

CREATE TABLE "_client"
(
    "id" serial NOT NULL,
    "name" VARCHAR(255),
    "secret" VARCHAR(255),
    "is_admin" BOOLEAN DEFAULT \'f\' NOT NULL,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id"),
    CONSTRAINT "_client_u_998256" UNIQUE ("secret")
);

CREATE TABLE "_access"
(
    "id" serial NOT NULL,
    "collection_id" INTEGER NOT NULL,
    "client_id" INTEGER NOT NULL,
    "level" INT2 NOT NULL,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id")
);

CREATE TABLE "_collection"
(
    "id" serial NOT NULL,
    "name" VARCHAR(255) NOT NULL,
    "created_at" TIMESTAMP,
    PRIMARY KEY ("id"),
    CONSTRAINT "_collection_u_d94269" UNIQUE ("name")
);

ALTER TABLE "_access" ADD CONSTRAINT "_access_fk_c8e74e"
    FOREIGN KEY ("client_id")
    REFERENCES "_client" ("id");

ALTER TABLE "_access" ADD CONSTRAINT "_access_fk_efa6cb"
    FOREIGN KEY ("collection_id")
    REFERENCES "_collection" ("id");

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

DROP TABLE IF EXISTS "_client" CASCADE;

DROP TABLE IF EXISTS "_access" CASCADE;

DROP TABLE IF EXISTS "_collection" CASCADE;

COMMIT;
',
);
    }

}