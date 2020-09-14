<?php

class Register extends ActiveRecord
{
	public function setup()
	{
		$this->validates_presence_of('cpf_cnpj', 'A preenchimento do campo cpf_cnpj &eacute; obrigat&oacute;rio');
	}
}
