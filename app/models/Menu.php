<?php

class Menu extends ActiveRecord
{
	public function setup()
	{
		$this->validates_presence_of('name', 'A preenchimento do campo NOME &eacute; obrigat&oacute;rio');

		$this->has_many('Submenu as submenus');
	}
}
