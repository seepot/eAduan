<?php

class ZFBlog_Aclx extends Zend_Acl
{
	private $_resourceId;

	public function setId($id) {
		$this->_resourceId = $id;
	}
	
	public function __construct(Zend_Auth $db2)
    {
    	$db = Zend_Registry::get ( 'db' );
    	                
        $sql = 'SELECT resource_id,
                       resource_name,
                       role_id
               	FROM acl_resource';

        $resources = $db->fetchAll($sql);

        $sql = 'SELECT acl_role.role_id,
                       acl_role.role_name,
                       inherits.role_name AS inherit_name
               FROM acl_role
               LEFT JOIN acl_role AS inherits ON inherits.role_id = acl_role.inherit_id
               ORDER BY acl_role.inherit_id ASC';

      	$roles = $db->fetchAll($sql);

        //Loop roles and put them in an assoc array by ID
        $roleArray = array();
        foreach($roles as $r)
        {
        	$role = new Zend_Acl_Role($r['role_name']);

            //If inherit_name isn't null, have the role
            //inherit from that, otherwise no inheriting
            if($r['inherit_name'] !== null)
            	$this->addRole($role,$r['inherit_name']);
            else
                $this->addRole($role);
				$roleArray[$r['role_id']] = $role;
       	}

       	foreach($resources as $r)
       	{
       		$resource = new Zend_Acl_Resource($r['resource_name']);

            $role = $roleArray[$r['role_id']];
                    
            $sql = 'SELECT privilege_name
                    FROM acl_privilege
                    WHERE resource_id = ?';
				
            $privilege = $db->fetchAssoc($sql,$r['resource_id']);
            $privileges = self::_hydrateRows($privilege);
					
            $this->add($resource);
            $this->allow($role,$resource,$privileges);
    	}
	}
        
	public function getrole($user)
    {
    	$db = Zend_Registry::get ( 'db' );
                
		$sql = 'SELECT acl_role.role_name
                FROM acl_role
                LEFT OUTER JOIN sys_user
                ON sys_user.role_id = acl_role.role_id
        		WHERE sys_user.usr_id = ?';

        $roles = $db->fetchRow($sql,$user);
        return $roles['role_name'];
	}
        
	public static function _hydrateRows($rows) 
	{
		$results = array();

		foreach($rows as $row) {
			$results[] = $row['privilege_name'];
		}
		
		return $results;
	}
}

