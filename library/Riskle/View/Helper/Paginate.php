<?php

/**
 * @category Riskle
 * @package Riskle_View
 * @copyright 2007 (c) Geoffrey Bachelet <geoffrey+ip@zubrowka.org>
 */

/**
 * Riskle_View_Helper_Paginate
 */

class Riskle_View_Helper_Paginate {

	/**
	 * Holds the current view object
	 * @var Zend_View
	 */

	protected $_view;

	/**
	 * Holds the rowset to work on
	 * @var object Riskle_Db_Table_Rowset_Paginate
	 */

	protected $_rowset;

	/**
	 * Automatically called by the view obejct
	 * @param Zend_View $view
	 */

	public function setView($view) {
		$this->_view = $view;
	}

	/**
	 * Composite view helper, as seen at naneau.nl \o/
	 * @param object $rowset Riskle_Db_Table_Rowset optional
	 */

	public function paginate(Riskle_Db_Table_Rowset_Paginate $rowset = null) {
		if (!is_null($rowset) && is_null($this->_rowset)) {
			$this->_rowset = $rowset;
		}
		return $this;
	}

	/**
	 * Draws the navigation links
	 * You can pass formats for the links and for the container:
	 *
	 * 	linkFormat: %s: the url, %d: the page number
	 * 	blockFormat: %s: the items
	 *
	 * @param string $linkFormat
	 * @param string $blockFormat
	 * @return string
	 */

	public function navigation($linkFormat = '<li><a href="%s">%d</a></li>', $blockFormat = '<ul>%s</ul>') {
		$links = array();
		foreach($this->_rowset->getPageRange() as $page) {
			$url = $this->_view->url(array('page' => $page));
			$links[] = sprintf($linkFormat, $url, $page);
		}
		$html = sprintf($blockFormat, implode('', $links));
		return $html;
	}

	/**
	 * Draws a link to the next page if any or $if_null
	 * @param string $linkFormat
	 * @param string $if_null
	 * @return string
	 */

	public function next($linkFormat = '<p class="next"><a href="%s">next</a></li>', $if_null = '') {
		$page = $this->_rowset->getNextPage();
		if (is_null($page)) {
			return $if_null;
		} else {
			$url = $this->_view->url(array('page' => $page));
			$html = sprintf($linkFormat, $url, $page);
			return $html;
		}
	}

	/**
	 * Draws a link to the previous page if any or $if_null
	 * @param string $linkFormat
	 * @param string $if_null
	 * @return string
	 */

	public function previous($linkFormat = '<p class="previous"><a href="%s">previous</a></li>', $if_null = '') {
		$page = $this->_rowset->getPreviousPage();
		if (is_null($page)) {
			return $if_null;
		} else {
			$url = $this->_view->url(array('page' => $page));
			$html = sprintf($linkFormat, $url, $page);
			return $html;
		}
	}

	/**
	 * Draws the "page X of Y" widget
	 * @param $format
	 * @return $string
	 */
	
	public function progression($format = '<p class="progression">page %d (of %d)</p>') {
		$html = sprintf($format, $this->_rowset->getCurrentPage(), $this->_rowset->getPageCount());
		return $html;
	}

}
