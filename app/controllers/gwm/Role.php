<?php

class Gwm_RoleController extends Gwm_CrudController
{
	public function edit($id = null)
	{
		$this->roles = ActiveRecord::model('Role')->all(array('order' => 'name'));
		
		parent::edit($id);
	}
}
