<?php

$this->title_bar = '<li><span>Submenus</span></li>';

$table = array(
	'fields' => array(array('Menu', 'menu_name', 'width="150"'), array('Nome', 'name', 'width="300"')),
	'data' => $this->data,
	'links' => $this->links,
	'base' => 'submenu'
);

$this->render_partial('datagrid', $table, array('controller' => 'gwm_main'));