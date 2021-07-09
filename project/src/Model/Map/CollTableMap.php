<?php

namespace Box\Model\Map;

use Box\Model\Coll;
use Box\Model\CollQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'box_collection' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class CollTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.CollTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'box';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'box_collection';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Box\\Model\\Coll';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Coll';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'box_collection.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'box_collection.name';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'box_collection.description';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'box_collection.type';

    /**
     * the column name for the handler field
     */
    const COL_HANDLER = 'box_collection.handler';

    /**
     * the column name for the is_disabled field
     */
    const COL_IS_DISABLED = 'box_collection.is_disabled';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'box_collection.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'box_collection.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the type field */
    const COL_TYPE_STORAGE = 'storage';
    const COL_TYPE_SYNC = 'sync';
    const COL_TYPE_ASYNC = 'async';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Description', 'Type', 'Handler', 'IsDisabled', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'description', 'type', 'handler', 'isDisabled', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(CollTableMap::COL_ID, CollTableMap::COL_NAME, CollTableMap::COL_DESCRIPTION, CollTableMap::COL_TYPE, CollTableMap::COL_HANDLER, CollTableMap::COL_IS_DISABLED, CollTableMap::COL_CREATED_AT, CollTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'description', 'type', 'handler', 'is_disabled', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Description' => 2, 'Type' => 3, 'Handler' => 4, 'IsDisabled' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'description' => 2, 'type' => 3, 'handler' => 4, 'isDisabled' => 5, 'createdAt' => 6, 'updatedAt' => 7, ),
        self::TYPE_COLNAME       => array(CollTableMap::COL_ID => 0, CollTableMap::COL_NAME => 1, CollTableMap::COL_DESCRIPTION => 2, CollTableMap::COL_TYPE => 3, CollTableMap::COL_HANDLER => 4, CollTableMap::COL_IS_DISABLED => 5, CollTableMap::COL_CREATED_AT => 6, CollTableMap::COL_UPDATED_AT => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'description' => 2, 'type' => 3, 'handler' => 4, 'is_disabled' => 5, 'created_at' => 6, 'updated_at' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [

        'Id' => 'ID',
        'Coll.Id' => 'ID',
        'id' => 'ID',
        'coll.id' => 'ID',
        'CollTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'id' => 'ID',
        'box_collection.id' => 'ID',
        'Name' => 'NAME',
        'Coll.Name' => 'NAME',
        'name' => 'NAME',
        'coll.name' => 'NAME',
        'CollTableMap::COL_NAME' => 'NAME',
        'COL_NAME' => 'NAME',
        'name' => 'NAME',
        'box_collection.name' => 'NAME',
        'Description' => 'DESCRIPTION',
        'Coll.Description' => 'DESCRIPTION',
        'description' => 'DESCRIPTION',
        'coll.description' => 'DESCRIPTION',
        'CollTableMap::COL_DESCRIPTION' => 'DESCRIPTION',
        'COL_DESCRIPTION' => 'DESCRIPTION',
        'description' => 'DESCRIPTION',
        'box_collection.description' => 'DESCRIPTION',
        'Type' => 'TYPE',
        'Coll.Type' => 'TYPE',
        'type' => 'TYPE',
        'coll.type' => 'TYPE',
        'CollTableMap::COL_TYPE' => 'TYPE',
        'COL_TYPE' => 'TYPE',
        'type' => 'TYPE',
        'box_collection.type' => 'TYPE',
        'Handler' => 'HANDLER',
        'Coll.Handler' => 'HANDLER',
        'handler' => 'HANDLER',
        'coll.handler' => 'HANDLER',
        'CollTableMap::COL_HANDLER' => 'HANDLER',
        'COL_HANDLER' => 'HANDLER',
        'handler' => 'HANDLER',
        'box_collection.handler' => 'HANDLER',
        'IsDisabled' => 'IS_DISABLED',
        'Coll.IsDisabled' => 'IS_DISABLED',
        'isDisabled' => 'IS_DISABLED',
        'coll.isDisabled' => 'IS_DISABLED',
        'CollTableMap::COL_IS_DISABLED' => 'IS_DISABLED',
        'COL_IS_DISABLED' => 'IS_DISABLED',
        'is_disabled' => 'IS_DISABLED',
        'box_collection.is_disabled' => 'IS_DISABLED',
        'CreatedAt' => 'CREATED_AT',
        'Coll.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'coll.createdAt' => 'CREATED_AT',
        'CollTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'box_collection.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'Coll.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'coll.updatedAt' => 'UPDATED_AT',
        'CollTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'box_collection.updated_at' => 'UPDATED_AT',
    ];

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                CollTableMap::COL_TYPE => array(
                            self::COL_TYPE_STORAGE,
            self::COL_TYPE_SYNC,
            self::COL_TYPE_ASYNC,
        ),
    );

    /**
     * Gets the list of values for all ENUM and SET columns
     * @return array
     */
    public static function getValueSets()
    {
      return static::$enumValueSets;
    }

    /**
     * Gets the list of values for an ENUM or SET column
     * @param string $colname
     * @return array list of possible values for the column
     */
    public static function getValueSet($colname)
    {
        $valueSets = self::getValueSets();

        return $valueSets[$colname];
    }

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('box_collection');
        $this->setPhpName('Coll');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Box\\Model\\Coll');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('box_collection_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('type', 'Type', 'ENUM', true, null, 'storage');
        $this->getColumn('type')->setValueSet(array (
  0 => 'storage',
  1 => 'sync',
  2 => 'async',
));
        $this->addColumn('handler', 'Handler', 'VARCHAR', false, 255, null);
        $this->addColumn('is_disabled', 'IsDisabled', 'BOOLEAN', true, null, false);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Access', '\\Box\\Model\\Access', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':collection_id',
    1 => ':id',
  ),
), null, null, 'Accesses', false);
        $this->addRelation('DocumentLog', '\\Box\\Model\\DocumentLog', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':collection_id',
    1 => ':id',
  ),
), null, null, 'DocumentLogs', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? CollTableMap::CLASS_DEFAULT : CollTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Coll object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CollTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CollTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CollTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CollTableMap::OM_CLASS;
            /** @var Coll $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CollTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = CollTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CollTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Coll $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CollTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(CollTableMap::COL_ID);
            $criteria->addSelectColumn(CollTableMap::COL_NAME);
            $criteria->addSelectColumn(CollTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(CollTableMap::COL_TYPE);
            $criteria->addSelectColumn(CollTableMap::COL_HANDLER);
            $criteria->addSelectColumn(CollTableMap::COL_IS_DISABLED);
            $criteria->addSelectColumn(CollTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(CollTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.handler');
            $criteria->addSelectColumn($alias . '.is_disabled');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Remove all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be removed as they are only loaded on demand.
     *
     * @param Criteria $criteria object containing the columns to remove.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function removeSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->removeSelectColumn(CollTableMap::COL_ID);
            $criteria->removeSelectColumn(CollTableMap::COL_NAME);
            $criteria->removeSelectColumn(CollTableMap::COL_DESCRIPTION);
            $criteria->removeSelectColumn(CollTableMap::COL_TYPE);
            $criteria->removeSelectColumn(CollTableMap::COL_HANDLER);
            $criteria->removeSelectColumn(CollTableMap::COL_IS_DISABLED);
            $criteria->removeSelectColumn(CollTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(CollTableMap::COL_UPDATED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.name');
            $criteria->removeSelectColumn($alias . '.description');
            $criteria->removeSelectColumn($alias . '.type');
            $criteria->removeSelectColumn($alias . '.handler');
            $criteria->removeSelectColumn($alias . '.is_disabled');
            $criteria->removeSelectColumn($alias . '.created_at');
            $criteria->removeSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(CollTableMap::DATABASE_NAME)->getTable(CollTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CollTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CollTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CollTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Coll or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Coll object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CollTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Box\Model\Coll) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CollTableMap::DATABASE_NAME);
            $criteria->add(CollTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = CollQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CollTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CollTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the box_collection table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CollQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Coll or Criteria object.
     *
     * @param mixed               $criteria Criteria or Coll object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CollTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Coll object
        }

        if ($criteria->containsKey(CollTableMap::COL_ID) && $criteria->keyContainsValue(CollTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CollTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = CollQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CollTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CollTableMap::buildTableMap();
