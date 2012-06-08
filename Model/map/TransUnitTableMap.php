<?php

namespace Propel\TranslationBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'translation_key' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.vendor.quentincerny.propel-translation-bundle.Propel.TranslationBundle.Model.map
 */
class TransUnitTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'vendor.quentincerny.propel-translation-bundle.Propel.TranslationBundle.Model.map.TransUnitTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
		// attributes
		$this->setName('translation_key');
		$this->setPhpName('TransUnit');
		$this->setClassname('Propel\\TranslationBundle\\Model\\TransUnit');
		$this->setPackage('vendor.quentincerny.propel-translation-bundle.Propel.TranslationBundle.Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('KEY_NAME', 'KeyName', 'VARCHAR', true, 255, null);
		$this->addColumn('DOMAIN', 'Domain', 'VARCHAR', true, 255, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('TransUnitTranslations', 'Propel\\TranslationBundle\\Model\\TransUnitTranslations', RelationMap::ONE_TO_MANY, array('id' => 'key_id', ), null, null, 'TransUnitTranslationss');
	} // buildRelations()

} // TransUnitTableMap
