<?php

namespace Propel\TranslationBundle\Model\map;

use \RelationMap;
use \TableMap;

/**
 * This class defines the structure of the 'translation_file' table.
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
class TranslationFileTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'vendor.quentincerny.propel-translation-bundle.Propel.TranslationBundle.Model.map.TranslationFileTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('translation_file');
        $this->setPhpName('TranslationFile');
        $this->setClassname('Propel\\TranslationBundle\\Model\\TranslationFile');
        $this->setPackage('vendor.quentincerny.propel-translation-bundle.Propel.TranslationBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ID', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('DOMAIN', 'Domain', 'VARCHAR', true, 255, null);
        $this->addColumn('LOCALE', 'Locale', 'VARCHAR', true, 10, null);
        $this->addColumn('EXTENSION', 'Extension', 'VARCHAR', true, 10, null);
        $this->addColumn('PATH', 'Path', 'VARCHAR', true, 255, null);
        $this->addColumn('HASH', 'Hash', 'VARCHAR', true, 255, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('TranslationContent', 'Propel\\TranslationBundle\\Model\\TranslationContent', RelationMap::ONE_TO_MANY, array('id' => 'file_id', ), null, null, 'TranslationContents');
    } // buildRelations()

} // TranslationFileTableMap
