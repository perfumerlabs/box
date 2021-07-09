<?php

namespace Box\Model\Base;

use \Exception;
use \PDO;
use Box\Model\RequestLog as ChildRequestLog;
use Box\Model\RequestLogQuery as ChildRequestLogQuery;
use Box\Model\Map\RequestLogTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'box_request_log' table.
 *
 *
 *
 * @method     ChildRequestLogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildRequestLogQuery orderByDocumentLogId($order = Criteria::ASC) Order by the document_log_id column
 * @method     ChildRequestLogQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildRequestLogQuery orderByRequestUrl($order = Criteria::ASC) Order by the request_url column
 * @method     ChildRequestLogQuery orderByRequestMethod($order = Criteria::ASC) Order by the request_method column
 * @method     ChildRequestLogQuery orderByRequestHeaders($order = Criteria::ASC) Order by the request_headers column
 * @method     ChildRequestLogQuery orderByRequestBody($order = Criteria::ASC) Order by the request_body column
 * @method     ChildRequestLogQuery orderByResponseStatusCode($order = Criteria::ASC) Order by the response_status_code column
 * @method     ChildRequestLogQuery orderByResponseHeaders($order = Criteria::ASC) Order by the response_headers column
 * @method     ChildRequestLogQuery orderByResponseBody($order = Criteria::ASC) Order by the response_body column
 * @method     ChildRequestLogQuery orderByResponseError($order = Criteria::ASC) Order by the response_error column
 * @method     ChildRequestLogQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildRequestLogQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildRequestLogQuery groupById() Group by the id column
 * @method     ChildRequestLogQuery groupByDocumentLogId() Group by the document_log_id column
 * @method     ChildRequestLogQuery groupByType() Group by the type column
 * @method     ChildRequestLogQuery groupByRequestUrl() Group by the request_url column
 * @method     ChildRequestLogQuery groupByRequestMethod() Group by the request_method column
 * @method     ChildRequestLogQuery groupByRequestHeaders() Group by the request_headers column
 * @method     ChildRequestLogQuery groupByRequestBody() Group by the request_body column
 * @method     ChildRequestLogQuery groupByResponseStatusCode() Group by the response_status_code column
 * @method     ChildRequestLogQuery groupByResponseHeaders() Group by the response_headers column
 * @method     ChildRequestLogQuery groupByResponseBody() Group by the response_body column
 * @method     ChildRequestLogQuery groupByResponseError() Group by the response_error column
 * @method     ChildRequestLogQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildRequestLogQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildRequestLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildRequestLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildRequestLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildRequestLogQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildRequestLogQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildRequestLogQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildRequestLogQuery leftJoinDocumentLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentLog relation
 * @method     ChildRequestLogQuery rightJoinDocumentLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentLog relation
 * @method     ChildRequestLogQuery innerJoinDocumentLog($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentLog relation
 *
 * @method     ChildRequestLogQuery joinWithDocumentLog($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DocumentLog relation
 *
 * @method     ChildRequestLogQuery leftJoinWithDocumentLog() Adds a LEFT JOIN clause and with to the query using the DocumentLog relation
 * @method     ChildRequestLogQuery rightJoinWithDocumentLog() Adds a RIGHT JOIN clause and with to the query using the DocumentLog relation
 * @method     ChildRequestLogQuery innerJoinWithDocumentLog() Adds a INNER JOIN clause and with to the query using the DocumentLog relation
 *
 * @method     \Box\Model\DocumentLogQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildRequestLog|null findOne(ConnectionInterface $con = null) Return the first ChildRequestLog matching the query
 * @method     ChildRequestLog findOneOrCreate(ConnectionInterface $con = null) Return the first ChildRequestLog matching the query, or a new ChildRequestLog object populated from the query conditions when no match is found
 *
 * @method     ChildRequestLog|null findOneById(string $id) Return the first ChildRequestLog filtered by the id column
 * @method     ChildRequestLog|null findOneByDocumentLogId(string $document_log_id) Return the first ChildRequestLog filtered by the document_log_id column
 * @method     ChildRequestLog|null findOneByType(int $type) Return the first ChildRequestLog filtered by the type column
 * @method     ChildRequestLog|null findOneByRequestUrl(string $request_url) Return the first ChildRequestLog filtered by the request_url column
 * @method     ChildRequestLog|null findOneByRequestMethod(string $request_method) Return the first ChildRequestLog filtered by the request_method column
 * @method     ChildRequestLog|null findOneByRequestHeaders(string $request_headers) Return the first ChildRequestLog filtered by the request_headers column
 * @method     ChildRequestLog|null findOneByRequestBody(string $request_body) Return the first ChildRequestLog filtered by the request_body column
 * @method     ChildRequestLog|null findOneByResponseStatusCode(int $response_status_code) Return the first ChildRequestLog filtered by the response_status_code column
 * @method     ChildRequestLog|null findOneByResponseHeaders(string $response_headers) Return the first ChildRequestLog filtered by the response_headers column
 * @method     ChildRequestLog|null findOneByResponseBody(string $response_body) Return the first ChildRequestLog filtered by the response_body column
 * @method     ChildRequestLog|null findOneByResponseError(string $response_error) Return the first ChildRequestLog filtered by the response_error column
 * @method     ChildRequestLog|null findOneByCreatedAt(string $created_at) Return the first ChildRequestLog filtered by the created_at column
 * @method     ChildRequestLog|null findOneByUpdatedAt(string $updated_at) Return the first ChildRequestLog filtered by the updated_at column *

 * @method     ChildRequestLog requirePk($key, ConnectionInterface $con = null) Return the ChildRequestLog by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOne(ConnectionInterface $con = null) Return the first ChildRequestLog matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRequestLog requireOneById(string $id) Return the first ChildRequestLog filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByDocumentLogId(string $document_log_id) Return the first ChildRequestLog filtered by the document_log_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByType(int $type) Return the first ChildRequestLog filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByRequestUrl(string $request_url) Return the first ChildRequestLog filtered by the request_url column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByRequestMethod(string $request_method) Return the first ChildRequestLog filtered by the request_method column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByRequestHeaders(string $request_headers) Return the first ChildRequestLog filtered by the request_headers column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByRequestBody(string $request_body) Return the first ChildRequestLog filtered by the request_body column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByResponseStatusCode(int $response_status_code) Return the first ChildRequestLog filtered by the response_status_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByResponseHeaders(string $response_headers) Return the first ChildRequestLog filtered by the response_headers column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByResponseBody(string $response_body) Return the first ChildRequestLog filtered by the response_body column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByResponseError(string $response_error) Return the first ChildRequestLog filtered by the response_error column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByCreatedAt(string $created_at) Return the first ChildRequestLog filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildRequestLog requireOneByUpdatedAt(string $updated_at) Return the first ChildRequestLog filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildRequestLog[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildRequestLog objects based on current ModelCriteria
 * @method     ChildRequestLog[]|ObjectCollection findById(string $id) Return ChildRequestLog objects filtered by the id column
 * @method     ChildRequestLog[]|ObjectCollection findByDocumentLogId(string $document_log_id) Return ChildRequestLog objects filtered by the document_log_id column
 * @method     ChildRequestLog[]|ObjectCollection findByType(int $type) Return ChildRequestLog objects filtered by the type column
 * @method     ChildRequestLog[]|ObjectCollection findByRequestUrl(string $request_url) Return ChildRequestLog objects filtered by the request_url column
 * @method     ChildRequestLog[]|ObjectCollection findByRequestMethod(string $request_method) Return ChildRequestLog objects filtered by the request_method column
 * @method     ChildRequestLog[]|ObjectCollection findByRequestHeaders(string $request_headers) Return ChildRequestLog objects filtered by the request_headers column
 * @method     ChildRequestLog[]|ObjectCollection findByRequestBody(string $request_body) Return ChildRequestLog objects filtered by the request_body column
 * @method     ChildRequestLog[]|ObjectCollection findByResponseStatusCode(int $response_status_code) Return ChildRequestLog objects filtered by the response_status_code column
 * @method     ChildRequestLog[]|ObjectCollection findByResponseHeaders(string $response_headers) Return ChildRequestLog objects filtered by the response_headers column
 * @method     ChildRequestLog[]|ObjectCollection findByResponseBody(string $response_body) Return ChildRequestLog objects filtered by the response_body column
 * @method     ChildRequestLog[]|ObjectCollection findByResponseError(string $response_error) Return ChildRequestLog objects filtered by the response_error column
 * @method     ChildRequestLog[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildRequestLog objects filtered by the created_at column
 * @method     ChildRequestLog[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildRequestLog objects filtered by the updated_at column
 * @method     ChildRequestLog[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class RequestLogQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Box\Model\Base\RequestLogQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'box', $modelName = '\\Box\\Model\\RequestLog', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildRequestLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildRequestLogQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildRequestLogQuery) {
            return $criteria;
        }
        $query = new ChildRequestLogQuery();
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
     * @return ChildRequestLog|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(RequestLogTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = RequestLogTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildRequestLog A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, document_log_id, type, request_url, request_method, request_headers, request_body, response_status_code, response_headers, response_body, response_error, created_at, updated_at FROM box_request_log WHERE id = :p0';
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
            /** @var ChildRequestLog $obj */
            $obj = new ChildRequestLog();
            $obj->hydrate($row);
            RequestLogTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildRequestLog|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(RequestLogTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(RequestLogTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(RequestLogTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(RequestLogTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the document_log_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDocumentLogId(1234); // WHERE document_log_id = 1234
     * $query->filterByDocumentLogId(array(12, 34)); // WHERE document_log_id IN (12, 34)
     * $query->filterByDocumentLogId(array('min' => 12)); // WHERE document_log_id > 12
     * </code>
     *
     * @see       filterByDocumentLog()
     *
     * @param     mixed $documentLogId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByDocumentLogId($documentLogId = null, $comparison = null)
    {
        if (is_array($documentLogId)) {
            $useMinMax = false;
            if (isset($documentLogId['min'])) {
                $this->addUsingAlias(RequestLogTableMap::COL_DOCUMENT_LOG_ID, $documentLogId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($documentLogId['max'])) {
                $this->addUsingAlias(RequestLogTableMap::COL_DOCUMENT_LOG_ID, $documentLogId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_DOCUMENT_LOG_ID, $documentLogId, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        $valueSet = RequestLogTableMap::getValueSet(RequestLogTableMap::COL_TYPE);
        if (is_scalar($type)) {
            if (!in_array($type, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $type));
            }
            $type = array_search($type, $valueSet);
        } elseif (is_array($type)) {
            $convertedValues = array();
            foreach ($type as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $type = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the request_url column
     *
     * Example usage:
     * <code>
     * $query->filterByRequestUrl('fooValue');   // WHERE request_url = 'fooValue'
     * $query->filterByRequestUrl('%fooValue%', Criteria::LIKE); // WHERE request_url LIKE '%fooValue%'
     * </code>
     *
     * @param     string $requestUrl The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByRequestUrl($requestUrl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($requestUrl)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_REQUEST_URL, $requestUrl, $comparison);
    }

    /**
     * Filter the query on the request_method column
     *
     * Example usage:
     * <code>
     * $query->filterByRequestMethod('fooValue');   // WHERE request_method = 'fooValue'
     * $query->filterByRequestMethod('%fooValue%', Criteria::LIKE); // WHERE request_method LIKE '%fooValue%'
     * </code>
     *
     * @param     string $requestMethod The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByRequestMethod($requestMethod = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($requestMethod)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_REQUEST_METHOD, $requestMethod, $comparison);
    }

    /**
     * Filter the query on the request_headers column
     *
     * Example usage:
     * <code>
     * $query->filterByRequestHeaders('fooValue');   // WHERE request_headers = 'fooValue'
     * $query->filterByRequestHeaders('%fooValue%', Criteria::LIKE); // WHERE request_headers LIKE '%fooValue%'
     * </code>
     *
     * @param     string $requestHeaders The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByRequestHeaders($requestHeaders = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($requestHeaders)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_REQUEST_HEADERS, $requestHeaders, $comparison);
    }

    /**
     * Filter the query on the request_body column
     *
     * Example usage:
     * <code>
     * $query->filterByRequestBody('fooValue');   // WHERE request_body = 'fooValue'
     * $query->filterByRequestBody('%fooValue%', Criteria::LIKE); // WHERE request_body LIKE '%fooValue%'
     * </code>
     *
     * @param     string $requestBody The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByRequestBody($requestBody = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($requestBody)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_REQUEST_BODY, $requestBody, $comparison);
    }

    /**
     * Filter the query on the response_status_code column
     *
     * Example usage:
     * <code>
     * $query->filterByResponseStatusCode(1234); // WHERE response_status_code = 1234
     * $query->filterByResponseStatusCode(array(12, 34)); // WHERE response_status_code IN (12, 34)
     * $query->filterByResponseStatusCode(array('min' => 12)); // WHERE response_status_code > 12
     * </code>
     *
     * @param     mixed $responseStatusCode The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByResponseStatusCode($responseStatusCode = null, $comparison = null)
    {
        if (is_array($responseStatusCode)) {
            $useMinMax = false;
            if (isset($responseStatusCode['min'])) {
                $this->addUsingAlias(RequestLogTableMap::COL_RESPONSE_STATUS_CODE, $responseStatusCode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($responseStatusCode['max'])) {
                $this->addUsingAlias(RequestLogTableMap::COL_RESPONSE_STATUS_CODE, $responseStatusCode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_RESPONSE_STATUS_CODE, $responseStatusCode, $comparison);
    }

    /**
     * Filter the query on the response_headers column
     *
     * Example usage:
     * <code>
     * $query->filterByResponseHeaders('fooValue');   // WHERE response_headers = 'fooValue'
     * $query->filterByResponseHeaders('%fooValue%', Criteria::LIKE); // WHERE response_headers LIKE '%fooValue%'
     * </code>
     *
     * @param     string $responseHeaders The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByResponseHeaders($responseHeaders = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($responseHeaders)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_RESPONSE_HEADERS, $responseHeaders, $comparison);
    }

    /**
     * Filter the query on the response_body column
     *
     * Example usage:
     * <code>
     * $query->filterByResponseBody('fooValue');   // WHERE response_body = 'fooValue'
     * $query->filterByResponseBody('%fooValue%', Criteria::LIKE); // WHERE response_body LIKE '%fooValue%'
     * </code>
     *
     * @param     string $responseBody The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByResponseBody($responseBody = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($responseBody)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_RESPONSE_BODY, $responseBody, $comparison);
    }

    /**
     * Filter the query on the response_error column
     *
     * Example usage:
     * <code>
     * $query->filterByResponseError('fooValue');   // WHERE response_error = 'fooValue'
     * $query->filterByResponseError('%fooValue%', Criteria::LIKE); // WHERE response_error LIKE '%fooValue%'
     * </code>
     *
     * @param     string $responseError The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByResponseError($responseError = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($responseError)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_RESPONSE_ERROR, $responseError, $comparison);
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
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(RequestLogTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(RequestLogTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(RequestLogTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(RequestLogTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(RequestLogTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Box\Model\DocumentLog object
     *
     * @param \Box\Model\DocumentLog|ObjectCollection $documentLog The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildRequestLogQuery The current query, for fluid interface
     */
    public function filterByDocumentLog($documentLog, $comparison = null)
    {
        if ($documentLog instanceof \Box\Model\DocumentLog) {
            return $this
                ->addUsingAlias(RequestLogTableMap::COL_DOCUMENT_LOG_ID, $documentLog->getId(), $comparison);
        } elseif ($documentLog instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(RequestLogTableMap::COL_DOCUMENT_LOG_ID, $documentLog->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByDocumentLog() only accepts arguments of type \Box\Model\DocumentLog or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the DocumentLog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function joinDocumentLog($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('DocumentLog');

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
            $this->addJoinObject($join, 'DocumentLog');
        }

        return $this;
    }

    /**
     * Use the DocumentLog relation DocumentLog object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Box\Model\DocumentLogQuery A secondary query class using the current class as primary query
     */
    public function useDocumentLogQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDocumentLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'DocumentLog', '\Box\Model\DocumentLogQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildRequestLog $requestLog Object to remove from the list of results
     *
     * @return $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function prune($requestLog = null)
    {
        if ($requestLog) {
            $this->addUsingAlias(RequestLogTableMap::COL_ID, $requestLog->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the box_request_log table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(RequestLogTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            RequestLogTableMap::clearInstancePool();
            RequestLogTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(RequestLogTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(RequestLogTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            RequestLogTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            RequestLogTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(RequestLogTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(RequestLogTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(RequestLogTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(RequestLogTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(RequestLogTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildRequestLogQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(RequestLogTableMap::COL_CREATED_AT);
    }

} // RequestLogQuery
