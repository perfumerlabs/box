<?php

namespace Box\Model\Base;

use \Exception;
use \PDO;
use Box\Model\Coll as ChildColl;
use Box\Model\CollQuery as ChildCollQuery;
use Box\Model\Map\CollTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'box_collection' table.
 *
 *
 *
 * @method     ChildCollQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCollQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildCollQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildCollQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildCollQuery orderByHandler($order = Criteria::ASC) Order by the handler column
 * @method     ChildCollQuery orderByIsDisabled($order = Criteria::ASC) Order by the is_disabled column
 * @method     ChildCollQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildCollQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildCollQuery groupById() Group by the id column
 * @method     ChildCollQuery groupByName() Group by the name column
 * @method     ChildCollQuery groupByDescription() Group by the description column
 * @method     ChildCollQuery groupByType() Group by the type column
 * @method     ChildCollQuery groupByHandler() Group by the handler column
 * @method     ChildCollQuery groupByIsDisabled() Group by the is_disabled column
 * @method     ChildCollQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildCollQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildCollQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCollQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCollQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCollQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCollQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCollQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCollQuery leftJoinAccess($relationAlias = null) Adds a LEFT JOIN clause to the query using the Access relation
 * @method     ChildCollQuery rightJoinAccess($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Access relation
 * @method     ChildCollQuery innerJoinAccess($relationAlias = null) Adds a INNER JOIN clause to the query using the Access relation
 *
 * @method     ChildCollQuery joinWithAccess($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Access relation
 *
 * @method     ChildCollQuery leftJoinWithAccess() Adds a LEFT JOIN clause and with to the query using the Access relation
 * @method     ChildCollQuery rightJoinWithAccess() Adds a RIGHT JOIN clause and with to the query using the Access relation
 * @method     ChildCollQuery innerJoinWithAccess() Adds a INNER JOIN clause and with to the query using the Access relation
 *
 * @method     ChildCollQuery leftJoinDocumentLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the DocumentLog relation
 * @method     ChildCollQuery rightJoinDocumentLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the DocumentLog relation
 * @method     ChildCollQuery innerJoinDocumentLog($relationAlias = null) Adds a INNER JOIN clause to the query using the DocumentLog relation
 *
 * @method     ChildCollQuery joinWithDocumentLog($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the DocumentLog relation
 *
 * @method     ChildCollQuery leftJoinWithDocumentLog() Adds a LEFT JOIN clause and with to the query using the DocumentLog relation
 * @method     ChildCollQuery rightJoinWithDocumentLog() Adds a RIGHT JOIN clause and with to the query using the DocumentLog relation
 * @method     ChildCollQuery innerJoinWithDocumentLog() Adds a INNER JOIN clause and with to the query using the DocumentLog relation
 *
 * @method     \Box\Model\AccessQuery|\Box\Model\DocumentLogQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildColl|null findOne(ConnectionInterface $con = null) Return the first ChildColl matching the query
 * @method     ChildColl findOneOrCreate(ConnectionInterface $con = null) Return the first ChildColl matching the query, or a new ChildColl object populated from the query conditions when no match is found
 *
 * @method     ChildColl|null findOneById(int $id) Return the first ChildColl filtered by the id column
 * @method     ChildColl|null findOneByName(string $name) Return the first ChildColl filtered by the name column
 * @method     ChildColl|null findOneByDescription(string $description) Return the first ChildColl filtered by the description column
 * @method     ChildColl|null findOneByType(int $type) Return the first ChildColl filtered by the type column
 * @method     ChildColl|null findOneByHandler(string $handler) Return the first ChildColl filtered by the handler column
 * @method     ChildColl|null findOneByIsDisabled(boolean $is_disabled) Return the first ChildColl filtered by the is_disabled column
 * @method     ChildColl|null findOneByCreatedAt(string $created_at) Return the first ChildColl filtered by the created_at column
 * @method     ChildColl|null findOneByUpdatedAt(string $updated_at) Return the first ChildColl filtered by the updated_at column *

 * @method     ChildColl requirePk($key, ConnectionInterface $con = null) Return the ChildColl by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColl requireOne(ConnectionInterface $con = null) Return the first ChildColl matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildColl requireOneById(int $id) Return the first ChildColl filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColl requireOneByName(string $name) Return the first ChildColl filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColl requireOneByDescription(string $description) Return the first ChildColl filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColl requireOneByType(int $type) Return the first ChildColl filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColl requireOneByHandler(string $handler) Return the first ChildColl filtered by the handler column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColl requireOneByIsDisabled(boolean $is_disabled) Return the first ChildColl filtered by the is_disabled column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColl requireOneByCreatedAt(string $created_at) Return the first ChildColl filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildColl requireOneByUpdatedAt(string $updated_at) Return the first ChildColl filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildColl[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildColl objects based on current ModelCriteria
 * @method     ChildColl[]|ObjectCollection findById(int $id) Return ChildColl objects filtered by the id column
 * @method     ChildColl[]|ObjectCollection findByName(string $name) Return ChildColl objects filtered by the name column
 * @method     ChildColl[]|ObjectCollection findByDescription(string $description) Return ChildColl objects filtered by the description column
 * @method     ChildColl[]|ObjectCollection findByType(int $type) Return ChildColl objects filtered by the type column
 * @method     ChildColl[]|ObjectCollection findByHandler(string $handler) Return ChildColl objects filtered by the handler column
 * @method     ChildColl[]|ObjectCollection findByIsDisabled(boolean $is_disabled) Return ChildColl objects filtered by the is_disabled column
 * @method     ChildColl[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildColl objects filtered by the created_at column
 * @method     ChildColl[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildColl objects filtered by the updated_at column
 * @method     ChildColl[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CollQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Box\Model\Base\CollQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'box', $modelName = '\\Box\\Model\\Coll', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCollQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCollQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCollQuery) {
            return $criteria;
        }
        $query = new ChildCollQuery();
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
     * @return ChildColl|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CollTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CollTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildColl A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, description, type, handler, is_disabled, created_at, updated_at FROM box_collection WHERE id = :p0';
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
            /** @var ChildColl $obj */
            $obj = new ChildColl();
            $obj->hydrate($row);
            CollTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildColl|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CollTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CollTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CollTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CollTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CollTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CollTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%', Criteria::LIKE); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CollTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * @param     mixed $type The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        $valueSet = CollTableMap::getValueSet(CollTableMap::COL_TYPE);
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

        return $this->addUsingAlias(CollTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the handler column
     *
     * Example usage:
     * <code>
     * $query->filterByHandler('fooValue');   // WHERE handler = 'fooValue'
     * $query->filterByHandler('%fooValue%', Criteria::LIKE); // WHERE handler LIKE '%fooValue%'
     * </code>
     *
     * @param     string $handler The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function filterByHandler($handler = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($handler)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CollTableMap::COL_HANDLER, $handler, $comparison);
    }

    /**
     * Filter the query on the is_disabled column
     *
     * Example usage:
     * <code>
     * $query->filterByIsDisabled(true); // WHERE is_disabled = true
     * $query->filterByIsDisabled('yes'); // WHERE is_disabled = true
     * </code>
     *
     * @param     boolean|string $isDisabled The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function filterByIsDisabled($isDisabled = null, $comparison = null)
    {
        if (is_string($isDisabled)) {
            $isDisabled = in_array(strtolower($isDisabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(CollTableMap::COL_IS_DISABLED, $isDisabled, $comparison);
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
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(CollTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(CollTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CollTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(CollTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(CollTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CollTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Box\Model\Access object
     *
     * @param \Box\Model\Access|ObjectCollection $access the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCollQuery The current query, for fluid interface
     */
    public function filterByAccess($access, $comparison = null)
    {
        if ($access instanceof \Box\Model\Access) {
            return $this
                ->addUsingAlias(CollTableMap::COL_ID, $access->getCollectionId(), $comparison);
        } elseif ($access instanceof ObjectCollection) {
            return $this
                ->useAccessQuery()
                ->filterByPrimaryKeys($access->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAccess() only accepts arguments of type \Box\Model\Access or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Access relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function joinAccess($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Access');

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
            $this->addJoinObject($join, 'Access');
        }

        return $this;
    }

    /**
     * Use the Access relation Access object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Box\Model\AccessQuery A secondary query class using the current class as primary query
     */
    public function useAccessQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAccess($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Access', '\Box\Model\AccessQuery');
    }

    /**
     * Filter the query by a related \Box\Model\DocumentLog object
     *
     * @param \Box\Model\DocumentLog|ObjectCollection $documentLog the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCollQuery The current query, for fluid interface
     */
    public function filterByDocumentLog($documentLog, $comparison = null)
    {
        if ($documentLog instanceof \Box\Model\DocumentLog) {
            return $this
                ->addUsingAlias(CollTableMap::COL_ID, $documentLog->getCollectionId(), $comparison);
        } elseif ($documentLog instanceof ObjectCollection) {
            return $this
                ->useDocumentLogQuery()
                ->filterByPrimaryKeys($documentLog->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildCollQuery The current query, for fluid interface
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
     * @param   ChildColl $coll Object to remove from the list of results
     *
     * @return $this|ChildCollQuery The current query, for fluid interface
     */
    public function prune($coll = null)
    {
        if ($coll) {
            $this->addUsingAlias(CollTableMap::COL_ID, $coll->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the box_collection table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CollTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CollTableMap::clearInstancePool();
            CollTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CollTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CollTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CollTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CollTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildCollQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(CollTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildCollQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(CollTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildCollQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(CollTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildCollQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(CollTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildCollQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(CollTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildCollQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(CollTableMap::COL_CREATED_AT);
    }

} // CollQuery
