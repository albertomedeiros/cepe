<?php

$this->title_bar = '<li><span>Menus</span></li>';

$table = array(
	'fields' => array(array('Nome', 'name', 'width="450"')),
	'data' => $this->data,
	'links' => $this->links,
	'base' => 'menu'
);

$this->render_partial('datagrid', $table, array('controller' => 'gwm_main'));