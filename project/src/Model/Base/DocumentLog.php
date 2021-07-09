<?php

namespace Box\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Box\Model\Client as ChildClient;
use Box\Model\ClientQuery as ChildClientQuery;
use Box\Model\Coll as ChildColl;
use Box\Model\CollQuery as ChildCollQuery;
use Box\Model\DocumentLog as ChildDocumentLog;
use Box\Model\DocumentLogQuery as ChildDocumentLogQuery;
use Box\Model\RequestLog as ChildRequestLog;
use Box\Model\RequestLogQuery as ChildRequestLogQuery;
use Box\Model\Map\DocumentLogTableMap;
use Box\Model\Map\RequestLogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'box_document_log' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class DocumentLog implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Box\\Model\\Map\\DocumentLogTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        string
     */
    protected $id;

    /**
     * The value for the collection_id field.
     *
     * @var        int
     */
    protected $collection_id;

    /**
     * The value for the client_id field.
     *
     * @var        int
     */
    protected $client_id;

    /**
     * The value for the document_id field.
     *
     * @var        string
     */
    protected $document_id;

    /**
     * The value for the uuid field.
     *
     * @var        string
     */
    protected $uuid;

    /**
     * The value for the event field.
     *
     * @var        string
     */
    protected $event;

    /**
     * The value for the provider_requested_at field.
     *
     * @var        DateTime|null
     */
    protected $provider_requested_at;

    /**
     * The value for the provider_respond_at field.
     *
     * @var        DateTime|null
     */
    protected $provider_respond_at;

    /**
     * The value for the webhook_requested_at field.
     *
     * @var        DateTime|null
     */
    protected $webhook_requested_at;

    /**
     * The value for the status field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $status;

    /**
     * The value for the created_at field.
     *
     * @var        DateTime|null
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     *
     * @var        DateTime|null
     */
    protected $updated_at;

    /**
     * @var        ChildClient
     */
    protected $aClient;

    /**
     * @var        ChildColl
     */
    protected $aCollection;

    /**
     * @var        ObjectCollection|ChildRequestLog[] Collection to store aggregation of ChildRequestLog objects.
     */
    protected $collRequestLogs;
    protected $collRequestLogsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildRequestLog[]
     */
    protected $requestLogsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->status = 0;
    }

    /**
     * Initializes internal state of Box\Model\Base\DocumentLog object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>DocumentLog</code> instance.  If
     * <code>obj</code> is an instance of <code>DocumentLog</code>, delegates to
     * <code>equals(DocumentLog)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return void
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [collection_id] column value.
     *
     * @return int
     */
    public function getCollectionId()
    {
        return $this->collection_id;
    }

    /**
     * Get the [client_id] column value.
     *
     * @return int
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Get the [document_id] column value.
     *
     * @return string
     */
    public function getDocumentId()
    {
        return $this->document_id;
    }

    /**
     * Get the [uuid] column value.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Get the [event] column value.
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Get the [optionally formatted] temporal [provider_requested_at] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getProviderRequestedAt($format = null)
    {
        if ($format === null) {
            return $this->provider_requested_at;
        } else {
            return $this->provider_requested_at instanceof \DateTimeInterface ? $this->provider_requested_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [provider_respond_at] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getProviderRespondAt($format = null)
    {
        if ($format === null) {
            return $this->provider_respond_at;
        } else {
            return $this->provider_respond_at instanceof \DateTimeInterface ? $this->provider_respond_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [webhook_requested_at] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getWebhookRequestedAt($format = null)
    {
        if ($format === null) {
            return $this->webhook_requested_at;
        } else {
            return $this->webhook_requested_at instanceof \DateTimeInterface ? $this->webhook_requested_at->format($format) : null;
        }
    }

    /**
     * Get the [status] column value.
     *
     * @return string
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function getStatus()
    {
        if (null === $this->status) {
            return null;
        }
        $valueSet = DocumentLogTableMap::getValueSet(DocumentLogTableMap::COL_STATUS);
        if (!isset($valueSet[$this->status])) {
            throw new PropelException('Unknown stored enum key: ' . $this->status);
        }

        return $valueSet[$this->status];
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = null)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTimeInterface ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param string|null $format The date/time format string (either date()-style or strftime()-style).
     *   If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime|null Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = null)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTimeInterface ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param string $v New value
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[DocumentLogTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [collection_id] column.
     *
     * @param int $v New value
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function setCollectionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->collection_id !== $v) {
            $this->collection_id = $v;
            $this->modifiedColumns[DocumentLogTableMap::COL_COLLECTION_ID] = true;
        }

        if ($this->aCollection !== null && $this->aCollection->getId() !== $v) {
            $this->aCollection = null;
        }

        return $this;
    } // setCollectionId()

    /**
     * Set the value of [client_id] column.
     *
     * @param int $v New value
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function setClientId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->client_id !== $v) {
            $this->client_id = $v;
            $this->modifiedColumns[DocumentLogTableMap::COL_CLIENT_ID] = true;
        }

        if ($this->aClient !== null && $this->aClient->getId() !== $v) {
            $this->aClient = null;
        }

        return $this;
    } // setClientId()

    /**
     * Set the value of [document_id] column.
     *
     * @param string $v New value
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function setDocumentId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->document_id !== $v) {
            $this->document_id = $v;
            $this->modifiedColumns[DocumentLogTableMap::COL_DOCUMENT_ID] = true;
        }

        return $this;
    } // setDocumentId()

    /**
     * Set the value of [uuid] column.
     *
     * @param string $v New value
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function setUuid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->uuid !== $v) {
            $this->uuid = $v;
            $this->modifiedColumns[DocumentLogTableMap::COL_UUID] = true;
        }

        return $this;
    } // setUuid()

    /**
     * Set the value of [event] column.
     *
     * @param string $v New value
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function setEvent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->event !== $v) {
            $this->event = $v;
            $this->modifiedColumns[DocumentLogTableMap::COL_EVENT] = true;
        }

        return $this;
    } // setEvent()

    /**
     * Sets the value of [provider_requested_at] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function setProviderRequestedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->provider_requested_at !== null || $dt !== null) {
            if ($this->provider_requested_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->provider_requested_at->format("Y-m-d H:i:s.u")) {
                $this->provider_requested_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setProviderRequestedAt()

    /**
     * Sets the value of [provider_respond_at] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function setProviderRespondAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->provider_respond_at !== null || $dt !== null) {
            if ($this->provider_respond_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->provider_respond_at->format("Y-m-d H:i:s.u")) {
                $this->provider_respond_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DocumentLogTableMap::COL_PROVIDER_RESPOND_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setProviderRespondAt()

    /**
     * Sets the value of [webhook_requested_at] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function setWebhookRequestedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->webhook_requested_at !== null || $dt !== null) {
            if ($this->webhook_requested_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->webhook_requested_at->format("Y-m-d H:i:s.u")) {
                $this->webhook_requested_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setWebhookRequestedAt()

    /**
     * Set the value of [status] column.
     *
     * @param  string $v new value
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $valueSet = DocumentLogTableMap::getValueSet(DocumentLogTableMap::COL_STATUS);
            if (!in_array($v, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $v));
            }
            $v = array_search($v, $valueSet);
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[DocumentLogTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->created_at->format("Y-m-d H:i:s.u")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DocumentLogTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  string|integer|\DateTimeInterface|null $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->updated_at->format("Y-m-d H:i:s.u")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[DocumentLogTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->status !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : DocumentLogTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : DocumentLogTableMap::translateFieldName('CollectionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->collection_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : DocumentLogTableMap::translateFieldName('ClientId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->client_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : DocumentLogTableMap::translateFieldName('DocumentId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->document_id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : DocumentLogTableMap::translateFieldName('Uuid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->uuid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : DocumentLogTableMap::translateFieldName('Event', TableMap::TYPE_PHPNAME, $indexType)];
            $this->event = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : DocumentLogTableMap::translateFieldName('ProviderRequestedAt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->provider_requested_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : DocumentLogTableMap::translateFieldName('ProviderRespondAt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->provider_respond_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : DocumentLogTableMap::translateFieldName('WebhookRequestedAt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->webhook_requested_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : DocumentLogTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : DocumentLogTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : DocumentLogTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 12; // 12 = DocumentLogTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Box\\Model\\DocumentLog'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aCollection !== null && $this->collection_id !== $this->aCollection->getId()) {
            $this->aCollection = null;
        }
        if ($this->aClient !== null && $this->client_id !== $this->aClient->getId()) {
            $this->aClient = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DocumentLogTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildDocumentLogQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aClient = null;
            $this->aCollection = null;
            $this->collRequestLogs = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see DocumentLog::setDeleted()
     * @see DocumentLog::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentLogTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildDocumentLogQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentLogTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(DocumentLogTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt($highPrecision);
                }
                if (!$this->isColumnModified(DocumentLogTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(DocumentLogTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                DocumentLogTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aClient !== null) {
                if ($this->aClient->isModified() || $this->aClient->isNew()) {
                    $affectedRows += $this->aClient->save($con);
                }
                $this->setClient($this->aClient);
            }

            if ($this->aCollection !== null) {
                if ($this->aCollection->isModified() || $this->aCollection->isNew()) {
                    $affectedRows += $this->aCollection->save($con);
                }
                $this->setCollection($this->aCollection);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->requestLogsScheduledForDeletion !== null) {
                if (!$this->requestLogsScheduledForDeletion->isEmpty()) {
                    \Box\Model\RequestLogQuery::create()
                        ->filterByPrimaryKeys($this->requestLogsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->requestLogsScheduledForDeletion = null;
                }
            }

            if ($this->collRequestLogs !== null) {
                foreach ($this->collRequestLogs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[DocumentLogTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DocumentLogTableMap::COL_ID . ')');
        }
        if (null === $this->id) {
            try {
                $dataFetcher = $con->query("SELECT nextval('box_document_log_id_seq')");
                $this->id = (string) $dataFetcher->fetchColumn();
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', 0, $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DocumentLogTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_COLLECTION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'collection_id';
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_CLIENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'client_id';
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_DOCUMENT_ID)) {
            $modifiedColumns[':p' . $index++]  = 'document_id';
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_UUID)) {
            $modifiedColumns[':p' . $index++]  = 'uuid';
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_EVENT)) {
            $modifiedColumns[':p' . $index++]  = 'event';
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'provider_requested_at';
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_PROVIDER_RESPOND_AT)) {
            $modifiedColumns[':p' . $index++]  = 'provider_respond_at';
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'webhook_requested_at';
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO box_document_log (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'collection_id':
                        $stmt->bindValue($identifier, $this->collection_id, PDO::PARAM_INT);
                        break;
                    case 'client_id':
                        $stmt->bindValue($identifier, $this->client_id, PDO::PARAM_INT);
                        break;
                    case 'document_id':
                        $stmt->bindValue($identifier, $this->document_id, PDO::PARAM_INT);
                        break;
                    case 'uuid':
                        $stmt->bindValue($identifier, $this->uuid, PDO::PARAM_STR);
                        break;
                    case 'event':
                        $stmt->bindValue($identifier, $this->event, PDO::PARAM_STR);
                        break;
                    case 'provider_requested_at':
                        $stmt->bindValue($identifier, $this->provider_requested_at ? $this->provider_requested_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'provider_respond_at':
                        $stmt->bindValue($identifier, $this->provider_respond_at ? $this->provider_respond_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'webhook_requested_at':
                        $stmt->bindValue($identifier, $this->webhook_requested_at ? $this->webhook_requested_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'status':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_INT);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DocumentLogTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getCollectionId();
                break;
            case 2:
                return $this->getClientId();
                break;
            case 3:
                return $this->getDocumentId();
                break;
            case 4:
                return $this->getUuid();
                break;
            case 5:
                return $this->getEvent();
                break;
            case 6:
                return $this->getProviderRequestedAt();
                break;
            case 7:
                return $this->getProviderRespondAt();
                break;
            case 8:
                return $this->getWebhookRequestedAt();
                break;
            case 9:
                return $this->getStatus();
                break;
            case 10:
                return $this->getCreatedAt();
                break;
            case 11:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['DocumentLog'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['DocumentLog'][$this->hashCode()] = true;
        $keys = DocumentLogTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getCollectionId(),
            $keys[2] => $this->getClientId(),
            $keys[3] => $this->getDocumentId(),
            $keys[4] => $this->getUuid(),
            $keys[5] => $this->getEvent(),
            $keys[6] => $this->getProviderRequestedAt(),
            $keys[7] => $this->getProviderRespondAt(),
            $keys[8] => $this->getWebhookRequestedAt(),
            $keys[9] => $this->getStatus(),
            $keys[10] => $this->getCreatedAt(),
            $keys[11] => $this->getUpdatedAt(),
        );
        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[7]] instanceof \DateTimeInterface) {
            $result[$keys[7]] = $result[$keys[7]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[8]] instanceof \DateTimeInterface) {
            $result[$keys[8]] = $result[$keys[8]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[10]] instanceof \DateTimeInterface) {
            $result[$keys[10]] = $result[$keys[10]]->format('Y-m-d H:i:s.u');
        }

        if ($result[$keys[11]] instanceof \DateTimeInterface) {
            $result[$keys[11]] = $result[$keys[11]]->format('Y-m-d H:i:s.u');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aClient) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'client';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'box_client';
                        break;
                    default:
                        $key = 'Client';
                }

                $result[$key] = $this->aClient->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCollection) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'coll';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'box_collection';
                        break;
                    default:
                        $key = 'Collection';
                }

                $result[$key] = $this->aCollection->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collRequestLogs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'requestLogs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'box_request_logs';
                        break;
                    default:
                        $key = 'RequestLogs';
                }

                $result[$key] = $this->collRequestLogs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Box\Model\DocumentLog
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = DocumentLogTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Box\Model\DocumentLog
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setCollectionId($value);
                break;
            case 2:
                $this->setClientId($value);
                break;
            case 3:
                $this->setDocumentId($value);
                break;
            case 4:
                $this->setUuid($value);
                break;
            case 5:
                $this->setEvent($value);
                break;
            case 6:
                $this->setProviderRequestedAt($value);
                break;
            case 7:
                $this->setProviderRespondAt($value);
                break;
            case 8:
                $this->setWebhookRequestedAt($value);
                break;
            case 9:
                $valueSet = DocumentLogTableMap::getValueSet(DocumentLogTableMap::COL_STATUS);
                if (isset($valueSet[$value])) {
                    $value = $valueSet[$value];
                }
                $this->setStatus($value);
                break;
            case 10:
                $this->setCreatedAt($value);
                break;
            case 11:
                $this->setUpdatedAt($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = DocumentLogTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCollectionId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setClientId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDocumentId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUuid($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setEvent($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setProviderRequestedAt($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setProviderRespondAt($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setWebhookRequestedAt($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setStatus($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCreatedAt($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setUpdatedAt($arr[$keys[11]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Box\Model\DocumentLog The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(DocumentLogTableMap::DATABASE_NAME);

        if ($this->isColumnModified(DocumentLogTableMap::COL_ID)) {
            $criteria->add(DocumentLogTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_COLLECTION_ID)) {
            $criteria->add(DocumentLogTableMap::COL_COLLECTION_ID, $this->collection_id);
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_CLIENT_ID)) {
            $criteria->add(DocumentLogTableMap::COL_CLIENT_ID, $this->client_id);
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_DOCUMENT_ID)) {
            $criteria->add(DocumentLogTableMap::COL_DOCUMENT_ID, $this->document_id);
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_UUID)) {
            $criteria->add(DocumentLogTableMap::COL_UUID, $this->uuid);
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_EVENT)) {
            $criteria->add(DocumentLogTableMap::COL_EVENT, $this->event);
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT)) {
            $criteria->add(DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT, $this->provider_requested_at);
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_PROVIDER_RESPOND_AT)) {
            $criteria->add(DocumentLogTableMap::COL_PROVIDER_RESPOND_AT, $this->provider_respond_at);
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT)) {
            $criteria->add(DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT, $this->webhook_requested_at);
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_STATUS)) {
            $criteria->add(DocumentLogTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_CREATED_AT)) {
            $criteria->add(DocumentLogTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(DocumentLogTableMap::COL_UPDATED_AT)) {
            $criteria->add(DocumentLogTableMap::COL_UPDATED_AT, $this->updated_at);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildDocumentLogQuery::create();
        $criteria->add(DocumentLogTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Box\Model\DocumentLog (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCollectionId($this->getCollectionId());
        $copyObj->setClientId($this->getClientId());
        $copyObj->setDocumentId($this->getDocumentId());
        $copyObj->setUuid($this->getUuid());
        $copyObj->setEvent($this->getEvent());
        $copyObj->setProviderRequestedAt($this->getProviderRequestedAt());
        $copyObj->setProviderRespondAt($this->getProviderRespondAt());
        $copyObj->setWebhookRequestedAt($this->getWebhookRequestedAt());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getRequestLogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addRequestLog($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Box\Model\DocumentLog Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildClient object.
     *
     * @param  ChildClient $v
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     * @throws PropelException
     */
    public function setClient(ChildClient $v = null)
    {
        if ($v === null) {
            $this->setClientId(NULL);
        } else {
            $this->setClientId($v->getId());
        }

        $this->aClient = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildClient object, it will not be re-added.
        if ($v !== null) {
            $v->addDocumentLog($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildClient object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildClient The associated ChildClient object.
     * @throws PropelException
     */
    public function getClient(ConnectionInterface $con = null)
    {
        if ($this->aClient === null && ($this->client_id != 0)) {
            $this->aClient = ChildClientQuery::create()->findPk($this->client_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aClient->addDocumentLogs($this);
             */
        }

        return $this->aClient;
    }

    /**
     * Declares an association between this object and a ChildColl object.
     *
     * @param  ChildColl $v
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCollection(ChildColl $v = null)
    {
        if ($v === null) {
            $this->setCollectionId(NULL);
        } else {
            $this->setCollectionId($v->getId());
        }

        $this->aCollection = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildColl object, it will not be re-added.
        if ($v !== null) {
            $v->addDocumentLog($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildColl object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildColl The associated ChildColl object.
     * @throws PropelException
     */
    public function getCollection(ConnectionInterface $con = null)
    {
        if ($this->aCollection === null && ($this->collection_id != 0)) {
            $this->aCollection = ChildCollQuery::create()->findPk($this->collection_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCollection->addDocumentLogs($this);
             */
        }

        return $this->aCollection;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('RequestLog' === $relationName) {
            $this->initRequestLogs();
            return;
        }
    }

    /**
     * Clears out the collRequestLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addRequestLogs()
     */
    public function clearRequestLogs()
    {
        $this->collRequestLogs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collRequestLogs collection loaded partially.
     */
    public function resetPartialRequestLogs($v = true)
    {
        $this->collRequestLogsPartial = $v;
    }

    /**
     * Initializes the collRequestLogs collection.
     *
     * By default this just sets the collRequestLogs collection to an empty array (like clearcollRequestLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initRequestLogs($overrideExisting = true)
    {
        if (null !== $this->collRequestLogs && !$overrideExisting) {
            return;
        }

        $collectionClassName = RequestLogTableMap::getTableMap()->getCollectionClassName();

        $this->collRequestLogs = new $collectionClassName;
        $this->collRequestLogs->setModel('\Box\Model\RequestLog');
    }

    /**
     * Gets an array of ChildRequestLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildDocumentLog is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildRequestLog[] List of ChildRequestLog objects
     * @throws PropelException
     */
    public function getRequestLogs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collRequestLogsPartial && !$this->isNew();
        if (null === $this->collRequestLogs || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collRequestLogs) {
                    $this->initRequestLogs();
                } else {
                    $collectionClassName = RequestLogTableMap::getTableMap()->getCollectionClassName();

                    $collRequestLogs = new $collectionClassName;
                    $collRequestLogs->setModel('\Box\Model\RequestLog');

                    return $collRequestLogs;
                }
            } else {
                $collRequestLogs = ChildRequestLogQuery::create(null, $criteria)
                    ->filterByDocumentLog($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collRequestLogsPartial && count($collRequestLogs)) {
                        $this->initRequestLogs(false);

                        foreach ($collRequestLogs as $obj) {
                            if (false == $this->collRequestLogs->contains($obj)) {
                                $this->collRequestLogs->append($obj);
                            }
                        }

                        $this->collRequestLogsPartial = true;
                    }

                    return $collRequestLogs;
                }

                if ($partial && $this->collRequestLogs) {
                    foreach ($this->collRequestLogs as $obj) {
                        if ($obj->isNew()) {
                            $collRequestLogs[] = $obj;
                        }
                    }
                }

                $this->collRequestLogs = $collRequestLogs;
                $this->collRequestLogsPartial = false;
            }
        }

        return $this->collRequestLogs;
    }

    /**
     * Sets a collection of ChildRequestLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $requestLogs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildDocumentLog The current object (for fluent API support)
     */
    public function setRequestLogs(Collection $requestLogs, ConnectionInterface $con = null)
    {
        /** @var ChildRequestLog[] $requestLogsToDelete */
        $requestLogsToDelete = $this->getRequestLogs(new Criteria(), $con)->diff($requestLogs);


        $this->requestLogsScheduledForDeletion = $requestLogsToDelete;

        foreach ($requestLogsToDelete as $requestLogRemoved) {
            $requestLogRemoved->setDocumentLog(null);
        }

        $this->collRequestLogs = null;
        foreach ($requestLogs as $requestLog) {
            $this->addRequestLog($requestLog);
        }

        $this->collRequestLogs = $requestLogs;
        $this->collRequestLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related RequestLog objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related RequestLog objects.
     * @throws PropelException
     */
    public function countRequestLogs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collRequestLogsPartial && !$this->isNew();
        if (null === $this->collRequestLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collRequestLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getRequestLogs());
            }

            $query = ChildRequestLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDocumentLog($this)
                ->count($con);
        }

        return count($this->collRequestLogs);
    }

    /**
     * Method called to associate a ChildRequestLog object to this object
     * through the ChildRequestLog foreign key attribute.
     *
     * @param  ChildRequestLog $l ChildRequestLog
     * @return $this|\Box\Model\DocumentLog The current object (for fluent API support)
     */
    public function addRequestLog(ChildRequestLog $l)
    {
        if ($this->collRequestLogs === null) {
            $this->initRequestLogs();
            $this->collRequestLogsPartial = true;
        }

        if (!$this->collRequestLogs->contains($l)) {
            $this->doAddRequestLog($l);

            if ($this->requestLogsScheduledForDeletion and $this->requestLogsScheduledForDeletion->contains($l)) {
                $this->requestLogsScheduledForDeletion->remove($this->requestLogsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildRequestLog $requestLog The ChildRequestLog object to add.
     */
    protected function doAddRequestLog(ChildRequestLog $requestLog)
    {
        $this->collRequestLogs[]= $requestLog;
        $requestLog->setDocumentLog($this);
    }

    /**
     * @param  ChildRequestLog $requestLog The ChildRequestLog object to remove.
     * @return $this|ChildDocumentLog The current object (for fluent API support)
     */
    public function removeRequestLog(ChildRequestLog $requestLog)
    {
        if ($this->getRequestLogs()->contains($requestLog)) {
            $pos = $this->collRequestLogs->search($requestLog);
            $this->collRequestLogs->remove($pos);
            if (null === $this->requestLogsScheduledForDeletion) {
                $this->requestLogsScheduledForDeletion = clone $this->collRequestLogs;
                $this->requestLogsScheduledForDeletion->clear();
            }
            $this->requestLogsScheduledForDeletion[]= clone $requestLog;
            $requestLog->setDocumentLog(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aClient) {
            $this->aClient->removeDocumentLog($this);
        }
        if (null !== $this->aCollection) {
            $this->aCollection->removeDocumentLog($this);
        }
        $this->id = null;
        $this->collection_id = null;
        $this->client_id = null;
        $this->document_id = null;
        $this->uuid = null;
        $this->event = null;
        $this->provider_requested_at = null;
        $this->provider_respond_at = null;
        $this->webhook_requested_at = null;
        $this->status = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collRequestLogs) {
                foreach ($this->collRequestLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collRequestLogs = null;
        $this->aClient = null;
        $this->aCollection = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DocumentLogTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildDocumentLog The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[DocumentLogTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
