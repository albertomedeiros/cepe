<?php

$this->title_bar = '<li><span>Categorias</span></li>';

$table = array(
	'fields' => array(array('Nome', 'title', 'width="300"')),
	'data' => $this->data,
	'links' => $this->links,
	'base' => 'submenu'
);

$this->render_partial('datagrid', $table, array('controller' => 'gwm_main'));