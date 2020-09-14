<?php


class Gwm_MainController extends Gwm_ApplicationController
{
	public function index()
	{
	}

	public function login()
	{
		
		$this->_render_layout = false;
		
		if ($this->logged()) {
			$this->redirect_to('gwm');
		}
		

		$this->user = new User();
		$this->backurl = isset($_GET['backurl']) ? $_GET['backurl'] : 'gwm';
		

		if (isset($_POST['data'])) {
			$this->_render = false;
			
			$this->user->login = $_POST['data']['login'];
			$user = ActiveRecord::model('User')->find_by_login($_POST['data']['login']);
			
			if ($user && $user->check_password($_POST['data']['password'])) {
				$this->set_current_user($user);
				$this->set_current_language_gwm("pt_br");
				$this->refresh_user_submenus();
				
				echo "1";
			} else {
				echo "0";
			}
		}
	}
	
	public function logout()
	{
		$this->set_current_user(null);
		$this->redirect_to(array('action' => 'login'));
	}

	public function changelanguage()
	{
		$this->set_current_language_gwm($this->param('language'));
		$redir = $_SERVER['HTTP_REFERER'];

		if (strpos($redir, "edit") !== false) {
			$url = explode('edit', $redir);
			$redir = reset($url);
		}

		$this->redirect_to($redir);
	}
}