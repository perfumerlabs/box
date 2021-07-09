<?php

namespace Box\Model\Map;

use Box\Model\Access;
use Box\Model\AccessQuery;
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
 * This class defines the structure of the 'box_access' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class AccessTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.AccessTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'box';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'box_access';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Box\\Model\\Access';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Access';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id field
     */
    const COL_ID = 'box_access.id';

    /**
     * the column name for the collection_id field
     */
    const COL_COLLECTION_ID = 'box_access.collection_id';

    /**
     * the column name for the client_id field
     */
    const COL_CLIENT_ID = 'box_access.client_id';

    /**
     * the column name for the level field
     */
    const COL_LEVEL = 'box_access.level';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'box_access.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'box_access.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the level field */
    const COL_LEVEL_READ = 'read';
    const COL_LEVEL_WRITE = 'write';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'CollectionId', 'ClientId', 'Level', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'collectionId', 'clientId', 'level', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(AccessTableMap::COL_ID, AccessTableMap::COL_COLLECTION_ID, AccessTableMap::COL_CLIENT_ID, AccessTableMap::COL_LEVEL, AccessTableMap::COL_CREATED_AT, AccessTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'collection_id', 'client_id', 'level', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'CollectionId' => 1, 'ClientId' => 2, 'Level' => 3, 'CreatedAt' => 4, 'UpdatedAt' => 5, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'collectionId' => 1, 'clientId' => 2, 'level' => 3, 'createdAt' => 4, 'updatedAt' => 5, ),
        self::TYPE_COLNAME       => array(AccessTableMap::COL_ID => 0, AccessTableMap::COL_COLLECTION_ID => 1, AccessTableMap::COL_CLIENT_ID => 2, AccessTableMap::COL_LEVEL => 3, AccessTableMap::COL_CREATED_AT => 4, AccessTableMap::COL_UPDATED_AT => 5, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'collection_id' => 1, 'client_id' => 2, 'level' => 3, 'created_at' => 4, 'updated_at' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [

        'Id' => 'ID',
        'Access.Id' => 'ID',
        'id' => 'ID',
        'access.id' => 'ID',
        'AccessTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'id' => 'ID',
        'box_access.id' => 'ID',
        'CollectionId' => 'COLLECTION_ID',
        'Access.CollectionId' => 'COLLECTION_ID',
        'collectionId' => 'COLLECTION_ID',
        'access.collectionId' => 'COLLECTION_ID',
        'AccessTableMap::COL_COLLECTION_ID' => 'COLLECTION_ID',
        'COL_COLLECTION_ID' => 'COLLECTION_ID',
        'collection_id' => 'COLLECTION_ID',
        'box_access.collection_id' => 'COLLECTION_ID',
        'ClientId' => 'CLIENT_ID',
        'Access.ClientId' => 'CLIENT_ID',
        'clientId' => 'CLIENT_ID',
        'access.clientId' => 'CLIENT_ID',
        'AccessTableMap::COL_CLIENT_ID' => 'CLIENT_ID',
        'COL_CLIENT_ID' => 'CLIENT_ID',
        'client_id' => 'CLIENT_ID',
        'box_access.client_id' => 'CLIENT_ID',
        'Level' => 'LEVEL',
        'Access.Level' => 'LEVEL',
        'level' => 'LEVEL',
        'access.level' => 'LEVEL',
        'AccessTableMap::COL_LEVEL' => 'LEVEL',
        'COL_LEVEL' => 'LEVEL',
        'level' => 'LEVEL',
        'box_access.level' => 'LEVEL',
        'CreatedAt' => 'CREATED_AT',
        'Access.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'access.createdAt' => 'CREATED_AT',
        'AccessTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'box_access.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'Access.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'access.updatedAt' => 'UPDATED_AT',
        'AccessTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'box_access.updated_at' => 'UPDATED_AT',
    ];

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                AccessTableMap::COL_LEVEL => array(
                            self::COL_LEVEL_READ,
            self::COL_LEVEL_WRITE,
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
        $this->setName('box_access');
        $this->setPhpName('Access');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Box\\Model\\Access');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('box_access_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('collection_id', 'CollectionId', 'INTEGER', 'box_collection', 'id', true, null, null);
        $this->addForeignKey('client_id', 'ClientId', 'INTEGER', 'box_client', 'id', true, null, null);
        $this->addColumn('level', 'Level', 'ENUM', true, null, null);
        $this->getColumn('level')->setValueSet(array (
  0 => 'read',
  1 => 'write',
));
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Client', '\\Box\\Model\\Client', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':client_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Collection', '\\Box\\Model\\Coll', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':collection_id',
    1 => ':id',
  ),
), null, null, null, false);
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
        return $withPrefix ? AccessTableMap::CLASS_DEFAULT : AccessTableMap::OM_CLASS;
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
     * @return array           (Access object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AccessTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AccessTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AccessTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AccessTableMap::OM_CLASS;
            /** @var Access $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AccessTableMap::addInstanceToPool($obj, $key);
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
            $key = AccessTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AccessTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Access $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AccessTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AccessTableMap::COL_ID);
            $criteria->addSelectColumn(AccessTableMap::COL_COLLECTION_ID);
            $criteria->addSelectColumn(AccessTableMap::COL_CLIENT_ID);
            $criteria->addSelectColumn(AccessTableMap::COL_LEVEL);
            $criteria->addSelectColumn(AccessTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(AccessTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.collection_id');
            $criteria->addSelectColumn($alias . '.client_id');
            $criteria->addSelectColumn($alias . '.level');
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
            $criteria->removeSelectColumn(AccessTableMap::COL_ID);
            $criteria->removeSelectColumn(AccessTableMap::COL_COLLECTION_ID);
            $criteria->removeSelectColumn(AccessTableMap::COL_CLIENT_ID);
            $criteria->removeSelectColumn(AccessTableMap::COL_LEVEL);
            $criteria->removeSelectColumn(AccessTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(AccessTableMap::COL_UPDATED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.collection_id');
            $criteria->removeSelectColumn($alias . '.client_id');
            $criteria->removeSelectColumn($alias . '.level');
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
        return Propel::getServiceContainer()->getDatabaseMap(AccessTableMap::DATABASE_NAME)->getTable(AccessTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AccessTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AccessTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AccessTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Access or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Access object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AccessTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Box\Model\Access) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AccessTableMap::DATABASE_NAME);
            $criteria->add(AccessTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = AccessQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AccessTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AccessTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the box_access table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AccessQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Access or Criteria object.
     *
     * @param mixed               $criteria Criteria or Access object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccessTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Access object
        }

        if ($criteria->containsKey(AccessTableMap::COL_ID) && $criteria->keyContainsValue(AccessTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.AccessTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = AccessQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AccessTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AccessTableMap::buildTableMap();
