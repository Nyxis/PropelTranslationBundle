<?php

namespace Propel\TranslationBundle\Model\om;

use \Criteria;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelPDO;
use Propel\TranslationBundle\Model\TranslationContent;
use Propel\TranslationBundle\Model\TranslationContentPeer;
use Propel\TranslationBundle\Model\TranslationContentQuery;
use Propel\TranslationBundle\Model\TranslationFile;
use Propel\TranslationBundle\Model\TranslationKey;

/**
 * Base class that represents a query for the 'translation_content' table.
 *
 * 
 *
 * @method     TranslationContentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     TranslationContentQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     TranslationContentQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     TranslationContentQuery orderByFileId($order = Criteria::ASC) Order by the file_id column
 * @method     TranslationContentQuery orderByTransUnitId($order = Criteria::ASC) Order by the key_id column
 * @method     TranslationContentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     TranslationContentQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     TranslationContentQuery groupById() Group by the id column
 * @method     TranslationContentQuery groupByLocale() Group by the locale column
 * @method     TranslationContentQuery groupByContent() Group by the content column
 * @method     TranslationContentQuery groupByFileId() Group by the file_id column
 * @method     TranslationContentQuery groupByTransUnitId() Group by the key_id column
 * @method     TranslationContentQuery groupByCreatedAt() Group by the created_at column
 * @method     TranslationContentQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     TranslationContentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     TranslationContentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     TranslationContentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     TranslationContentQuery leftJoinTranslationFile($relationAlias = null) Adds a LEFT JOIN clause to the query using the TranslationFile relation
 * @method     TranslationContentQuery rightJoinTranslationFile($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TranslationFile relation
 * @method     TranslationContentQuery innerJoinTranslationFile($relationAlias = null) Adds a INNER JOIN clause to the query using the TranslationFile relation
 *
 * @method     TranslationContentQuery leftJoinTranslationKey($relationAlias = null) Adds a LEFT JOIN clause to the query using the TranslationKey relation
 * @method     TranslationContentQuery rightJoinTranslationKey($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TranslationKey relation
 * @method     TranslationContentQuery innerJoinTranslationKey($relationAlias = null) Adds a INNER JOIN clause to the query using the TranslationKey relation
 *
 * @method     TranslationContent findOne(PropelPDO $con = null) Return the first TranslationContent matching the query
 * @method     TranslationContent findOneOrCreate(PropelPDO $con = null) Return the first TranslationContent matching the query, or a new TranslationContent object populated from the query conditions when no match is found
 *
 * @method     TranslationContent findOneById(int $id) Return the first TranslationContent filtered by the id column
 * @method     TranslationContent findOneByLocale(string $locale) Return the first TranslationContent filtered by the locale column
 * @method     TranslationContent findOneByContent(string $content) Return the first TranslationContent filtered by the content column
 * @method     TranslationContent findOneByFileId(int $file_id) Return the first TranslationContent filtered by the file_id column
 * @method     TranslationContent findOneByTransUnitId(int $key_id) Return the first TranslationContent filtered by the key_id column
 * @method     TranslationContent findOneByCreatedAt(string $created_at) Return the first TranslationContent filtered by the created_at column
 * @method     TranslationContent findOneByUpdatedAt(string $updated_at) Return the first TranslationContent filtered by the updated_at column
 *
 * @method     array findById(int $id) Return TranslationContent objects filtered by the id column
 * @method     array findByLocale(string $locale) Return TranslationContent objects filtered by the locale column
 * @method     array findByContent(string $content) Return TranslationContent objects filtered by the content column
 * @method     array findByFileId(int $file_id) Return TranslationContent objects filtered by the file_id column
 * @method     array findByTransUnitId(int $key_id) Return TranslationContent objects filtered by the key_id column
 * @method     array findByCreatedAt(string $created_at) Return TranslationContent objects filtered by the created_at column
 * @method     array findByUpdatedAt(string $updated_at) Return TranslationContent objects filtered by the updated_at column
 *
 * @package    propel.generator.vendor.quentincerny.propel-translation-bundle.Propel.TranslationBundle.Model.om
 */
abstract class BaseTranslationContentQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseTranslationContentQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Propel\\TranslationBundle\\Model\\TranslationContent', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new TranslationContentQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    TranslationContentQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof TranslationContentQuery) {
			return $criteria;
		}
		$query = new TranslationContentQuery();
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
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    TranslationContent|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = TranslationContentPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(TranslationContentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		if ($this->formatter || $this->modelAlias || $this->with || $this->select
		 || $this->selectColumns || $this->asColumns || $this->selectModifiers
		 || $this->map || $this->having || $this->joins) {
			return $this->findPkComplex($key, $con);
		} else {
			return $this->findPkSimple($key, $con);
		}
	}

	/**
	 * Find object by primary key using raw SQL to go fast.
	 * Bypass doSelect() and the object formatter by using generated code.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    TranslationContent A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `LOCALE`, `CONTENT`, `FILE_ID`, `KEY_ID`, `CREATED_AT`, `UPDATED_AT` FROM `translation_content` WHERE `ID` = :p0';
		try {
			$stmt = $con->prepare($sql);
			$stmt->bindValue(':p0', $key, PDO::PARAM_INT);
			$stmt->execute();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
		}
		$obj = null;
		if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
			$obj = new TranslationContent();
			$obj->hydrate($row);
			TranslationContentPeer::addInstanceToPool($obj, (string) $key);
		}
		$stmt->closeCursor();

		return $obj;
	}

	/**
	 * Find object by primary key.
	 *
	 * @param     mixed $key Primary key to use for the query
	 * @param     PropelPDO $con A connection object
	 *
	 * @return    TranslationContent|array|mixed the result, formatted by the current formatter
	 */
	protected function findPkComplex($key, $con)
	{
		// As the query uses a PK condition, no limit(1) is necessary.
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKey($key)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
	}

	/**
	 * Find objects by primary key
	 * <code>
	 * $objs = $c->findPks(array(12, 56, 832), $con);
	 * </code>
	 * @param     array $keys Primary keys to use for the query
	 * @param     PropelPDO $con an optional connection object
	 *
	 * @return    PropelObjectCollection|array|mixed the list of results, formatted by the current formatter
	 */
	public function findPks($keys, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
		}
		$this->basePreSelect($con);
		$criteria = $this->isKeepQuery() ? clone $this : $this;
		$stmt = $criteria
			->filterByPrimaryKeys($keys)
			->doSelect($con);
		return $criteria->getFormatter()->init($criteria)->format($stmt);
	}

	/**
	 * Filter the query by primary key
	 *
	 * @param     mixed $key Primary key to use for the query
	 *
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(TranslationContentPeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(TranslationContentPeer::ID, $keys, Criteria::IN);
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
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(TranslationContentPeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the locale column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByLocale('fooValue');   // WHERE locale = 'fooValue'
	 * $query->filterByLocale('%fooValue%'); // WHERE locale LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $locale The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function filterByLocale($locale = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($locale)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $locale)) {
				$locale = str_replace('*', '%', $locale);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TranslationContentPeer::LOCALE, $locale, $comparison);
	}

	/**
	 * Filter the query on the content column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
	 * $query->filterByContent('%fooValue%'); // WHERE content LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $content The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function filterByContent($content = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($content)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $content)) {
				$content = str_replace('*', '%', $content);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TranslationContentPeer::CONTENT, $content, $comparison);
	}

	/**
	 * Filter the query on the file_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByFileId(1234); // WHERE file_id = 1234
	 * $query->filterByFileId(array(12, 34)); // WHERE file_id IN (12, 34)
	 * $query->filterByFileId(array('min' => 12)); // WHERE file_id > 12
	 * </code>
	 *
	 * @see       filterByTranslationFile()
	 *
	 * @param     mixed $fileId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function filterByFileId($fileId = null, $comparison = null)
	{
		if (is_array($fileId)) {
			$useMinMax = false;
			if (isset($fileId['min'])) {
				$this->addUsingAlias(TranslationContentPeer::FILE_ID, $fileId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($fileId['max'])) {
				$this->addUsingAlias(TranslationContentPeer::FILE_ID, $fileId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TranslationContentPeer::FILE_ID, $fileId, $comparison);
	}

	/**
	 * Filter the query on the key_id column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByTransUnitId(1234); // WHERE key_id = 1234
	 * $query->filterByTransUnitId(array(12, 34)); // WHERE key_id IN (12, 34)
	 * $query->filterByTransUnitId(array('min' => 12)); // WHERE key_id > 12
	 * </code>
	 *
	 * @see       filterByTranslationKey()
	 *
	 * @param     mixed $transUnitId The value to use as filter.
	 *              Use scalar values for equality.
	 *              Use array values for in_array() equivalent.
	 *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function filterByTransUnitId($transUnitId = null, $comparison = null)
	{
		if (is_array($transUnitId)) {
			$useMinMax = false;
			if (isset($transUnitId['min'])) {
				$this->addUsingAlias(TranslationContentPeer::KEY_ID, $transUnitId['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($transUnitId['max'])) {
				$this->addUsingAlias(TranslationContentPeer::KEY_ID, $transUnitId['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TranslationContentPeer::KEY_ID, $transUnitId, $comparison);
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
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function filterByCreatedAt($createdAt = null, $comparison = null)
	{
		if (is_array($createdAt)) {
			$useMinMax = false;
			if (isset($createdAt['min'])) {
				$this->addUsingAlias(TranslationContentPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($createdAt['max'])) {
				$this->addUsingAlias(TranslationContentPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TranslationContentPeer::CREATED_AT, $createdAt, $comparison);
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
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function filterByUpdatedAt($updatedAt = null, $comparison = null)
	{
		if (is_array($updatedAt)) {
			$useMinMax = false;
			if (isset($updatedAt['min'])) {
				$this->addUsingAlias(TranslationContentPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
				$useMinMax = true;
			}
			if (isset($updatedAt['max'])) {
				$this->addUsingAlias(TranslationContentPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
				$useMinMax = true;
			}
			if ($useMinMax) {
				return $this;
			}
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
		}
		return $this->addUsingAlias(TranslationContentPeer::UPDATED_AT, $updatedAt, $comparison);
	}

	/**
	 * Filter the query by a related TranslationFile object
	 *
	 * @param     TranslationFile|PropelCollection $translationFile The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function filterByTranslationFile($translationFile, $comparison = null)
	{
		if ($translationFile instanceof TranslationFile) {
			return $this
				->addUsingAlias(TranslationContentPeer::FILE_ID, $translationFile->getId(), $comparison);
		} elseif ($translationFile instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(TranslationContentPeer::FILE_ID, $translationFile->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByTranslationFile() only accepts arguments of type TranslationFile or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the TranslationFile relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function joinTranslationFile($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TranslationFile');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'TranslationFile');
		}

		return $this;
	}

	/**
	 * Use the TranslationFile relation TranslationFile object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Propel\TranslationBundle\Model\TranslationFileQuery A secondary query class using the current class as primary query
	 */
	public function useTranslationFileQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTranslationFile($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TranslationFile', '\Propel\TranslationBundle\Model\TranslationFileQuery');
	}

	/**
	 * Filter the query by a related TranslationKey object
	 *
	 * @param     TranslationKey|PropelCollection $translationKey The related object(s) to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function filterByTranslationKey($translationKey, $comparison = null)
	{
		if ($translationKey instanceof TranslationKey) {
			return $this
				->addUsingAlias(TranslationContentPeer::KEY_ID, $translationKey->getId(), $comparison);
		} elseif ($translationKey instanceof PropelCollection) {
			if (null === $comparison) {
				$comparison = Criteria::IN;
			}
			return $this
				->addUsingAlias(TranslationContentPeer::KEY_ID, $translationKey->toKeyValue('PrimaryKey', 'Id'), $comparison);
		} else {
			throw new PropelException('filterByTranslationKey() only accepts arguments of type TranslationKey or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the TranslationKey relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function joinTranslationKey($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TranslationKey');

		// create a ModelJoin object for this join
		$join = new ModelJoin();
		$join->setJoinType($joinType);
		$join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
		if ($previousJoin = $this->getPreviousJoin()) {
			$join->setPreviousJoin($previousJoin);
		}

		// add the ModelJoin to the current object
		if($relationAlias) {
			$this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
			$this->addJoinObject($join, $relationAlias);
		} else {
			$this->addJoinObject($join, 'TranslationKey');
		}

		return $this;
	}

	/**
	 * Use the TranslationKey relation TranslationKey object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Propel\TranslationBundle\Model\TranslationKeyQuery A secondary query class using the current class as primary query
	 */
	public function useTranslationKeyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
	{
		return $this
			->joinTranslationKey($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TranslationKey', '\Propel\TranslationBundle\Model\TranslationKeyQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     TranslationContent $translationContent Object to remove from the list of results
	 *
	 * @return    TranslationContentQuery The current query, for fluid interface
	 */
	public function prune($translationContent = null)
	{
		if ($translationContent) {
			$this->addUsingAlias(TranslationContentPeer::ID, $translationContent->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

	// Timestampable behavior
	
	/**
	 * Filter by the latest updated
	 *
	 * @param      int $nbDays Maximum age of the latest update in days
	 *
	 * @return     TranslationContentQuery The current query, for fluid interface
	 */
	public function recentlyUpdated($nbDays = 7)
	{
		return $this->addUsingAlias(TranslationContentPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Filter by the latest created
	 *
	 * @param      int $nbDays Maximum age of in days
	 *
	 * @return     TranslationContentQuery The current query, for fluid interface
	 */
	public function recentlyCreated($nbDays = 7)
	{
		return $this->addUsingAlias(TranslationContentPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
	}
	
	/**
	 * Order by update date desc
	 *
	 * @return     TranslationContentQuery The current query, for fluid interface
	 */
	public function lastUpdatedFirst()
	{
		return $this->addDescendingOrderByColumn(TranslationContentPeer::UPDATED_AT);
	}
	
	/**
	 * Order by update date asc
	 *
	 * @return     TranslationContentQuery The current query, for fluid interface
	 */
	public function firstUpdatedFirst()
	{
		return $this->addAscendingOrderByColumn(TranslationContentPeer::UPDATED_AT);
	}
	
	/**
	 * Order by create date desc
	 *
	 * @return     TranslationContentQuery The current query, for fluid interface
	 */
	public function lastCreatedFirst()
	{
		return $this->addDescendingOrderByColumn(TranslationContentPeer::CREATED_AT);
	}
	
	/**
	 * Order by create date asc
	 *
	 * @return     TranslationContentQuery The current query, for fluid interface
	 */
	public function firstCreatedFirst()
	{
		return $this->addAscendingOrderByColumn(TranslationContentPeer::CREATED_AT);
	}

} // BaseTranslationContentQuery