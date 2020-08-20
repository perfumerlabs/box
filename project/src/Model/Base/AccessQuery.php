<?php

namespace Box\Model\Base;

use \Exception;
use \PDO;
use Box\Model\Access as ChildAccess;
use Box\Model\AccessQuery as ChildAccessQuery;
use Box\Model\Map\AccessTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the '_access' table.
 *
 *
 *
 * @method     ChildAccessQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAccessQuery orderByCollectionId($order = Criteria::ASC) Order by the collection_id column
 * @method     ChildAccessQuery orderByClientId($order = Criteria::ASC) Order by the client_id column
 * @method     ChildAccessQuery orderByLevel($order = Criteria::ASC) Order by the level column
 * @method     ChildAccessQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 *
 * @method     ChildAccessQuery groupById() Group by the id column
 * @method     ChildAccessQuery groupByCollectionId() Group by the collection_id column
 * @method     ChildAccessQuery groupByClientId() Group by the client_id column
 * @method     ChildAccessQuery groupByLevel() Group by the level column
 * @method     ChildAccessQuery groupByCreatedAt() Group by the created_at column
 *
 * @method     ChildAccessQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAccessQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAccessQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAccessQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAccessQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAccessQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAccessQuery leftJoinClient($relationAlias = null) Adds a LEFT JOIN clause to the query using the Client relation
 * @method     ChildAccessQuery rightJoinClient($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Client relation
 * @method     ChildAccessQuery innerJoinClient($relationAlias = null) Adds a INNER JOIN clause to the query using the Client relation
 *
 * @method     ChildAccessQuery joinWithClient($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Client relation
 *
 * @method     ChildAccessQuery leftJoinWithClient() Adds a LEFT JOIN clause and with to the query using the Client relation
 * @method     ChildAccessQuery rightJoinWithClient() Adds a RIGHT JOIN clause and with to the query using the Client relation
 * @method     ChildAccessQuery innerJoinWithClient() Adds a INNER JOIN clause and with to the query using the Client relation
 *
 * @method     ChildAccessQuery leftJoinCollection($relationAlias = null) Adds a LEFT JOIN clause to the query using the Collection relation
 * @method     ChildAccessQuery rightJoinCollection($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Collection relation
 * @method     ChildAccessQuery innerJoinCollection($relationAlias = null) Adds a INNER JOIN clause to the query using the Collection relation
 *
 * @method     ChildAccessQuery joinWithCollection($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Collection relation
 *
 * @method     ChildAccessQuery leftJoinWithCollection() Adds a LEFT JOIN clause and with to the query using the Collection relation
 * @method     ChildAccessQuery rightJoinWithCollection() Adds a RIGHT JOIN clause and with to the query using the Collection relation
 * @method     ChildAccessQuery innerJoinWithCollection() Adds a INNER JOIN clause and with to the query using the Collection relation
 *
 * @method     \Box\Model\ClientQuery|\Box\Model\CollQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAccess findOne(ConnectionInterface $con = null) Return the first ChildAccess matching the query
 * @method     ChildAccess findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAccess matching the query, or a new ChildAccess object populated from the query conditions when no match is found
 *
 * @method     ChildAccess findOneById(int $id) Return the first ChildAccess filtered by the id column
 * @method     ChildAccess findOneByCollectionId(int $collection_id) Return the first ChildAccess filtered by the collection_id column
 * @method     ChildAccess findOneByClientId(int $client_id) Return the first ChildAccess filtered by the client_id column
 * @method     ChildAccess findOneByLevel(int $level) Return the first ChildAccess filtered by the level column
 * @method     ChildAccess findOneByCreatedAt(string $created_at) Return the first ChildAccess filtered by the created_at column *

 * @method     ChildAccess requirePk($key, ConnectionInterface $con = null) Return the ChildAccess by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccess requireOne(ConnectionInterface $con = null) Return the first ChildAccess matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccess requireOneById(int $id) Return the first ChildAccess filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccess requireOneByCollectionId(int $collection_id) Return the first ChildAccess filtered by the collection_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccess requireOneByClientId(int $client_id) Return the first ChildAccess filtered by the client_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccess requireOneByLevel(int $level) Return the first ChildAccess filtered by the level column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAccess requireOneByCreatedAt(string $created_at) Return the first ChildAccess filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAccess[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAccess objects based on current ModelCriteria
 * @method     ChildAccess[]|ObjectCollection findById(int $id) Return ChildAccess objects filtered by the id column
 * @method     ChildAccess[]|ObjectCollection findByCollectionId(int $collection_id) Return ChildAccess objects filtered by the collection_id column
 * @method     ChildAccess[]|ObjectCollection findByClientId(int $client_id) Return ChildAccess objects filtered by the client_id column
 * @method     ChildAccess[]|ObjectCollection findByLevel(int $level) Return ChildAccess objects filtered by the level column
 * @method     ChildAccess[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildAccess objects filtered by the created_at column
 * @method     ChildAccess[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AccessQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Box\Model\Base\AccessQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'box', $modelName = '\\Box\\Model\\Access', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAccessQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAccessQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAccessQuery) {
            return $criteria;
        }
        $query = new ChildAccessQuery();
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
     * @return ChildAccess|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AccessTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AccessTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAccess A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, collection_id, client_id, level, created_at FROM _access WHERE id = :p0';
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
            /** @var ChildAccess $obj */
            $obj = new ChildAccess();
            $obj->hydrate($row);
            AccessTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAccess|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAccessQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AccessTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAccessQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AccessTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildAccessQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AccessTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AccessTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccessTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildAccessQuery The current query, for fluid interface
     */
    public function filterByCollectionId($collectionId = null, $comparison = null)
    {
        if (is_array($collectionId)) {
            $useMinMax = false;
            if (isset($collectionId['min'])) {
                $this->addUsingAlias(AccessTableMap::COL_COLLECTION_ID, $collectionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($collectionId['max'])) {
                $this->addUsingAlias(AccessTableMap::COL_COLLECTION_ID, $collectionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccessTableMap::COL_COLLECTION_ID, $collectionId, $comparison);
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
     * @return $this|ChildAccessQuery The current query, for fluid interface
     */
    public function filterByClientId($clientId = null, $comparison = null)
    {
        if (is_array($clientId)) {
            $useMinMax = false;
            if (isset($clientId['min'])) {
                $this->addUsingAlias(AccessTableMap::COL_CLIENT_ID, $clientId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($clientId['max'])) {
                $this->addUsingAlias(AccessTableMap::COL_CLIENT_ID, $clientId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccessTableMap::COL_CLIENT_ID, $clientId, $comparison);
    }

    /**
     * Filter the query on the level column
     *
     * @param     mixed $level The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAccessQuery The current query, for fluid interface
     */
    public function filterByLevel($level = null, $comparison = null)
    {
        $valueSet = AccessTableMap::getValueSet(AccessTableMap::COL_LEVEL);
        if (is_scalar($level)) {
            if (!in_array($level, $valueSet)) {
                throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $level));
            }
            $level = array_search($level, $valueSet);
        } elseif (is_array($level)) {
            $convertedValues = array();
            foreach ($level as $value) {
                if (!in_array($value, $valueSet)) {
                    throw new PropelException(sprintf('Value "%s" is not accepted in this enumerated column', $value));
                }
                $convertedValues []= array_search($value, $valueSet);
            }
            $level = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccessTableMap::COL_LEVEL, $level, $comparison);
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
     * @return $this|ChildAccessQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(AccessTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(AccessTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AccessTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query by a related \Box\Model\Client object
     *
     * @param \Box\Model\Client|ObjectCollection $client The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAccessQuery The current query, for fluid interface
     */
    public function filterByClient($client, $comparison = null)
    {
        if ($client instanceof \Box\Model\Client) {
            return $this
                ->addUsingAlias(AccessTableMap::COL_CLIENT_ID, $client->getId(), $comparison);
        } elseif ($client instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccessTableMap::COL_CLIENT_ID, $client->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAccessQuery The current query, for fluid interface
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
     * @return ChildAccessQuery The current query, for fluid interface
     */
    public function filterByCollection($coll, $comparison = null)
    {
        if ($coll instanceof \Box\Model\Coll) {
            return $this
                ->addUsingAlias(AccessTableMap::COL_COLLECTION_ID, $coll->getId(), $comparison);
        } elseif ($coll instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AccessTableMap::COL_COLLECTION_ID, $coll->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildAccessQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildAccess $access Object to remove from the list of results
     *
     * @return $this|ChildAccessQuery The current query, for fluid interface
     */
    public function prune($access = null)
    {
        if ($access) {
            $this->addUsingAlias(AccessTableMap::COL_ID, $access->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the _access table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AccessTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AccessTableMap::clearInstancePool();
            AccessTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AccessTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AccessTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AccessTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AccessTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Order by create date desc
     *
     * @return     $this|ChildAccessQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(AccessTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildAccessQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(AccessTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildAccessQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(AccessTableMap::COL_CREATED_AT);
    }

} // AccessQuery
