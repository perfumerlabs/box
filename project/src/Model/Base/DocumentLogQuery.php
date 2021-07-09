<?php

namespace Box\Model\Base;

use \Exception;
use \PDO;
use Box\Model\DocumentLog as ChildDocumentLog;
use Box\Model\DocumentLogQuery as ChildDocumentLogQuery;
use Box\Model\Map\DocumentLogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'box_document_log' table.
 *
 *
 *
 * @method     ChildDocumentLogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildDocumentLogQuery orderByCollectionId($order = Criteria::ASC) Order by the collection_id column
 * @method     ChildDocumentLogQuery orderByClientId($order = Criteria::ASC) Order by the client_id column
 * @method     ChildDocumentLogQuery orderByDocumentId($order = Criteria::ASC) Order by the document_id column
 * @method     ChildDocumentLogQuery orderByUuid($order = Criteria::ASC) Order by the uuid column
 * @method     ChildDocumentLogQuery orderByEvent($order = Criteria::ASC) Order by the event column
 * @method     ChildDocumentLogQuery orderByProviderRequestedAt($order = Criteria::ASC) Order by the provider_requested_at column
 * @method     ChildDocumentLogQuery orderByProviderRespondAt($order = Criteria::ASC) Order by the provider_respond_at column
 * @method     ChildDocumentLogQuery orderByWebhookRequestedAt($order = Criteria::ASC) Order by the webhook_requested_at column
 * @method     ChildDocumentLogQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildDocumentLogQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildDocumentLogQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildDocumentLogQuery groupById() Group by the id column
 * @method     ChildDocumentLogQuery groupByCollectionId() Group by the collection_id column
 * @method     ChildDocumentLogQuery groupByClientId() Group by the client_id column
 * @method     ChildDocumentLogQuery groupByDocumentId() Group by the document_id column
 * @method     ChildDocumentLogQuery groupByUuid() Group by the uuid column
 * @method     ChildDocumentLogQuery groupByEvent() Group by the event column
 * @method     ChildDocumentLogQuery groupByProviderRequestedAt() Group by the provider_requested_at column
 * @method     ChildDocumentLogQuery groupByProviderRespondAt() Group by the provider_respond_at column
 * @method     ChildDocumentLogQuery groupByWebhookRequestedAt() Group by the webhook_requested_at column
 * @method     ChildDocumentLogQuery groupByStatus() Group by the status column
 * @method     ChildDocumentLogQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildDocumentLogQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildDocumentLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildDocumentLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildDocumentLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildDocumentLogQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildDocumentLogQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildDocumentLogQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildDocumentLogQuery leftJoinClient($relationAlias = null) Adds a LEFT JOIN clause to the query using the Client relation
 * @method     ChildDocumentLogQuery rightJoinClient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Client relation
 * @method     ChildDocumentLogQuery innerJoinClient($relationAlias = null) Adds a INNER JOIN clause to the query using the Client relation
 *
 * @method     ChildDocumentLogQuery joinWithClient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Client relation
 *
 * @method     ChildDocumentLogQuery leftJoinWithClient() Adds a LEFT JOIN clause and with to the query using the Client relation
 * @method     ChildDocumentLogQuery rightJoinWithClient() Adds a RIGHT JOIN clause and with to the query using the Client relation
 * @method     ChildDocumentLogQuery innerJoinWithClient() Adds a INNER JOIN clause and with to the query using the Client relation
 *
 * @method     ChildDocumentLogQuery leftJoinCollection($relationAlias = null) Adds a LEFT JOIN clause to the query using the Collection relation
 * @method     ChildDocumentLogQuery rightJoinCollection($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Collection relation
 * @method     ChildDocumentLogQuery innerJoinCollection($relationAlias = null) Adds a INNER JOIN clause to the query using the Collection relation
 *
 * @method     ChildDocumentLogQuery joinWithCollection($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Collection relation
 *
 * @method     ChildDocumentLogQuery leftJoinWithCollection() Adds a LEFT JOIN clause and with to the query using the Collection relation
 * @method     ChildDocumentLogQuery rightJoinWithCollection() Adds a RIGHT JOIN clause and with to the query using the Collection relation
 * @method     ChildDocumentLogQuery innerJoinWithCollection() Adds a INNER JOIN clause and with to the query using the Collection relation
 *
 * @method     ChildDocumentLogQuery leftJoinRequestLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the RequestLog relation
 * @method     ChildDocumentLogQuery rightJoinRequestLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the RequestLog relation
 * @method     ChildDocumentLogQuery innerJoinRequestLog($relationAlias = null) Adds a INNER JOIN clause to the query using the RequestLog relation
 *
 * @method     ChildDocumentLogQuery joinWithRequestLog($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the RequestLog relation
 *
 * @method     ChildDocumentLogQuery leftJoinWithRequestLog() Adds a LEFT JOIN clause and with to the query using the RequestLog relation
 * @method     ChildDocumentLogQuery rightJoinWithRequestLog() Adds a RIGHT JOIN clause and with to the query using the RequestLog relation
 * @method     ChildDocumentLogQuery innerJoinWithRequestLog() Adds a INNER JOIN clause and with to the query using the RequestLog relation
 *
 * @method     \Box\Model\ClientQuery|\Box\Model\CollQuery|\Box\Model\RequestLogQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildDocumentLog|null findOne(ConnectionInterface $con = null) Return the first ChildDocumentLog matching the query
 * @method     ChildDocumentLog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildDocumentLog matching the query, or a new ChildDocumentLog object populated from the query conditions when no match is found
 *
 * @method     ChildDocumentLog|null findOneById(string $id) Return the first ChildDocumentLog filtered by the id column
 * @method     ChildDocumentLog|null findOneByCollectionId(int $collection_id) Return the first ChildDocumentLog filtered by the collection_id column
 * @method     ChildDocumentLog|null findOneByClientId(int $client_id) Return the first ChildDocumentLog filtered by the client_id column
 * @method     ChildDocumentLog|null findOneByDocumentId(string $document_id) Return the first ChildDocumentLog filtered by the document_id column
 * @method     ChildDocumentLog|null findOneByUuid(string $uuid) Return the first ChildDocumentLog filtered by the uuid column
 * @method     ChildDocumentLog|null findOneByEvent(string $event) Return the first ChildDocumentLog filtered by the event column
 * @method     ChildDocumentLog|null findOneByProviderRequestedAt(string $provider_requested_at) Return the first ChildDocumentLog filtered by the provider_requested_at column
 * @method     ChildDocumentLog|null findOneByProviderRespondAt(string $provider_respond_at) Return the first ChildDocumentLog filtered by the provider_respond_at column
 * @method     ChildDocumentLog|null findOneByWebhookRequestedAt(string $webhook_requested_at) Return the first ChildDocumentLog filtered by the webhook_requested_at column
 * @method     ChildDocumentLog|null findOneByStatus(int $status) Return the first ChildDocumentLog filtered by the status column
 * @method     ChildDocumentLog|null findOneByCreatedAt(string $created_at) Return the first ChildDocumentLog filtered by the created_at column
 * @method     ChildDocumentLog|null findOneByUpdatedAt(string $updated_at) Return the first ChildDocumentLog filtered by the updated_at column *

 * @method     ChildDocumentLog requirePk($key, ConnectionInterface $con = null) Return the ChildDocumentLog by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOne(ConnectionInterface $con = null) Return the first ChildDocumentLog matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDocumentLog requireOneById(string $id) Return the first ChildDocumentLog filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOneByCollectionId(int $collection_id) Return the first ChildDocumentLog filtered by the collection_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOneByClientId(int $client_id) Return the first ChildDocumentLog filtered by the client_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOneByDocumentId(string $document_id) Return the first ChildDocumentLog filtered by the document_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOneByUuid(string $uuid) Return the first ChildDocumentLog filtered by the uuid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOneByEvent(string $event) Return the first ChildDocumentLog filtered by the event column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOneByProviderRequestedAt(string $provider_requested_at) Return the first ChildDocumentLog filtered by the provider_requested_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOneByProviderRespondAt(string $provider_respond_at) Return the first ChildDocumentLog filtered by the provider_respond_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOneByWebhookRequestedAt(string $webhook_requested_at) Return the first ChildDocumentLog filtered by the webhook_requested_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOneByStatus(int $status) Return the first ChildDocumentLog filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOneByCreatedAt(string $created_at) Return the first ChildDocumentLog filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildDocumentLog requireOneByUpdatedAt(string $updated_at) Return the first ChildDocumentLog filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildDocumentLog[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildDocumentLog objects based on current ModelCriteria
 * @method     ChildDocumentLog[]|ObjectCollection findById(string $id) Return ChildDocumentLog objects filtered by the id column
 * @method     ChildDocumentLog[]|ObjectCollection findByCollectionId(int $collection_id) Return ChildDocumentLog objects filtered by the collection_id column
 * @method     ChildDocumentLog[]|ObjectCollection findByClientId(int $client_id) Return ChildDocumentLog objects filtered by the client_id column
 * @method     ChildDocumentLog[]|ObjectCollection findByDocumentId(string $document_id) Return ChildDocumentLog objects filtered by the document_id column
 * @method     ChildDocumentLog[]|ObjectCollection findByUuid(string $uuid) Return ChildDocumentLog objects filtered by the uuid column
 * @method     ChildDocumentLog[]|ObjectCollection findByEvent(string $event) Return ChildDocumentLog objects filtered by the event column
 * @method     ChildDocumentLog[]|ObjectCollection findByProviderRequestedAt(string $provider_requested_at) Return ChildDocumentLog objects filtered by the provider_requested_at column
 * @method     ChildDocumentLog[]|ObjectCollection findByProviderRespondAt(string $provider_respond_at) Return ChildDocumentLog objects filtered by the provider_respond_at column
 * @method     ChildDocumentLog[]|ObjectCollection findByWebhookRequestedAt(string $webhook_requested_at) Return ChildDocumentLog objects filtered by the webhook_requested_at column
 * @method     ChildDocumentLog[]|ObjectCollection findByStatus(int $status) Return ChildDocumentLog objects filtered by the status column
 * @method     ChildDocumentLog[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildDocumentLog objects filtered by the created_at column
 * @method     ChildDocumentLog[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildDocumentLog objects filtered by the updated_at column
 * @method     ChildDocumentLog[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class DocumentLogQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Box\Model\Base\DocumentLogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'box', $modelName = '\\Box\\Model\\DocumentLog', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildDocumentLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildDocumentLogQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildDocumentLogQuery) {
            return $criteria;
        }
        $query = new ChildDocumentLogQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildDocumentLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(DocumentLogTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = DocumentLogTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDocumentLog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, collection_id, client_id, document_id, uuid, event, provider_requested_at, provider_respond_at, webhook_requested_at, status, created_at, updated_at FROM box_document_log WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildDocumentLog $obj */
            $obj = new ChildDocumentLog();
            $obj->hydrate($row);
            DocumentLogTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildDocumentLog|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DocumentLogTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DocumentLogTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the collection_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCollectionId(1234); // WHERE collection_id = 1234
     * $query->filterByCollectionId(array(12, 34)); // WHERE collection_id IN (12, 34)
     * $query->filterByCollectionId(array('min' => 12)); // WHERE collection_id > 12
     * </code>
     *
     * @see       filterByCollection()
     *
     * @param     mixed $collectionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByCollectionId($collectionId = null, $comparison = null)
    {
        if (is_array($collectionId)) {
            $useMinMax = false;
            if (isset($collectionId['min'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_COLLECTION_ID, $collectionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($collectionId['max'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_COLLECTION_ID, $collectionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_COLLECTION_ID, $collectionId, $comparison);
    }

    /**
     * Filter the query on the client_id column
     *
     * Example usage:
     * <code>
     * $query->filterByClientId(1234); // WHERE client_id = 1234
     * $query->filterByClientId(array(12, 34)); // WHERE client_id IN (12, 34)
     * $query->filterByClientId(array('min' => 12)); // WHERE client_id > 12
     * </code>
     *
     * @see       filterByClient()
     *
     * @param     mixed $clientId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByClientId($clientId = null, $comparison = null)
    {
        if (is_array($clientId)) {
            $useMinMax = false;
            if (isset($clientId['min'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_CLIENT_ID, $clientId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clientId['max'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_CLIENT_ID, $clientId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_CLIENT_ID, $clientId, $comparison);
    }

    /**
     * Filter the query on the document_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDocumentId(1234); // WHERE document_id = 1234
     * $query->filterByDocumentId(array(12, 34)); // WHERE document_id IN (12, 34)
     * $query->filterByDocumentId(array('min' => 12)); // WHERE document_id > 12
     * </code>
     *
     * @param     mixed $documentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByDocumentId($documentId = null, $comparison = null)
    {
        if (is_array($documentId)) {
            $useMinMax = false;
            if (isset($documentId['min'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_DOCUMENT_ID, $documentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($documentId['max'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_DOCUMENT_ID, $documentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_DOCUMENT_ID, $documentId, $comparison);
    }

    /**
     * Filter the query on the uuid column
     *
     * Example usage:
     * <code>
     * $query->filterByUuid('fooValue');   // WHERE uuid = 'fooValue'
     * $query->filterByUuid('%fooValue%', Criteria::LIKE); // WHERE uuid LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uuid The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByUuid($uuid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uuid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_UUID, $uuid, $comparison);
    }

    /**
     * Filter the query on the event column
     *
     * Example usage:
     * <code>
     * $query->filterByEvent('fooValue');   // WHERE event = 'fooValue'
     * $query->filterByEvent('%fooValue%', Criteria::LIKE); // WHERE event LIKE '%fooValue%'
     * </code>
     *
     * @param     string $event The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByEvent($event = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($event)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_EVENT, $event, $comparison);
    }

    /**
     * Filter the query on the provider_requested_at column
     *
     * Example usage:
     * <code>
     * $query->filterByProviderRequestedAt('2011-03-14'); // WHERE provider_requested_at = '2011-03-14'
     * $query->filterByProviderRequestedAt('now'); // WHERE provider_requested_at = '2011-03-14'
     * $query->filterByProviderRequestedAt(array('max' => 'yesterday')); // WHERE provider_requested_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $providerRequestedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByProviderRequestedAt($providerRequestedAt = null, $comparison = null)
    {
        if (is_array($providerRequestedAt)) {
            $useMinMax = false;
            if (isset($providerRequestedAt['min'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT, $providerRequestedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($providerRequestedAt['max'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT, $providerRequestedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_PROVIDER_REQUESTED_AT, $providerRequestedAt, $comparison);
    }

    /**
     * Filter the query on the provider_respond_at column
     *
     * Example usage:
     * <code>
     * $query->filterByProviderRespondAt('2011-03-14'); // WHERE provider_respond_at = '2011-03-14'
     * $query->filterByProviderRespondAt('now'); // WHERE provider_respond_at = '2011-03-14'
     * $query->filterByProviderRespondAt(array('max' => 'yesterday')); // WHERE provider_respond_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $providerRespondAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByProviderRespondAt($providerRespondAt = null, $comparison = null)
    {
        if (is_array($providerRespondAt)) {
            $useMinMax = false;
            if (isset($providerRespondAt['min'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_PROVIDER_RESPOND_AT, $providerRespondAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($providerRespondAt['max'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_PROVIDER_RESPOND_AT, $providerRespondAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_PROVIDER_RESPOND_AT, $providerRespondAt, $comparison);
    }

    /**
     * Filter the query on the webhook_requested_at column
     *
     * Example usage:
     * <code>
     * $query->filterByWebhookRequestedAt('2011-03-14'); // WHERE webhook_requested_at = '2011-03-14'
     * $query->filterByWebhookRequestedAt('now'); // WHERE webhook_requested_at = '2011-03-14'
     * $query->filterByWebhookRequestedAt(array('max' => 'yesterday')); // WHERE webhook_requested_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $webhookRequestedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByWebhookRequestedAt($webhookRequestedAt = null, $comparison = null)
    {
        if (is_array($webhookRequestedAt)) {
            $useMinMax = false;
            if (isset($webhookRequestedAt['min'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT, $webhookRequestedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($webhookRequestedAt['max'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT, $webhookRequestedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_WEBHOOK_REQUESTED_AT, $webhookRequestedAt, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * @param     mixed $status The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        $valueSet = DocumentLogTableMap::getValueSet(DocumentLogTableMap::COL_STATUS);
        if (is_scalar($status)) {
            if (!in_array($status, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $status));
            }
            $status = array_search($status, $valueSet);
        } elseif (is_array($status)) {
            $convertedValues = array();
            foreach ($status as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $status = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(DocumentLogTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DocumentLogTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Box\Model\Client object
     *
     * @param \Box\Model\Client|ObjectCollection $client The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByClient($client, $comparison = null)
    {
        if ($client instanceof \Box\Model\Client) {
            return $this
                ->addUsingAlias(DocumentLogTableMap::COL_CLIENT_ID, $client->getId(), $comparison);
        } elseif ($client instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentLogTableMap::COL_CLIENT_ID, $client->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByClient() only accepts arguments of type \Box\Model\Client or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Client relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function joinClient($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Client');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Client');
        }

        return $this;
    }

    /**
     * Use the Client relation Client object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Box\Model\ClientQuery A secondary query class using the current class as primary query
     */
    public function useClientQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinClient($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Client', '\Box\Model\ClientQuery');
    }

    /**
     * Filter the query by a related \Box\Model\Coll object
     *
     * @param \Box\Model\Coll|ObjectCollection $coll The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByCollection($coll, $comparison = null)
    {
        if ($coll instanceof \Box\Model\Coll) {
            return $this
                ->addUsingAlias(DocumentLogTableMap::COL_COLLECTION_ID, $coll->getId(), $comparison);
        } elseif ($coll instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DocumentLogTableMap::COL_COLLECTION_ID, $coll->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCollection() only accepts arguments of type \Box\Model\Coll or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Collection relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function joinCollection($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Collection');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Collection');
        }

        return $this;
    }

    /**
     * Use the Collection relation Coll object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Box\Model\CollQuery A secondary query class using the current class as primary query
     */
    public function useCollectionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCollection($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Collection', '\Box\Model\CollQuery');
    }

    /**
     * Filter the query by a related \Box\Model\RequestLog object
     *
     * @param \Box\Model\RequestLog|ObjectCollection $requestLog the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildDocumentLogQuery The current query, for fluid interface
     */
    public function filterByRequestLog($requestLog, $comparison = null)
    {
        if ($requestLog instanceof \Box\Model\RequestLog) {
            return $this
                ->addUsingAlias(DocumentLogTableMap::COL_ID, $requestLog->getDocumentLogId(), $comparison);
        } elseif ($requestLog instanceof ObjectCollection) {
            return $this
                ->useRequestLogQuery()
                ->filterByPrimaryKeys($requestLog->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRequestLog() only accepts arguments of type \Box\Model\RequestLog or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the RequestLog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function joinRequestLog($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('RequestLog');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'RequestLog');
        }

        return $this;
    }

    /**
     * Use the RequestLog relation RequestLog object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Box\Model\RequestLogQuery A secondary query class using the current class as primary query
     */
    public function useRequestLogQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRequestLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'RequestLog', '\Box\Model\RequestLogQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildDocumentLog $documentLog Object to remove from the list of results
     *
     * @return $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function prune($documentLog = null)
    {
        if ($documentLog) {
            $this->addUsingAlias(DocumentLogTableMap::COL_ID, $documentLog->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the box_document_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentLogTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            DocumentLogTableMap::clearInstancePool();
            DocumentLogTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(DocumentLogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(DocumentLogTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            DocumentLogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            DocumentLogTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(DocumentLogTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(DocumentLogTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(DocumentLogTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(DocumentLogTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(DocumentLogTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildDocumentLogQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(DocumentLogTableMap::COL_CREATED_AT);
    }

} // DocumentLogQuery
