<?php
$this->title_bar = '<li><span>Inscritos nas licitações</span></li>';

$table = array(
	'fields' => array(array('Título', 'title', 'width="350"'), array('Status', 'status_text', 'width="60"'), array('Data', 'date_published_f', 'width="100"')),
    'data' => $this->data,
    'links' => $this->links
);

$this->render_partial('datagrid_registers', $table, array('controller' => 'gwm_main'));