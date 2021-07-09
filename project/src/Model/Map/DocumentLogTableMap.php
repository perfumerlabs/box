<?php

namespace Box\Model\Map;

use Box\Model\DocumentLog;
use Box\Model\DocumentLogQuery;
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
 * This class defines the structure of the 'box_document_log' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class DocumentLogTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.DocumentLogTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'box';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'box_document_log';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Box\\Model\\DocumentLog';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'DocumentLog';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 12;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 12;

    /**
     * the column name for the id field
     */
    const COL_ID = 'box_document_log.id';

    /**
     * the column name for the collection_id field
     */
    const COL_COLLECTION_ID = 'box_document_log.collection_id';

    /**
     * the column name for the client_id field
     */
    const COL_CLIENT_ID = 'box_document_log.client_id';

    /**
     * the column name for the document_id field
     */
    const COL_DOCUMENT_ID = 'box_document_log.document_id';

    /**
     * the column name for the uuid field
     */
    const COL_UUID = 'box_document_log.uuid';

    /**
     * the column name for the event field
     */
    const COL_EVENT = 'box_document_log.event';

    /**
     * the column name for the provider_requested_at field
     */
    const COL_PROVIDER_REQUESTED_AT = 'box_document_log.provider_requested_at';

    /**
     * the column name for the provider_respond_at field
     */
    const COL_PROVIDER_RESPOND_AT = 'box_document_log.provider_respond_at';

    /**
     * the column name for the webhook_requested_at field
     */
    const COL_WEBHOOK_REQUESTED_AT = 'box_document_log.webhook_requested_at';

    /**
     * the column name for the status field
     */
    const COL_STATUS = 'box_document_log.status';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'box_document_log.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'box_document_log.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the status field */
    const COL_STATUS_WAITING = 'waiting';
    const COL_STATUS_SUCCESS = 'success';
    const COL_STATUS_PROVIDER_FAILED = 'provider_failed';
    const COL_STATUS_WEBHOOK_FAILED = 'webhook_failed';
    const COL_STATUS_UNEXPECTED = 'unexpected';
    const COL_STATUS_DOCUMENT_NOT_FOUND = 'document_not_found';
    const COL_STATUS_WEBHOOK_NO_RESPONSE = 'webhook_no_response';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'CollectionId', 'ClientId', 'DocumentId', 'Uuid', 'Event', 'ProviderRequestedAt', 'ProviderRespondAt', 'WebhookRequestedAt', 'Status', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'collectionId', 'clientId', 'documentId', 'uuid', 'event', 'providerRequestedAt', 'providerRespondAt', 'webhookRequestedAt', 'status', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(DocumentLogTableMap::COL_ID, DocumentLogTableMap::COL_COLLECTION_ID, DocumentLogTableMap::COL_CLIENT_ID, DocumentLogTableMap::COL_DOCUMENT_ID, DocumentLogTableMap::COL_UUID, DocumentLogTableMap::COL_EVENT, DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT, DocumentLogTableMap::COL_PROVIDER_RESPOND_AT, DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT, DocumentLogTableMap::COL_STATUS, DocumentLogTableMap::COL_CREATED_AT, DocumentLogTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'collection_id', 'client_id', 'document_id', 'uuid', 'event', 'provider_requested_at', 'provider_respond_at', 'webhook_requested_at', 'status', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'CollectionId' => 1, 'ClientId' => 2, 'DocumentId' => 3, 'Uuid' => 4, 'Event' => 5, 'ProviderRequestedAt' => 6, 'ProviderRespondAt' => 7, 'WebhookRequestedAt' => 8, 'Status' => 9, 'CreatedAt' => 10, 'UpdatedAt' => 11, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'collectionId' => 1, 'clientId' => 2, 'documentId' => 3, 'uuid' => 4, 'event' => 5, 'providerRequestedAt' => 6, 'providerRespondAt' => 7, 'webhookRequestedAt' => 8, 'status' => 9, 'createdAt' => 10, 'updatedAt' => 11, ),
        self::TYPE_COLNAME       => array(DocumentLogTableMap::COL_ID => 0, DocumentLogTableMap::COL_COLLECTION_ID => 1, DocumentLogTableMap::COL_CLIENT_ID => 2, DocumentLogTableMap::COL_DOCUMENT_ID => 3, DocumentLogTableMap::COL_UUID => 4, DocumentLogTableMap::COL_EVENT => 5, DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT => 6, DocumentLogTableMap::COL_PROVIDER_RESPOND_AT => 7, DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT => 8, DocumentLogTableMap::COL_STATUS => 9, DocumentLogTableMap::COL_CREATED_AT => 10, DocumentLogTableMap::COL_UPDATED_AT => 11, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'collection_id' => 1, 'client_id' => 2, 'document_id' => 3, 'uuid' => 4, 'event' => 5, 'provider_requested_at' => 6, 'provider_respond_at' => 7, 'webhook_requested_at' => 8, 'status' => 9, 'created_at' => 10, 'updated_at' => 11, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [

        'Id' => 'ID',
        'DocumentLog.Id' => 'ID',
        'id' => 'ID',
        'documentLog.id' => 'ID',
        'DocumentLogTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'id' => 'ID',
        'box_document_log.id' => 'ID',
        'CollectionId' => 'COLLECTION_ID',
        'DocumentLog.CollectionId' => 'COLLECTION_ID',
        'collectionId' => 'COLLECTION_ID',
        'documentLog.collectionId' => 'COLLECTION_ID',
        'DocumentLogTableMap::COL_COLLECTION_ID' => 'COLLECTION_ID',
        'COL_COLLECTION_ID' => 'COLLECTION_ID',
        'collection_id' => 'COLLECTION_ID',
        'box_document_log.collection_id' => 'COLLECTION_ID',
        'ClientId' => 'CLIENT_ID',
        'DocumentLog.ClientId' => 'CLIENT_ID',
        'clientId' => 'CLIENT_ID',
        'documentLog.clientId' => 'CLIENT_ID',
        'DocumentLogTableMap::COL_CLIENT_ID' => 'CLIENT_ID',
        'COL_CLIENT_ID' => 'CLIENT_ID',
        'client_id' => 'CLIENT_ID',
        'box_document_log.client_id' => 'CLIENT_ID',
        'DocumentId' => 'DOCUMENT_ID',
        'DocumentLog.DocumentId' => 'DOCUMENT_ID',
        'documentId' => 'DOCUMENT_ID',
        'documentLog.documentId' => 'DOCUMENT_ID',
        'DocumentLogTableMap::COL_DOCUMENT_ID' => 'DOCUMENT_ID',
        'COL_DOCUMENT_ID' => 'DOCUMENT_ID',
        'document_id' => 'DOCUMENT_ID',
        'box_document_log.document_id' => 'DOCUMENT_ID',
        'Uuid' => 'UUID',
        'DocumentLog.Uuid' => 'UUID',
        'uuid' => 'UUID',
        'documentLog.uuid' => 'UUID',
        'DocumentLogTableMap::COL_UUID' => 'UUID',
        'COL_UUID' => 'UUID',
        'uuid' => 'UUID',
        'box_document_log.uuid' => 'UUID',
        'Event' => 'EVENT',
        'DocumentLog.Event' => 'EVENT',
        'event' => 'EVENT',
        'documentLog.event' => 'EVENT',
        'DocumentLogTableMap::COL_EVENT' => 'EVENT',
        'COL_EVENT' => 'EVENT',
        'event' => 'EVENT',
        'box_document_log.event' => 'EVENT',
        'ProviderRequestedAt' => 'PROVIDER_REQUESTED_AT',
        'DocumentLog.ProviderRequestedAt' => 'PROVIDER_REQUESTED_AT',
        'providerRequestedAt' => 'PROVIDER_REQUESTED_AT',
        'documentLog.providerRequestedAt' => 'PROVIDER_REQUESTED_AT',
        'DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT' => 'PROVIDER_REQUESTED_AT',
        'COL_PROVIDER_REQUESTED_AT' => 'PROVIDER_REQUESTED_AT',
        'provider_requested_at' => 'PROVIDER_REQUESTED_AT',
        'box_document_log.provider_requested_at' => 'PROVIDER_REQUESTED_AT',
        'ProviderRespondAt' => 'PROVIDER_RESPOND_AT',
        'DocumentLog.ProviderRespondAt' => 'PROVIDER_RESPOND_AT',
        'providerRespondAt' => 'PROVIDER_RESPOND_AT',
        'documentLog.providerRespondAt' => 'PROVIDER_RESPOND_AT',
        'DocumentLogTableMap::COL_PROVIDER_RESPOND_AT' => 'PROVIDER_RESPOND_AT',
        'COL_PROVIDER_RESPOND_AT' => 'PROVIDER_RESPOND_AT',
        'provider_respond_at' => 'PROVIDER_RESPOND_AT',
        'box_document_log.provider_respond_at' => 'PROVIDER_RESPOND_AT',
        'WebhookRequestedAt' => 'WEBHOOK_REQUESTED_AT',
        'DocumentLog.WebhookRequestedAt' => 'WEBHOOK_REQUESTED_AT',
        'webhookRequestedAt' => 'WEBHOOK_REQUESTED_AT',
        'documentLog.webhookRequestedAt' => 'WEBHOOK_REQUESTED_AT',
        'DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT' => 'WEBHOOK_REQUESTED_AT',
        'COL_WEBHOOK_REQUESTED_AT' => 'WEBHOOK_REQUESTED_AT',
        'webhook_requested_at' => 'WEBHOOK_REQUESTED_AT',
        'box_document_log.webhook_requested_at' => 'WEBHOOK_REQUESTED_AT',
        'Status' => 'STATUS',
        'DocumentLog.Status' => 'STATUS',
        'status' => 'STATUS',
        'documentLog.status' => 'STATUS',
        'DocumentLogTableMap::COL_STATUS' => 'STATUS',
        'COL_STATUS' => 'STATUS',
        'status' => 'STATUS',
        'box_document_log.status' => 'STATUS',
        'CreatedAt' => 'CREATED_AT',
        'DocumentLog.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'documentLog.createdAt' => 'CREATED_AT',
        'DocumentLogTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'box_document_log.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'DocumentLog.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'documentLog.updatedAt' => 'UPDATED_AT',
        'DocumentLogTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'box_document_log.updated_at' => 'UPDATED_AT',
    ];

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                DocumentLogTableMap::COL_STATUS => array(
                            self::COL_STATUS_WAITING,
            self::COL_STATUS_SUCCESS,
            self::COL_STATUS_PROVIDER_FAILED,
            self::COL_STATUS_WEBHOOK_FAILED,
            self::COL_STATUS_UNEXPECTED,
            self::COL_STATUS_DOCUMENT_NOT_FOUND,
            self::COL_STATUS_WEBHOOK_NO_RESPONSE,
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
        $this->setName('box_document_log');
        $this->setPhpName('DocumentLog');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Box\\Model\\DocumentLog');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('box_document_log_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addForeignKey('collection_id', 'CollectionId', 'INTEGER', 'box_collection', 'id', true, null, null);
        $this->addForeignKey('client_id', 'ClientId', 'INTEGER', 'box_client', 'id', true, null, null);
        $this->addColumn('document_id', 'DocumentId', 'BIGINT', true, null, null);
        $this->addColumn('uuid', 'Uuid', 'VARCHAR', true, 255, null);
        $this->addColumn('event', 'Event', 'VARCHAR', true, 255, null);
        $this->addColumn('provider_requested_at', 'ProviderRequestedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('provider_respond_at', 'ProviderRespondAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('webhook_requested_at', 'WebhookRequestedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('status', 'Status', 'ENUM', true, null, 'waiting');
        $this->getColumn('status')->setValueSet(array (
  0 => 'waiting',
  1 => 'success',
  2 => 'provider_failed',
  3 => 'webhook_failed',
  4 => 'unexpected',
  5 => 'document_not_found',
  6 => 'webhook_no_response',
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
        $this->addRelation('RequestLog', '\\Box\\Model\\RequestLog', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':document_log_id',
    1 => ':id',
  ),
), 'CASCADE', null, 'RequestLogs', false);
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
     * Method to invalidate the instance pool of all tables related to box_document_log     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        RequestLogTableMap::clearInstancePool();
    }

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
        return (string) $row[
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
        return $withPrefix ? DocumentLogTableMap::CLASS_DEFAULT : DocumentLogTableMap::OM_CLASS;
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
     * @return array           (DocumentLog object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = DocumentLogTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = DocumentLogTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + DocumentLogTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = DocumentLogTableMap::OM_CLASS;
            /** @var DocumentLog $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            DocumentLogTableMap::addInstanceToPool($obj, $key);
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
            $key = DocumentLogTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = DocumentLogTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var DocumentLog $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                DocumentLogTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(DocumentLogTableMap::COL_ID);
            $criteria->addSelectColumn(DocumentLogTableMap::COL_COLLECTION_ID);
            $criteria->addSelectColumn(DocumentLogTableMap::COL_CLIENT_ID);
            $criteria->addSelectColumn(DocumentLogTableMap::COL_DOCUMENT_ID);
            $criteria->addSelectColumn(DocumentLogTableMap::COL_UUID);
            $criteria->addSelectColumn(DocumentLogTableMap::COL_EVENT);
            $criteria->addSelectColumn(DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT);
            $criteria->addSelectColumn(DocumentLogTableMap::COL_PROVIDER_RESPOND_AT);
            $criteria->addSelectColumn(DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT);
            $criteria->addSelectColumn(DocumentLogTableMap::COL_STATUS);
            $criteria->addSelectColumn(DocumentLogTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(DocumentLogTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.collection_id');
            $criteria->addSelectColumn($alias . '.client_id');
            $criteria->addSelectColumn($alias . '.document_id');
            $criteria->addSelectColumn($alias . '.uuid');
            $criteria->addSelectColumn($alias . '.event');
            $criteria->addSelectColumn($alias . '.provider_requested_at');
            $criteria->addSelectColumn($alias . '.provider_respond_at');
            $criteria->addSelectColumn($alias . '.webhook_requested_at');
            $criteria->addSelectColumn($alias . '.status');
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
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_ID);
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_COLLECTION_ID);
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_CLIENT_ID);
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_DOCUMENT_ID);
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_UUID);
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_EVENT);
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT);
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_PROVIDER_RESPOND_AT);
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT);
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_STATUS);
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(DocumentLogTableMap::COL_UPDATED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.collection_id');
            $criteria->removeSelectColumn($alias . '.client_id');
            $criteria->removeSelectColumn($alias . '.document_id');
            $criteria->removeSelectColumn($alias . '.uuid');
            $criteria->removeSelectColumn($alias . '.event');
            $criteria->removeSelectColumn($alias . '.provider_requested_at');
            $criteria->removeSelectColumn($alias . '.provider_respond_at');
            $criteria->removeSelectColumn($alias . '.webhook_requested_at');
            $criteria->removeSelectColumn($alias . '.status');
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
        return Propel::getServiceContainer()->getDatabaseMap(DocumentLogTableMap::DATABASE_NAME)->getTable(DocumentLogTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(DocumentLogTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(DocumentLogTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new DocumentLogTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a DocumentLog or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or DocumentLog object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentLogTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Box\Model\DocumentLog) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(DocumentLogTableMap::DATABASE_NAME);
            $criteria->add(DocumentLogTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = DocumentLogQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            DocumentLogTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                DocumentLogTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the box_document_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return DocumentLogQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a DocumentLog or Criteria object.
     *
     * @param mixed               $criteria Criteria or DocumentLog object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentLogTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from DocumentLog object
        }

        if ($criteria->containsKey(DocumentLogTableMap::COL_ID) && $criteria->keyContainsValue(DocumentLogTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.DocumentLogTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = DocumentLogQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // DocumentLogTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
DocumentLogTableMap::buildTableMap();
