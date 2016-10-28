<?php

/**
 * @category Riskle
 * @package Riskle_Db
 */

/**
 * Riskle_Db_Table_Abstract
 */

require_once 'Riskle/Db/Table/Abstract.php';

/**
 * Riskle_Db_Table_Indexable
 */

class Riskle_Db_Table_Indexable extends Riskle_Db_Table_Abstract {

	protected static $_defaultIndex;

	/**
	 * Format is:
	 *
	 * array(
	 * 	field1 => type,
	 * 	field2 => type,
	 * 	field3,
	 * 	field4 => type
	 * )
	 *
	 * If no type is specified, Text will be assumed.
	 *
	 * Types can be found at http://framework.zend.com/manual/en/zend.search.lucene.html#zend.search.lucene.index-creation.documents-and-fields
	 * Can be one of:
	 * 	- Keyword (Field is not tokenized, but is indexed and stored within the index.)
	 * 	- UnIndexed (Field is not tokenized nor indexed, but is stored in the index.)
	 * 	- Binary (Binary String valued Field that is not tokenized nor indexed, but is stored in the index.)
	 * 	- Text (Field is tokenized and indexed, and is stored in the index.)
	 * 	- UnStored (Field is tokenized and indexed, but that is not stored in the index.)
	 *
	 * 	@var array
	 */

	protected $_indexableFields = array();

	/**
	 * Defaults the rowClass to Indexable
	 * The row class must implements Riskle_Search_Lucene_Indexable_Interface
	 * @var string
	 */

	protected $_rowClass = 'Riskle_Db_Table_Row_Indexable';

	/**
	 * Holds the actual index instance
	 * @var Zend_Search_Lucene_Proxy
	 */
	
	protected $_index;

	/**
	 * Sets the index to the default index if any
	 */

	public function __construct($config = array()) {
		if (isset($config['index'])) {
			$this->_index = $config['index'];
			unset($config['index']);
		} else if (!is_null(self::$_defaultIndex)) {
			$this->_index = self::$_defaultIndex;
		} else {
			throw new Exception('No index found');
		}

		parent::__construct($config);
	}

	/**
	 * Sets the lucene index
	 * @param Riskle_Search_Lucene_Index_Manager $index
	 * @return Riskle_Db_Table_Indexable
	 */

	public function setIndex(Riskle_Search_Lucene_Index_Manager $index) {
		$this->_index = $index;
		return $this;
	}

	/**
	 * Sets the default index for indexable tables
	 * @param Riskle_Search_Lucene_Index_Manager $index
	 */

	public static function setDefaultIndex(Riskle_Search_Lucene_Index_Manager $index) {
		self::$_defaultIndex = $index;
	}

	/**
	 * Returns the index instance
	 * @return Riskle_Search_Lucene_Index_Manager
	 */

	public function getIndex() {
		return $this->_index;
	}

	/**
	 * Returns the indexable fields definition
	 * @return array
	 */

	public function getIndexableFields() {
		return $this->_indexableFields;
	}

}
