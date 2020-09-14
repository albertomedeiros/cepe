<?php

class Group extends ActiveRecord
{
	public function setup()
	{
		$this->validates_presence_of('name', 'A preenchimento do campo NOME &eacute; obrigat&oacute;rio');
		
		$this->named_scope('not_first', "id > 1");
		$this->named_scope('end_with_s', "name like '%s'");
		
		$this->has_many('roles', array('through' => 'groups_roles', 'local_field' => 'group_id'));
		$this->has_many('users', array('through' => 'users_groups', 'local_field' => 'group_id'));
	}
}
