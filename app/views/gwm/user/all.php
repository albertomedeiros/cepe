<?php

$this->title_bar = '<li><span>Usu&aacute;rios</span></li>';

$table = array(
	'fields' => array(array('Nome', 'name', 'width="250"'), array('E-mail', 'email', 'width="200"')),
	'data' => $this->data,
	'links' => $this->links,
	'base' => 'user'
);

$this->render_partial('datagrid', $table, array('controller' => 'gwm_main'));