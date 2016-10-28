<?php
 
class My_Acl extends Zend_Acl {
 
	protected static $_instance = null;
 
	public function __construct()
	{}
 
	private function __clone()
	{}
 
	protected function _initialize()
	{
 
		$db = Zend_Db_Table::getDefaultAdapter();
 
		$roles = $db->fetchAll("SELECT
				acl_role_privilege.acl_role_id, 
				acl_role.acl_inherit_id, 
				acl_module.acl_module_name,
				acl_resource.acl_resource_name,
				acl_privilege.acl_privilege_name
				FROM acl_role_privilege
				INNER JOIN acl_privilege 
				ON acl_role_privilege.acl_privilege_id = acl_privilege.acl_privilege_id
				INNER JOIN acl_resource
				ON acl_privilege.acl_resource_id = acl_resource.acl_resource_id
				INNER JOIN acl_role
				ON acl_role_privilege.acl_role_id = acl_role.acl_role_id
				INNER JOIN acl_module
				ON acl_resource.acl_module_id = acl_module.acl_module_id");
 
		foreach ($roles as $role) {
			if (!$this->has($role['acl_module_name'].'_'.$role['acl_resource_name'])) {
				$this->add(new Zend_Acl_Resource($role['acl_module_name'].'_'.$role['acl_resource_name']));
			}
			if (!$this->hasRole($role['acl_role_id'])) {
				if($role['acl_inherit_id'] <> '0')
					$this->addRole(new Zend_Acl_Role($role['acl_role_id']), $role['acl_inherit_id']);
				else
					$this->addRole(new Zend_Acl_Role($role['acl_role_id']));
			}
		}
 		//echo "<pre>";
 		//print_r($roles);
 		//echo "</pre>";
		$this->deny();
		$this->allow('2');
		//$this->allow(null,'layout_admin');
		$this->allow(null, 'default_index');
		//$this->allow(2);
		foreach ($roles as $role) {
			$this->allow($role['acl_role_id'], $role['acl_module_name'].'_'.$role['acl_resource_name'], $role['acl_privilege_name']);
		}
 
	}
 
	public static function getInstance()
    {
	   if (null === self::$_instance) {
		self::$_instance = new self();
		self::$_instance->_initialize();
	   }
 
	   return self::$_instance;
    }
    
	public function getrole($user)
    {
		$db = Zend_Registry::get ( 'db' );
                
		$sql = 'SELECT acl_role.acl_role_id
                FROM acl_role
                LEFT OUTER JOIN sys_user
                ON sys_user.role_id = acl_role.acl_role_id
        		WHERE sys_user.usr_id = ?';

        $roles = $db->fetchRow($sql,$user);
		
		$defSession = Zend_Registry::get('defSession');
		$defSession->role = $roles['acl_role_id'];
		
        return $roles['acl_role_id'];
	}
 
}