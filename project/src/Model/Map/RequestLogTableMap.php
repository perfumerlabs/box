<?php

namespace Box\Model\Map;

use Box\Model\RequestLog;
use Box\Model\RequestLogQuery;
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
 * This class defines the structure of the 'box_request_log' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 */
class RequestLogTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.RequestLogTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'box';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'box_request_log';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Box\\Model\\RequestLog';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'RequestLog';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the id field
     */
    const COL_ID = 'box_request_log.id';

    /**
     * the column name for the document_log_id field
     */
    const COL_DOCUMENT_LOG_ID = 'box_request_log.document_log_id';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'box_request_log.type';

    /**
     * the column name for the request_url field
     */
    const COL_REQUEST_URL = 'box_request_log.request_url';

    /**
     * the column name for the request_method field
     */
    const COL_REQUEST_METHOD = 'box_request_log.request_method';

    /**
     * the column name for the request_headers field
     */
    const COL_REQUEST_HEADERS = 'box_request_log.request_headers';

    /**
     * the column name for the request_body field
     */
    const COL_REQUEST_BODY = 'box_request_log.request_body';

    /**
     * the column name for the response_status_code field
     */
    const COL_RESPONSE_STATUS_CODE = 'box_request_log.response_status_code';

    /**
     * the column name for the response_headers field
     */
    const COL_RESPONSE_HEADERS = 'box_request_log.response_headers';

    /**
     * the column name for the response_body field
     */
    const COL_RESPONSE_BODY = 'box_request_log.response_body';

    /**
     * the column name for the response_error field
     */
    const COL_RESPONSE_ERROR = 'box_request_log.response_error';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'box_request_log.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'box_request_log.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /** The enumerated values for the type field */
    const COL_TYPE_PROVIDER = 'provider';
    const COL_TYPE_WEBHOOK = 'webhook';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'DocumentLogId', 'Type', 'RequestUrl', 'RequestMethod', 'RequestHeaders', 'RequestBody', 'ResponseStatusCode', 'ResponseHeaders', 'ResponseBody', 'ResponseError', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'documentLogId', 'type', 'requestUrl', 'requestMethod', 'requestHeaders', 'requestBody', 'responseStatusCode', 'responseHeaders', 'responseBody', 'responseError', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(RequestLogTableMap::COL_ID, RequestLogTableMap::COL_DOCUMENT_LOG_ID, RequestLogTableMap::COL_TYPE, RequestLogTableMap::COL_REQUEST_URL, RequestLogTableMap::COL_REQUEST_METHOD, RequestLogTableMap::COL_REQUEST_HEADERS, RequestLogTableMap::COL_REQUEST_BODY, RequestLogTableMap::COL_RESPONSE_STATUS_CODE, RequestLogTableMap::COL_RESPONSE_HEADERS, RequestLogTableMap::COL_RESPONSE_BODY, RequestLogTableMap::COL_RESPONSE_ERROR, RequestLogTableMap::COL_CREATED_AT, RequestLogTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'document_log_id', 'type', 'request_url', 'request_method', 'request_headers', 'request_body', 'response_status_code', 'response_headers', 'response_body', 'response_error', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'DocumentLogId' => 1, 'Type' => 2, 'RequestUrl' => 3, 'RequestMethod' => 4, 'RequestHeaders' => 5, 'RequestBody' => 6, 'ResponseStatusCode' => 7, 'ResponseHeaders' => 8, 'ResponseBody' => 9, 'ResponseError' => 10, 'CreatedAt' => 11, 'UpdatedAt' => 12, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'documentLogId' => 1, 'type' => 2, 'requestUrl' => 3, 'requestMethod' => 4, 'requestHeaders' => 5, 'requestBody' => 6, 'responseStatusCode' => 7, 'responseHeaders' => 8, 'responseBody' => 9, 'responseError' => 10, 'createdAt' => 11, 'updatedAt' => 12, ),
        self::TYPE_COLNAME       => array(RequestLogTableMap::COL_ID => 0, RequestLogTableMap::COL_DOCUMENT_LOG_ID => 1, RequestLogTableMap::COL_TYPE => 2, RequestLogTableMap::COL_REQUEST_URL => 3, RequestLogTableMap::COL_REQUEST_METHOD => 4, RequestLogTableMap::COL_REQUEST_HEADERS => 5, RequestLogTableMap::COL_REQUEST_BODY => 6, RequestLogTableMap::COL_RESPONSE_STATUS_CODE => 7, RequestLogTableMap::COL_RESPONSE_HEADERS => 8, RequestLogTableMap::COL_RESPONSE_BODY => 9, RequestLogTableMap::COL_RESPONSE_ERROR => 10, RequestLogTableMap::COL_CREATED_AT => 11, RequestLogTableMap::COL_UPDATED_AT => 12, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'document_log_id' => 1, 'type' => 2, 'request_url' => 3, 'request_method' => 4, 'request_headers' => 5, 'request_body' => 6, 'response_status_code' => 7, 'response_headers' => 8, 'response_body' => 9, 'response_error' => 10, 'created_at' => 11, 'updated_at' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * Holds a list of column names and their normalized version.
     *
     * @var string[]
     */
    protected $normalizedColumnNameMap = [

        'Id' => 'ID',
        'RequestLog.Id' => 'ID',
        'id' => 'ID',
        'requestLog.id' => 'ID',
        'RequestLogTableMap::COL_ID' => 'ID',
        'COL_ID' => 'ID',
        'id' => 'ID',
        'box_request_log.id' => 'ID',
        'DocumentLogId' => 'DOCUMENT_LOG_ID',
        'RequestLog.DocumentLogId' => 'DOCUMENT_LOG_ID',
        'documentLogId' => 'DOCUMENT_LOG_ID',
        'requestLog.documentLogId' => 'DOCUMENT_LOG_ID',
        'RequestLogTableMap::COL_DOCUMENT_LOG_ID' => 'DOCUMENT_LOG_ID',
        'COL_DOCUMENT_LOG_ID' => 'DOCUMENT_LOG_ID',
        'document_log_id' => 'DOCUMENT_LOG_ID',
        'box_request_log.document_log_id' => 'DOCUMENT_LOG_ID',
        'Type' => 'TYPE',
        'RequestLog.Type' => 'TYPE',
        'type' => 'TYPE',
        'requestLog.type' => 'TYPE',
        'RequestLogTableMap::COL_TYPE' => 'TYPE',
        'COL_TYPE' => 'TYPE',
        'type' => 'TYPE',
        'box_request_log.type' => 'TYPE',
        'RequestUrl' => 'REQUEST_URL',
        'RequestLog.RequestUrl' => 'REQUEST_URL',
        'requestUrl' => 'REQUEST_URL',
        'requestLog.requestUrl' => 'REQUEST_URL',
        'RequestLogTableMap::COL_REQUEST_URL' => 'REQUEST_URL',
        'COL_REQUEST_URL' => 'REQUEST_URL',
        'request_url' => 'REQUEST_URL',
        'box_request_log.request_url' => 'REQUEST_URL',
        'RequestMethod' => 'REQUEST_METHOD',
        'RequestLog.RequestMethod' => 'REQUEST_METHOD',
        'requestMethod' => 'REQUEST_METHOD',
        'requestLog.requestMethod' => 'REQUEST_METHOD',
        'RequestLogTableMap::COL_REQUEST_METHOD' => 'REQUEST_METHOD',
        'COL_REQUEST_METHOD' => 'REQUEST_METHOD',
        'request_method' => 'REQUEST_METHOD',
        'box_request_log.request_method' => 'REQUEST_METHOD',
        'RequestHeaders' => 'REQUEST_HEADERS',
        'RequestLog.RequestHeaders' => 'REQUEST_HEADERS',
        'requestHeaders' => 'REQUEST_HEADERS',
        'requestLog.requestHeaders' => 'REQUEST_HEADERS',
        'RequestLogTableMap::COL_REQUEST_HEADERS' => 'REQUEST_HEADERS',
        'COL_REQUEST_HEADERS' => 'REQUEST_HEADERS',
        'request_headers' => 'REQUEST_HEADERS',
        'box_request_log.request_headers' => 'REQUEST_HEADERS',
        'RequestBody' => 'REQUEST_BODY',
        'RequestLog.RequestBody' => 'REQUEST_BODY',
        'requestBody' => 'REQUEST_BODY',
        'requestLog.requestBody' => 'REQUEST_BODY',
        'RequestLogTableMap::COL_REQUEST_BODY' => 'REQUEST_BODY',
        'COL_REQUEST_BODY' => 'REQUEST_BODY',
        'request_body' => 'REQUEST_BODY',
        'box_request_log.request_body' => 'REQUEST_BODY',
        'ResponseStatusCode' => 'RESPONSE_STATUS_CODE',
        'RequestLog.ResponseStatusCode' => 'RESPONSE_STATUS_CODE',
        'responseStatusCode' => 'RESPONSE_STATUS_CODE',
        'requestLog.responseStatusCode' => 'RESPONSE_STATUS_CODE',
        'RequestLogTableMap::COL_RESPONSE_STATUS_CODE' => 'RESPONSE_STATUS_CODE',
        'COL_RESPONSE_STATUS_CODE' => 'RESPONSE_STATUS_CODE',
        'response_status_code' => 'RESPONSE_STATUS_CODE',
        'box_request_log.response_status_code' => 'RESPONSE_STATUS_CODE',
        'ResponseHeaders' => 'RESPONSE_HEADERS',
        'RequestLog.ResponseHeaders' => 'RESPONSE_HEADERS',
        'responseHeaders' => 'RESPONSE_HEADERS',
        'requestLog.responseHeaders' => 'RESPONSE_HEADERS',
        'RequestLogTableMap::COL_RESPONSE_HEADERS' => 'RESPONSE_HEADERS',
        'COL_RESPONSE_HEADERS' => 'RESPONSE_HEADERS',
        'response_headers' => 'RESPONSE_HEADERS',
        'box_request_log.response_headers' => 'RESPONSE_HEADERS',
        'ResponseBody' => 'RESPONSE_BODY',
        'RequestLog.ResponseBody' => 'RESPONSE_BODY',
        'responseBody' => 'RESPONSE_BODY',
        'requestLog.responseBody' => 'RESPONSE_BODY',
        'RequestLogTableMap::COL_RESPONSE_BODY' => 'RESPONSE_BODY',
        'COL_RESPONSE_BODY' => 'RESPONSE_BODY',
        'response_body' => 'RESPONSE_BODY',
        'box_request_log.response_body' => 'RESPONSE_BODY',
        'ResponseError' => 'RESPONSE_ERROR',
        'RequestLog.ResponseError' => 'RESPONSE_ERROR',
        'responseError' => 'RESPONSE_ERROR',
        'requestLog.responseError' => 'RESPONSE_ERROR',
        'RequestLogTableMap::COL_RESPONSE_ERROR' => 'RESPONSE_ERROR',
        'COL_RESPONSE_ERROR' => 'RESPONSE_ERROR',
        'response_error' => 'RESPONSE_ERROR',
        'box_request_log.response_error' => 'RESPONSE_ERROR',
        'CreatedAt' => 'CREATED_AT',
        'RequestLog.CreatedAt' => 'CREATED_AT',
        'createdAt' => 'CREATED_AT',
        'requestLog.createdAt' => 'CREATED_AT',
        'RequestLogTableMap::COL_CREATED_AT' => 'CREATED_AT',
        'COL_CREATED_AT' => 'CREATED_AT',
        'created_at' => 'CREATED_AT',
        'box_request_log.created_at' => 'CREATED_AT',
        'UpdatedAt' => 'UPDATED_AT',
        'RequestLog.UpdatedAt' => 'UPDATED_AT',
        'updatedAt' => 'UPDATED_AT',
        'requestLog.updatedAt' => 'UPDATED_AT',
        'RequestLogTableMap::COL_UPDATED_AT' => 'UPDATED_AT',
        'COL_UPDATED_AT' => 'UPDATED_AT',
        'updated_at' => 'UPDATED_AT',
        'box_request_log.updated_at' => 'UPDATED_AT',
    ];

    /** The enumerated values for this table */
    protected static $enumValueSets = array(
                RequestLogTableMap::COL_TYPE => array(
                            self::COL_TYPE_PROVIDER,
            self::COL_TYPE_WEBHOOK,
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
        $this->setName('box_request_log');
        $this->setPhpName('RequestLog');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Box\\Model\\RequestLog');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('box_request_log_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addForeignKey('document_log_id', 'DocumentLogId', 'BIGINT', 'box_document_log', 'id', true, null, null);
        $this->addColumn('type', 'Type', 'ENUM', true, null, null);
        $this->getColumn('type')->setValueSet(array (
  0 => 'provider',
  1 => 'webhook',
));
        $this->addColumn('request_url', 'RequestUrl', 'VARCHAR', false, 255, null);
        $this->addColumn('request_method', 'RequestMethod', 'VARCHAR', false, 255, null);
        $this->addColumn('request_headers', 'RequestHeaders', 'LONGVARCHAR', false, null, null);
        $this->addColumn('request_body', 'RequestBody', 'LONGVARCHAR', false, null, null);
        $this->addColumn('response_status_code', 'ResponseStatusCode', 'INTEGER', false, null, null);
        $this->addColumn('response_headers', 'ResponseHeaders', 'LONGVARCHAR', false, null, null);
        $this->addColumn('response_body', 'ResponseBody', 'LONGVARCHAR', false, null, null);
        $this->addColumn('response_error', 'ResponseError', 'LONGVARCHAR', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('DocumentLog', '\\Box\\Model\\DocumentLog', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':document_log_id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
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
        return $withPrefix ? RequestLogTableMap::CLASS_DEFAULT : RequestLogTableMap::OM_CLASS;
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
     * @return array           (RequestLog object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = RequestLogTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = RequestLogTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + RequestLogTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = RequestLogTableMap::OM_CLASS;
            /** @var RequestLog $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            RequestLogTableMap::addInstanceToPool($obj, $key);
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
            $key = RequestLogTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = RequestLogTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var RequestLog $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                RequestLogTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(RequestLogTableMap::COL_ID);
            $criteria->addSelectColumn(RequestLogTableMap::COL_DOCUMENT_LOG_ID);
            $criteria->addSelectColumn(RequestLogTableMap::COL_TYPE);
            $criteria->addSelectColumn(RequestLogTableMap::COL_REQUEST_URL);
            $criteria->addSelectColumn(RequestLogTableMap::COL_REQUEST_METHOD);
            $criteria->addSelectColumn(RequestLogTableMap::COL_REQUEST_HEADERS);
            $criteria->addSelectColumn(RequestLogTableMap::COL_REQUEST_BODY);
            $criteria->addSelectColumn(RequestLogTableMap::COL_RESPONSE_STATUS_CODE);
            $criteria->addSelectColumn(RequestLogTableMap::COL_RESPONSE_HEADERS);
            $criteria->addSelectColumn(RequestLogTableMap::COL_RESPONSE_BODY);
            $criteria->addSelectColumn(RequestLogTableMap::COL_RESPONSE_ERROR);
            $criteria->addSelectColumn(RequestLogTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(RequestLogTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.document_log_id');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.request_url');
            $criteria->addSelectColumn($alias . '.request_method');
            $criteria->addSelectColumn($alias . '.request_headers');
            $criteria->addSelectColumn($alias . '.request_body');
            $criteria->addSelectColumn($alias . '.response_status_code');
            $criteria->addSelectColumn($alias . '.response_headers');
            $criteria->addSelectColumn($alias . '.response_body');
            $criteria->addSelectColumn($alias . '.response_error');
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
            $criteria->removeSelectColumn(RequestLogTableMap::COL_ID);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_DOCUMENT_LOG_ID);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_TYPE);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_REQUEST_URL);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_REQUEST_METHOD);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_REQUEST_HEADERS);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_REQUEST_BODY);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_RESPONSE_STATUS_CODE);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_RESPONSE_HEADERS);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_RESPONSE_BODY);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_RESPONSE_ERROR);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_CREATED_AT);
            $criteria->removeSelectColumn(RequestLogTableMap::COL_UPDATED_AT);
        } else {
            $criteria->removeSelectColumn($alias . '.id');
            $criteria->removeSelectColumn($alias . '.document_log_id');
            $criteria->removeSelectColumn($alias . '.type');
            $criteria->removeSelectColumn($alias . '.request_url');
            $criteria->removeSelectColumn($alias . '.request_method');
            $criteria->removeSelectColumn($alias . '.request_headers');
            $criteria->removeSelectColumn($alias . '.request_body');
            $criteria->removeSelectColumn($alias . '.response_status_code');
            $criteria->removeSelectColumn($alias . '.response_headers');
            $criteria->removeSelectColumn($alias . '.response_body');
            $criteria->removeSelectColumn($alias . '.response_error');
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
        return Propel::getServiceContainer()->getDatabaseMap(RequestLogTableMap::DATABASE_NAME)->getTable(RequestLogTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(RequestLogTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(RequestLogTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new RequestLogTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a RequestLog or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or RequestLog object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(RequestLogTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Box\Model\RequestLog) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(RequestLogTableMap::DATABASE_NAME);
            $criteria->add(RequestLogTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = RequestLogQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            RequestLogTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                RequestLogTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the box_request_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return RequestLogQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a RequestLog or Criteria object.
     *
     * @param mixed               $criteria Criteria or RequestLog object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RequestLogTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from RequestLog object
        }

        if ($criteria->containsKey(RequestLogTableMap::COL_ID) && $criteria->keyContainsValue(RequestLogTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.RequestLogTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = RequestLogQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // RequestLogTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
RequestLogTableMap::buildTableMap();
