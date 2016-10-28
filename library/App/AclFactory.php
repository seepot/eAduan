<?php
class App_AclFactory {
	public function createFileAcl(File $file, User $user) {
		$acl = null;
		if($file->getCategoryId() != null) {
			//if the file belongs to a category
			//we need to build the whole category based acl
			$category = $file->getCategory();
			$acl = $this->createCategoryAcl($category, $user);
			$acl->add($file, $category);
		}
		else {
			$acl = new Zend_Acl();
			$this->_createRoles($acl, $user);
			$acl->add($file);
		}

		$privileges = Privilege::findByFile($file);
		$this->_setPrivileges($acl, $privileges);
		return $acl;
	}

	public function createCategoryAcl(Category $category, User $user) {
		$acl = new Zend_Acl();
		$this->_createRoles($acl, $user);

		$categories = $category->getParents() + array($category);

		//Top category has no parent, so it's null at first
		$parent = null;
		foreach($categories as $c) {
			$acl->add($c, $parent);
			//next will have this as the parent
			$parent = $c;
		}

		$privileges = Privilege::findByCategories($categories);
		$this->_setPrivileges($acl, $privileges);
		return $acl;
	}

	private function _setPrivileges($acl, $privileges) {
		foreach($privileges as $privilege) {
			$role = $privilege->getRole();
			$resource = $privilege->getResource();
			//the user's roles should already exist so we can
			//ignore the ones that don't
			if(!$acl->hasRole($role)) {
				continue;
			}

			if($privilege->getMode() == 'allow')
				$acl->allow($role, $resource);
			else
				$acl->deny($role, $resource);
		}
	}

	private function _createRoles(Zend_Acl $acl, User $user) {
		//add groups first so user can inherit them
		foreach($user->getGroups() as $group) {
			$acl->addRole($group);
		}

		$acl->addRole($user, $user->getGroups());
	}
}