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
use Propel\TranslationBundle\Model\TranslationFile;
use Propel\TranslationBundle\Model\TranslationFilePeer;
use Propel\TranslationBundle\Model\TranslationFileQuery;

/**
 * Base class that represents a query for the 'translation_file' table.
 *
 * 
 *
 * @method     TranslationFileQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     TranslationFileQuery orderByDomain($order = Criteria::ASC) Order by the domain column
 * @method     TranslationFileQuery orderByLocale($order = Criteria::ASC) Order by the locale column
 * @method     TranslationFileQuery orderByExtension($order = Criteria::ASC) Order by the extension column
 * @method     TranslationFileQuery orderByPath($order = Criteria::ASC) Order by the path column
 * @method     TranslationFileQuery orderByHash($order = Criteria::ASC) Order by the hash column
 *
 * @method     TranslationFileQuery groupById() Group by the id column
 * @method     TranslationFileQuery groupByDomain() Group by the domain column
 * @method     TranslationFileQuery groupByLocale() Group by the locale column
 * @method     TranslationFileQuery groupByExtension() Group by the extension column
 * @method     TranslationFileQuery groupByPath() Group by the path column
 * @method     TranslationFileQuery groupByHash() Group by the hash column
 *
 * @method     TranslationFileQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     TranslationFileQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     TranslationFileQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     TranslationFileQuery leftJoinTranslationContent($relationAlias = null) Adds a LEFT JOIN clause to the query using the TranslationContent relation
 * @method     TranslationFileQuery rightJoinTranslationContent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TranslationContent relation
 * @method     TranslationFileQuery innerJoinTranslationContent($relationAlias = null) Adds a INNER JOIN clause to the query using the TranslationContent relation
 *
 * @method     TranslationFile findOne(PropelPDO $con = null) Return the first TranslationFile matching the query
 * @method     TranslationFile findOneOrCreate(PropelPDO $con = null) Return the first TranslationFile matching the query, or a new TranslationFile object populated from the query conditions when no match is found
 *
 * @method     TranslationFile findOneById(int $id) Return the first TranslationFile filtered by the id column
 * @method     TranslationFile findOneByDomain(string $domain) Return the first TranslationFile filtered by the domain column
 * @method     TranslationFile findOneByLocale(string $locale) Return the first TranslationFile filtered by the locale column
 * @method     TranslationFile findOneByExtension(string $extension) Return the first TranslationFile filtered by the extension column
 * @method     TranslationFile findOneByPath(string $path) Return the first TranslationFile filtered by the path column
 * @method     TranslationFile findOneByHash(string $hash) Return the first TranslationFile filtered by the hash column
 *
 * @method     array findById(int $id) Return TranslationFile objects filtered by the id column
 * @method     array findByDomain(string $domain) Return TranslationFile objects filtered by the domain column
 * @method     array findByLocale(string $locale) Return TranslationFile objects filtered by the locale column
 * @method     array findByExtension(string $extension) Return TranslationFile objects filtered by the extension column
 * @method     array findByPath(string $path) Return TranslationFile objects filtered by the path column
 * @method     array findByHash(string $hash) Return TranslationFile objects filtered by the hash column
 *
 * @package    propel.generator.vendor.quentincerny.propel-translation-bundle.Propel.TranslationBundle.Model.om
 */
abstract class BaseTranslationFileQuery extends ModelCriteria
{
	
	/**
	 * Initializes internal state of BaseTranslationFileQuery object.
	 *
	 * @param     string $dbName The dabase name
	 * @param     string $modelName The phpName of a model, e.g. 'Book'
	 * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
	 */
	public function __construct($dbName = 'default', $modelName = 'Propel\\TranslationBundle\\Model\\TranslationFile', $modelAlias = null)
	{
		parent::__construct($dbName, $modelName, $modelAlias);
	}

	/**
	 * Returns a new TranslationFileQuery object.
	 *
	 * @param     string $modelAlias The alias of a model in the query
	 * @param     Criteria $criteria Optional Criteria to build the query from
	 *
	 * @return    TranslationFileQuery
	 */
	public static function create($modelAlias = null, $criteria = null)
	{
		if ($criteria instanceof TranslationFileQuery) {
			return $criteria;
		}
		$query = new TranslationFileQuery();
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
	 * @return    TranslationFile|array|mixed the result, formatted by the current formatter
	 */
	public function findPk($key, $con = null)
	{
		if ($key === null) {
			return null;
		}
		if ((null !== ($obj = TranslationFilePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
			// the object is alredy in the instance pool
			return $obj;
		}
		if ($con === null) {
			$con = Propel::getConnection(TranslationFilePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
	 * @return    TranslationFile A model object, or null if the key is not found
	 */
	protected function findPkSimple($key, $con)
	{
		$sql = 'SELECT `ID`, `DOMAIN`, `LOCALE`, `EXTENSION`, `PATH`, `HASH` FROM `translation_file` WHERE `ID` = :p0';
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
			$obj = new TranslationFile();
			$obj->hydrate($row);
			TranslationFilePeer::addInstanceToPool($obj, (string) $key);
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
	 * @return    TranslationFile|array|mixed the result, formatted by the current formatter
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
	 * @return    TranslationFileQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKey($key)
	{
		return $this->addUsingAlias(TranslationFilePeer::ID, $key, Criteria::EQUAL);
	}

	/**
	 * Filter the query by a list of primary keys
	 *
	 * @param     array $keys The list of primary key to use for the query
	 *
	 * @return    TranslationFileQuery The current query, for fluid interface
	 */
	public function filterByPrimaryKeys($keys)
	{
		return $this->addUsingAlias(TranslationFilePeer::ID, $keys, Criteria::IN);
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
	 * @return    TranslationFileQuery The current query, for fluid interface
	 */
	public function filterById($id = null, $comparison = null)
	{
		if (is_array($id) && null === $comparison) {
			$comparison = Criteria::IN;
		}
		return $this->addUsingAlias(TranslationFilePeer::ID, $id, $comparison);
	}

	/**
	 * Filter the query on the domain column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByDomain('fooValue');   // WHERE domain = 'fooValue'
	 * $query->filterByDomain('%fooValue%'); // WHERE domain LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $domain The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TranslationFileQuery The current query, for fluid interface
	 */
	public function filterByDomain($domain = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($domain)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $domain)) {
				$domain = str_replace('*', '%', $domain);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TranslationFilePeer::DOMAIN, $domain, $comparison);
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
	 * @return    TranslationFileQuery The current query, for fluid interface
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
		return $this->addUsingAlias(TranslationFilePeer::LOCALE, $locale, $comparison);
	}

	/**
	 * Filter the query on the extension column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByExtension('fooValue');   // WHERE extension = 'fooValue'
	 * $query->filterByExtension('%fooValue%'); // WHERE extension LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $extension The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TranslationFileQuery The current query, for fluid interface
	 */
	public function filterByExtension($extension = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($extension)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $extension)) {
				$extension = str_replace('*', '%', $extension);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TranslationFilePeer::EXTENSION, $extension, $comparison);
	}

	/**
	 * Filter the query on the path column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByPath('fooValue');   // WHERE path = 'fooValue'
	 * $query->filterByPath('%fooValue%'); // WHERE path LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $path The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TranslationFileQuery The current query, for fluid interface
	 */
	public function filterByPath($path = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($path)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $path)) {
				$path = str_replace('*', '%', $path);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TranslationFilePeer::PATH, $path, $comparison);
	}

	/**
	 * Filter the query on the hash column
	 *
	 * Example usage:
	 * <code>
	 * $query->filterByHash('fooValue');   // WHERE hash = 'fooValue'
	 * $query->filterByHash('%fooValue%'); // WHERE hash LIKE '%fooValue%'
	 * </code>
	 *
	 * @param     string $hash The value to use as filter.
	 *              Accepts wildcards (* and % trigger a LIKE)
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TranslationFileQuery The current query, for fluid interface
	 */
	public function filterByHash($hash = null, $comparison = null)
	{
		if (null === $comparison) {
			if (is_array($hash)) {
				$comparison = Criteria::IN;
			} elseif (preg_match('/[\%\*]/', $hash)) {
				$hash = str_replace('*', '%', $hash);
				$comparison = Criteria::LIKE;
			}
		}
		return $this->addUsingAlias(TranslationFilePeer::HASH, $hash, $comparison);
	}

	/**
	 * Filter the query by a related TranslationContent object
	 *
	 * @param     TranslationContent $translationContent  the related object to use as filter
	 * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
	 *
	 * @return    TranslationFileQuery The current query, for fluid interface
	 */
	public function filterByTranslationContent($translationContent, $comparison = null)
	{
		if ($translationContent instanceof TranslationContent) {
			return $this
				->addUsingAlias(TranslationFilePeer::ID, $translationContent->getFileId(), $comparison);
		} elseif ($translationContent instanceof PropelCollection) {
			return $this
				->useTranslationContentQuery()
				->filterByPrimaryKeys($translationContent->getPrimaryKeys())
				->endUse();
		} else {
			throw new PropelException('filterByTranslationContent() only accepts arguments of type TranslationContent or PropelCollection');
		}
	}

	/**
	 * Adds a JOIN clause to the query using the TranslationContent relation
	 *
	 * @param     string $relationAlias optional alias for the relation
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    TranslationFileQuery The current query, for fluid interface
	 */
	public function joinTranslationContent($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		$tableMap = $this->getTableMap();
		$relationMap = $tableMap->getRelation('TranslationContent');

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
			$this->addJoinObject($join, 'TranslationContent');
		}

		return $this;
	}

	/**
	 * Use the TranslationContent relation TranslationContent object
	 *
	 * @see       useQuery()
	 *
	 * @param     string $relationAlias optional alias for the relation,
	 *                                   to be used as main alias in the secondary query
	 * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
	 *
	 * @return    \Propel\TranslationBundle\Model\TranslationContentQuery A secondary query class using the current class as primary query
	 */
	public function useTranslationContentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
	{
		return $this
			->joinTranslationContent($relationAlias, $joinType)
			->useQuery($relationAlias ? $relationAlias : 'TranslationContent', '\Propel\TranslationBundle\Model\TranslationContentQuery');
	}

	/**
	 * Exclude object from result
	 *
	 * @param     TranslationFile $translationFile Object to remove from the list of results
	 *
	 * @return    TranslationFileQuery The current query, for fluid interface
	 */
	public function prune($translationFile = null)
	{
		if ($translationFile) {
			$this->addUsingAlias(TranslationFilePeer::ID, $translationFile->getId(), Criteria::NOT_EQUAL);
		}

		return $this;
	}

} // BaseTranslationFileQuery