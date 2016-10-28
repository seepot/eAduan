<?php

class ZFBlog_Acl extends Zend_Acl
{

    public function __construct(Zend_Auth $auth)
    {
        // Add Resources

        // Resource #1: Default Module
        $this->add(new Zend_Acl_Resource('default'));
        // Resource #2: Admin Module
        $this->add(new Zend_Acl_Resource('admin_user'));

        // Add Roles

        // Role #1: Guest
        $this->addRole(new Zend_Acl_Role('guest'));
        // Role #2: Author (inherits from Guest)
        $this->addRole(new Zend_Acl_Role('user'), 'guest');

        // Assign Access Rules

        // Rule #1 & #2: Guests can access Default Module (Author inherits this)
        $this->allow('guest', 'default');
        // Rule #3 & #4: Authors can access Admin Module (Guests denied by default)
        $this->allow('user', 'admin_user');
    }
}