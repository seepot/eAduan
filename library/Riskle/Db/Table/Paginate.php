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
 * Riskle_Db_Table_Paginate
 */

class Riskle_Db_Table_Paginate extends Riskle_Pattern_Proxy {

	/**
	 * How many items to display per page
	 * @var integer
	 */

	protected $_itemsPerPage = 20;

	/**
	 * The current page, heh
	 * @var integer
	 */

	protected $_currentPage = 1;

	/**
	 * How many pages to display in the pagination links
	 * @var integer
	 */

	protected $_pageRangeLength = 10;

	/**
	 * Holds cached pageRange and pageCount
	 * @var array
	 */

	protected $_cache = array('pageRange' => null, 'pageCount' => null);

	/**
	 * Holds the where clause
	 * @var string
	 */

	protected $_where = null;

	/**
	 * Stores the table object and enforces $page to be
	 * an integer greater or equal to 1
	 *
	 * @param Zend_Db_Table $table
	 * @param integer $page
	 */

	public function __construct(Riskle_Db_Table $subject, $page = 1) {
		$this->_subject = $subject;
		$page = (integer) $page;
		if ($page < 1) {
			$page = 1;
		}
		$this->_currentPage = $page;
	}

	/**
	 * Returns pagination infos:
	 * 	current_page => the current page
	 * 	page_range => an array containing the range of pages to display
	 * 	page_count => the total number of pages
	 *
	 * @return array
	 */

	public function getPaginationInfos() {
		$infos = array(
			'current_page' => $this->_currentPage,
			'page_range' => $this->_getPageRange(),
			'page_count' => $this->_getPageCount(),
		);
		return $infos;
	}

	/**
	 * Queries the table for the total number of pages
	 * I did not find a clean way to retrieve this infos
	 * from Zend_Db_Table, so i'm shamelessly issueing
	 * a raw query from Zend_Db
	 *
	 * Stores the result in the internal class cache
	 *
	 * @param boolean $noCache
	 */

	protected function _getPageCount($noCache = false) {
		if (is_null($this->_cache['pageCount']) || $noCache) {
			$rowCount = $this->_subject->fetchCount('*', $this->_where);
			$this->_cache['pageCount'] = (integer) ceil($rowCount / $this->_itemsPerPage);
		}
		return $this->_cache['pageCount'];
	}

	/**
	 * Computes the page range.
	 * Not much to say here, except that it stores the result
	 * in the class' internal cache
	 *
	 * @return array
	 */

	protected function _getPageRange($noCache = false) {
		if (is_null($this->_cache['pageRange']) || $noCache) {
			if ($this->_pageRangeLength > $this->_getPageCount()) {
				$start = 1;
				$stop = $this->_getPageCount();
			} else {
				$start = (integer) ($this->_currentPage - (floor($this->_pageRangeLength) / 2));
				if ($start < 1) {
					$start = 1;
				}
				$stop = $start + $this->_pageRangeLength;
				if ($stop > $this->_getPageCount()) {
					$stop = $this->_getPageCount();
					$start = $stop - $this->_pageRangeLength;
				}
			}
			$this->_cache['pageRange'] = range($start, $stop);
		}
		return $this->_cache['pageRange'];
	}

	/**
	 * Overloads the internal table object's fetchAll method
	 * to fetch only the results for the current page
	 *
	 * @param string|array $where
	 * @param string|array $order
	 * @return Zend_Db_Rowset
	 */

	public function fetchAll($where = null, $order = null) {
		$this->_where = $where;
		$count = $this->_itemsPerPage;
		$offset = $this->_itemsPerPage * ($this->_currentPage - 1);
		return new Riskle_Db_Table_Rowset_Paginate(
			$this->_subject->fetchAll($where, $order, $count, $offset),
			array(
				'current_page' => $this->_currentPage,
				'page_range' => $this->_getPageRange(),
				'page_count' => $this->_getPageCount(),
			)
		);
	}
}
