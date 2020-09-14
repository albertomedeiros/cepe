<?php

$this->title_bar = 'Grupos';

$table = array(
	'fields' => array(array('Nome', 'name', 'width="450"')),
	'data' => $this->data,
	'links' => $this->links,
	'base' => 'group'
);

$this->render_partial('datagrid', $table, array('controller' => 'gwm_main'));