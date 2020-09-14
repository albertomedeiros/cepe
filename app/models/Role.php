<?php

class Role extends ActiveRecord
{
	public function setup()
	{
		$this->validates_presence_of('name', 'A preenchimento do campo NOME &eacute; obrigat&oacute;rio');
		
		$this->act_as_tree();
		
		$this->has_many('groups', array('through' => 'groups_roles', 'local_field' => 'role_id'));
		$this->has_many('users', array('through' => 'users_roles', 'local_field' => 'role_id'));
	}
}
