<?php
 
class Spt_Acl extends Zend_Acl {
 
	protected static $_instance = null;
 
	private function __construct()
	{}
 
	private function __clone()
	{}
 
	protected function _initialize()
	{
 
		$db = Zend_Db_Table::getDefaultAdapter();
 
		$roles = $db->fetchAll("SELECT
				acl_role_privilege.acl_role_id, 
				acl_module.acl_module_name,
				acl_resource.acl_resource_name,
				acl_privilege.acl_privilege_name
				FROM acl_role_privilege
				INNER JOIN acl_privilege 
				ON acl_role_privilege.acl_privilege_id = acl_privilege.acl_privilege_id
				INNER JOIN acl_resource
				ON acl_privilege.acl_resource_id = acl_resource.acl_resource_id
				INNER JOIN acl_module
				ON acl_resource.acl_module_id = acl_module.acl_module_id");
 
		foreach ($roles as $role) {
			if (!$this->has($role['acl_module_name'].'_'.$role['acl_resource_name'])) {
				$this->add(new Zend_Acl_Resource($role['acl_module_name'].'_'.$role['acl_resource_name']));
			}
			if (!$this->hasRole($role['acl_role_id'])) {
				$this->addRole(new Zend_Acl_Role($role['acl_role_id']));
			}
		}
 
		//$this->deny();
		$this->allow(null, 'default_error');
		$this->allow(null, 'default_index');
 
		foreach ($roles as $role) {
			$this->allow($role['acl_role_id'], $role['acl_module_name'].'_'.$role['acl_resource_name'], $role['acl_privilege_name']);
		}
		//$this->allow(2);
	}
 
	public static function getInstance()
    {
	   if (null === self::$_instance) {
		self::$_instance = new self();
		self::$_instance->_initialize();
	   }
 
	   return self::$_instance;
    }
 
}