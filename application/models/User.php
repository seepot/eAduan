<?php
class User implements Zend_Acl_Role_Interface {
	private $_id;
	private $_name;
	private $_password;

	public function getId() {
		return $this->_id;
	}

	public function getName() {
		return $this->_name;
	}

	public function getPassword() {
		return $this->_password;
	}

	public function getGroups() {
		return array();
	}

	public function setId($id) {
		$this->_id = $id;
	}

	public function setName($name) {
		$this->_name = $name;
	}

	public function setPassword($password) {
		$this->_password = $password;
	}

	public static function findById($id) {
		$db = Zend_Registry::get('db');
		
		$sql = 'SELECT usr_id, usr_fullname, usr_password FROM sys_user WHERE usr_id = ?';
		
		$row = $db->fetchRow($sql, $id);
		if(!$row)
			return null;

		$user = new User();
		$user->setId($row['usr_id']);
		$user->setName($row['usr_fullname']);
		$user->setPassword($row['usr_password']);
		return $user;
	}


	/**
	 * @return string
	 */
	public function getRoleId() {
		return 'user-' . $this->_id;
	}
}