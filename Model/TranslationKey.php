<?php

namespace Propel\TranslationBundle\Model;

use Propel\TranslationBundle\Model\om\BaseTranslationKey;


/**
 * Skeleton subclass for representing a row from the 'translation_key' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.vendor.quentincerny.propel-translation-bundle.Propel.TranslationBundle.Model
 */
class TranslationKey extends BaseTranslationKey {
  
  /**
  * get the content of the translation for a instance of TranslationKey
	* @param string $locale locale
	*
	* @return string $content content
	*/
  public function getTranslation($locale)
  {
		$filterByLocale = new \Criteria();
		$filterByLocale->add(TranslationContentPeer::LOCALE, $locale);
		$contents = $this->getTranslationContents($filterByLocale);

		if($content = $contents->getFirst()) {
			return $content->getContent();
		}

		return '';
	}
} // TranslationKey
