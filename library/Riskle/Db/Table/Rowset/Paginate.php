<?php

/**
 * @category Riskle
 * @package Riskle_Db
 * @copyright 2007 (c) Geoffrey Bachelet <geoffrey+ip@zubrowka.org>
 */

/**
 * Riskle_Pattern_Proxy
 */

require_once 'Riskle/Pattern/Proxy.php';

/**
 * Riskle_Db_Table_Rowset_Paginate
 * @todo doc
 */

class Riskle_Db_Table_Rowset_Paginate extends Riskle_Pattern_Proxy implements Iterator {

	/**
	 * Array with keys:
	 *  - page_count
	 *  - current_page
	 *  - page_range
	 *
	 * @var array
	 */
	
	protected $_paginationInfos = array();

	/**
	 * Initiates proxy behaviour and calculates some more infos
	 * @param obejct $subject Zend_Db_Table_Rowset_Abstract
	 */

	public function __construct(Zend_Db_Table_Rowset_Abstract $subject, $paginationInfos) {
		$this->_subject = $subject;
		$this->_paginationInfos = array_merge($this->_paginationInfos, $paginationInfos);
		$this->_paginationInfos = array_merge($this->_paginationInfos, array(
			'next_page' => ($paginationInfos['current_page'] < $paginationInfos['page_count'] ? $paginationInfos['current_page'] + 1 : null),
			'previous_page' => ($paginationInfos['current_page'] > 1 ? $paginationInfos['current_page'] - 1 : null),
		));
	}

	/**
	 * Retrieve the whole pagination infos array
	 * @return array
	 */

	public function getInfos() {
		return $this->_paginationInfos;
	}

	/**
	 * Returns the next page or null if none
	 * @return integer|null
	 */

	public function getNextPage() {
		return $this->_paginationInfos['next_page'];
	}

	/**
	 * Returns the previous page or null if none
	 * @return integer|null
	 */

	public function getPreviousPage() {
		return $this->_paginationInfos['previous_page'];
	}

	/**
	 * Returns the total number of pages
	 * @return integer
	 */

	public function getPageCount() {
		return $this->_paginationInfos['page_count'];
	}

	/**
	 * Returns the array of pages currently visible to the nav
	 * @return integer
	 */

	public function getPageRange() {
		return $this->_paginationInfos['page_range'];
	}

	/**
	 * Returns the current page
	 * @return integer
	 */

	public function getCurrentPage() {
		return $this->_paginationInfos['current_page'];
	}

	/**
	 * Adds the pagination infos to the data array
	 * @return array
	 */

	public function toArray() {
		$array = $this->_subject->toArray();
		$array['pagination'] = $this->_paginationInfos;
		return $array;
	}

	/**
	 * Iterator::current()
	 */

	public function current() {
		return $this->_subject->current();
	}

	/**
	 * Iterator::next()
	 */

	public function next() {
		return $this->_subject->next();
	}

	/**
	 * Iterator:::key()
	 */

	public function key() {
		return $this->_subject->key();
	}

	/**
	 * Iterator::valid()
	 */

	public function valid() {
		return $this->_subject->valid();
	}

	/**
	 * Iterator::rewind();
	 */

	public function rewind() {
		return $this->_subject->rewind();
	}
}

