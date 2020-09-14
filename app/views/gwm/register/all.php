<?php

$this->title_bar = '<li><span>Registros - Licitações</span></li>';
$this->btn_down = true;
$this->btn_no_status = true;
$this->btn_no_new = true;
$this->btn_no_edit = true;

$table = array(
	'fields' => array(
		array('E-mail', 'email', 'width="450"'),
	),
	'data' => $this->data,
	'links' => $this->links
);

$this->render_partial('datagrid', $table, array('controller' => 'gwm_main'));
?>
