<?php

/**
 * @category Riskle
 * @package Riskle_Db
 * @copyright 2007 (c) Geoffrey Bachelet <geoffrey+ip@zubrowka.org>
 */

/**
 * Riskle_Db_Table_Exception
 */

require_once 'Riskle/Db/Table/Exception.php';

/**
 * Zend_Db_Table_Abstract
 */

require_once 'Zend/Db/Table/Abstract.php';

/**
 * Riskle_Db_Table_Abstract
 */

class Riskle_Db_Table_Abstract extends Zend_Db_Table_Abstract {

	/**
	 * Holds the parent mapping for join in fetchAll
	 *
	 * array(
	 * 	'remote_table' => array(
	 * 		'remote' => 'id'
	 * 		'local' => 'remote_id',
	 * 		'fields' => array('foo', 'bar', 'prefix' => 'remote_'),
	 * 	),
	 * );
	 *
	 * @var array
	 */

	protected $_parentMap = array();
	
	/**
	 *
	 */

	protected $_optionValueField = 'id';

	/**
	 *
	 */

	protected $_optionLabelField = 'label';

	/**
	 *
	 */

	public function insert(array $data) {
		if (array_search('created_on', $this->_cols) && !isset($data['created_on'])) {
			$data['created_on'] = date('Y-m-d H:i:s');
		}
		return parent::insert($data);
	}

	/**
	 *
	 */

	public function update(array $data, $where) {
		if (array_search('updated_on', $this->_cols) && !isset($data['updated_on'])) {
			$data['updated_on'] = date('Y-m-d H:i:s');
		}
		return parent::update($data, $where);
	}

	/**
	 * Helper method mainly used in Form to populate <select> objects
	 *
     * @param  string|array $where  OPTIONAL An SQL WHERE clause.
     * @param  string|array $order  OPTIONAL An SQL ORDER clause.
     * @param  int          $count  OPTIONAL An SQL LIMIT count.
     * @param  int          $offset OPTIONAL An SQL LIMIT offset.
	 */

	public function fetchOptions($where = null, $order = null, $count = null, $offset = null) {
		$itemsList = $this->fetchAll($where, $order, $count, $offset);
		$options = array();
		foreach($itemsList as $item) {
			$options[$item->{$this->_optionValueField}] = $item->{$this->_optionLabelField};
		}
		return $options;
	}

	/**
	 * Adds parent mapping information to a select and returns a rowset from it
	 *
	 * @param Zend_Db_Select $select
	 * @return Zend_Db_Table_Rowset
	 */
	
	public function fetchSelect(Zend_Db_Select $select) {
		$this->_applyParentMap($select);
		$stmt = $this->getAdapter()->query($select);

		return new $this->_rowsetClass(array(
			'data' => $stmt->fetchAll(),
			'table' => $this,
			'rowClass' => $this->rowClass,
			'stored' => true
		));
	}

    /**
     * Support method for fetching rows.
     *
     * @param  string|array $where  OPTIONAL An SQL WHERE clause.
     * @param  string|array $order  OPTIONAL An SQL ORDER clause.
     * @param  int          $count  OPTIONAL An SQL LIMIT count.
     * @param  int          $offset OPTIONAL An SQL LIMIT offset.
     * @return array The row results, in FETCH_ASSOC mode.
     */

    protected function _fetch($where = null, $order = null, $count = null, $offset = null, $cols = null, $selectParentFields = true) {
        // selection tool
        $select = $this->_db->select();

        // the FROM clause
		if (is_null($cols)) {
			$cols = $this->_cols;
		}
        $select->from($this->_name, $cols, $this->_schema);

        // the WHERE clause
        $where = (array) $where;
        foreach ($where as $key => $val) {
            // is $key an int?
            if (is_int($key)) {
                // $val is the full condition
                $select->where($val);
            } else {
                // $key is the condition with placeholder,
                // and $val is quoted into the condition
                $select->where($key, $val);
            }
        }

        // the ORDER clause
        if (!is_array($order)) {
            $order = array($order);
        }
        foreach ($order as $val) {
            $select->order($val);
        }

        // the LIMIT clause
        $select->limit($count, $offset);

		$this->_applyParentMap($select, $selectParentFields);

        // return the results
        $stmt = $this->_db->query($select);
        $data = $stmt->fetchAll(Zend_Db::FETCH_ASSOC);
        return $data;
    }

    /**
     * Fetches rows by primary key.  The argument specifies one or more primary 
     * key value(s).  To find multiple rows by primary key, the argument must 
     * be an array.
     *
     * This method accepts a variable number of arguments.  If the table has a 
     * multi-column primary key, the number of arguments must be the same as 
     * the number of columns in the primary key.  To find multiple rows in a 
     * table with a multi-column primary key, each argument must be an array 
     * with the same number of elements.
     *
     * The find() method always returns a Rowset object, even if only one row 
     * was found.
     *
     * @param  mixed $key The value(s) of the primary keys.
     * @return Zend_Db_Table_Rowset_Abstract Row(s) matching the criteria.
     * @throws Zend_Db_Table_Exception
     */

    public function find($key) {
        $args = func_get_args();
        $keyNames = array_values((array) $this->_primary);

        if (count($args) < count($keyNames)) {
            require_once 'Zend/Db/Table/Exception.php';
            throw new Zend_Db_Table_Exception("Too few columns for the primary key");
        }

        if (count($args) > count($keyNames)) {
            require_once 'Zend/Db/Table/Exception.php';
            throw new Zend_Db_Table_Exception("Too many columns for the primary key");
        }

        $whereList = array();
        $numberTerms = 0;
        foreach ($args as $keyPosition => $keyValues) {
            // Coerce the values to an array.
            // Don't simply typecast to array, because the values
            // might be Zend_Db_Expr objects.
            if (!is_array($keyValues)) {
                $keyValues = array($keyValues);
            }
            if ($numberTerms == 0) {
                $numberTerms = count($keyValues);
            } else if (count($keyValues) != $numberTerms) {
                require_once 'Zend/Db/Table/Exception.php';
                throw new Zend_Db_Table_Exception("Missing value(s) for the primary key");
            }
            for ($i = 0; $i < count($keyValues); ++$i) {
                $whereList[$i][$keyPosition] = $keyValues[$i];
            }
        }

        $whereClause = null;
        if (count($whereList)) {
            $whereOrTerms = array();
            foreach ($whereList as $keyValueSets) {
                $whereAndTerms = array();
                foreach ($keyValueSets as $keyPosition => $keyValue) {
                    $type = $this->_metadata[$keyNames[$keyPosition]]['DATA_TYPE'];
                    $whereAndTerms[] = $this->_db->quoteInto(
						$this->_db->quoteIdentifier($this->_name) . '.' .
                        $this->_db->quoteIdentifier($keyNames[$keyPosition], true) . ' = ?',
                        $keyValue, $type);
                }
                $whereOrTerms[] = '(' . implode(' AND ', $whereAndTerms) . ')';
            }
            $whereClause = '(' . implode(' OR ', $whereOrTerms) . ')';
        }

        return $this->fetchAll($whereClause);
    }
	

	/**
	 * Applys the parent mapping from self::_parentMap to a select object
	 *
	 * @param string|array $db
	 * @param string|array $select
	 */

	protected function _applyParentMap($select, $selectFields = true) {
		if (!empty($this->_parentMap)) {
			$db = $this->getAdapter();
			foreach($this->_parentMap as $parentTable => $specs) {
				$fields = array();
				if ($selectFields) {
					if (isset($specs['fields']['prefix'])) {
						$prefix = $specs['fields']['prefix'];
						unset($specs['fields']['prefix']);
						foreach($specs['fields'] as $key => $field) {
							if (is_int($key)) {
								$key = $prefix.$field;
							}
							$fields[$key] = $field;
						}
					} else {
						$fields = $specs['fields'];
					}
				}

				foreach(array('local' => $this->_name, 'remote' => $parentTable) as $scope => $table) {
					if (strstr($specs[$scope], '.')) {
						${$scope} = $specs[$scope];
					} else {
						${$scope} = sprintf('%s.%s', $db->quoteIdentifier($table), $db->quoteIdentifier($specs[$scope]));
					}
				}

				$select->joinLeft(
					$parentTable,
					sprintf('%s = %s', $local, $remote),
					$fields
				);

			}
		}
	}
	
	/**
	 * Provides a way to returns only certain cols
	 *
	 * @param mixed $cols Any value suitable to Zend_Db_Select::from()
	 * @param string|array $where
	 * @param string|array $order
	 * @param integer $count
	 * @param integer $offset
	 * @return Zend_Db_Table_Rowset_Abstract
	 */

	public function fetchCols($cols = null, $where = null, $order = null, $count = null, $offset = null) {
		$data = $this->_fetch($where, $order, $count, $offset, $cols, false);
		return new $this->_rowsetClass(array(
			'table' => $this,
			'data' => $data,
			'rowClass' => $this->_rowClass,
			'stored' => true
		));
	}

	/**
	 * Counts rows in the table
	 *
	 * @param string $cols The column to count
	 * @param string|array $where
	 * @return integer
	 */

	public function fetchCount($cols = '*', $where = null) {
		$rowset = $this->fetchCols(new Zend_Db_Expr(sprintf('COUNT(%s) AS riskle_db_table_count', $cols)), $where);
		return (integer) $rowset->current()->riskle_db_table_count;
	}

	/**
	 * Implements a simple findByField wrapper
	 */

	public function __call($method, $args) {
		if (preg_match('/^findBy([a-zA-Z0-9]+)$/', $method, $parts)) {
			$field = strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $parts[1]));
			if (!in_array($field, $this->_cols)) {
				throw new Riskle_Db_Table_Exception(sprintf('\'%s\' field not in row', $field));
			} else {
				$db = $this->getAdapter();
				$args[0] = $db->quoteInto($db->quoteIdentifier($field).' = ?', $args[0]);
				return call_user_func_array(array($this, 'fetchAll'), $args);
			}
		}
	}
}
