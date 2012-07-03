<?php

namespace Propel\TranslationBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'translation_content' table.
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
class TranslationContentTableMap extends TableMap
{

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'vendor.quentincerny.propel-translation-bundle.Propel.TranslationBundle.Model.map.TranslationContentTableMap';

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
		$this->setName('translation_content');
		$this->setPhpName('TranslationContent');
		$this->setClassname('Propel\\TranslationBundle\\Model\\TranslationContent');
		$this->setPackage('vendor.quentincerny.propel-translation-bundle.Propel.TranslationBundle.Model');
		$this->setUseIdGenerator(true);
		// columns
		$this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
		$this->addColumn('LOCALE', 'Locale', 'VARCHAR', true, 10, null);
		$this->addColumn('CONTENT', 'Content', 'LONGVARCHAR', false, null, null);
		$this->addForeignKey('FILE_ID', 'FileId', 'INTEGER', 'translation_file', 'ID', false, null, null);
		$this->addForeignKey('KEY_ID', 'KeyId', 'INTEGER', 'translation_key', 'ID', true, null, null);
		$this->addColumn('CREATED_AT', 'CreatedAt', 'TIMESTAMP', false, null, null);
		$this->addColumn('UPDATED_AT', 'UpdatedAt', 'TIMESTAMP', false, null, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
		$this->addRelation('TranslationFile', 'Propel\\TranslationBundle\\Model\\TranslationFile', RelationMap::MANY_TO_ONE, array('file_id' => 'id', ), null, null);
		$this->addRelation('TranslationKey', 'Propel\\TranslationBundle\\Model\\TranslationKey', RelationMap::MANY_TO_ONE, array('key_id' => 'id', ), null, null);
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
			'Timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', ),
		);
	} // getBehaviors()

} // TranslationContentTableMap
