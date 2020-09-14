<?php

$this->title_bar = 'Permissões';

$table = array(
	'fields' => array(array('Nome', 'name', 'width="450"')),
	'data' => $this->data,
	'links' => $this->links,
	'base' => 'role'
);

$this->render_partial('datagrid', $table, array('controller' => 'gwm_main'));