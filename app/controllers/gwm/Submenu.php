<?php

class Gwm_SubmenuController extends Gwm_CrudController
{
	public function edit($id = null)
	{
		$this->menus = ActiveRecord::model('Menu')->all(array('order' => 'name'));
		
		parent::edit($id);
	}
}
