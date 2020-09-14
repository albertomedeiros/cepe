<?php

class Gwm_PersonalController extends Gwm_ApplicationController
{
	public function changepassword()
	{
		$errors = array();
		
		if (isset($_POST['data'])) {
			$data = $_POST['data'];
			
			$current = $data['current'];
			$new = $data['new'];
			$confirm = $data['confirm'];
			
			if (!$this->user->check_password($current)) {
				$errors[] = 'A senha antiga n&atilde;o confere';
			}
			
			if ($new != $confirm) {
				$errors[] = 'A nova senha n&atilde;o est&aacute; igual a sua confirma&ccedil;&atilde;o';
			} elseif (strlen($new) < 6) {
				$errors[] = 'A nova senha deve ter no m&iacute;nimo 6 caracteres';
			}
			
			if (count($errors) == 0) {
				$this->user->password = $new;
				$this->user->save();
				
				$this->flash_msg = 'Senha alterada com sucesso!';
			}
		}
		
		$this->errors = $errors;
	}
}
