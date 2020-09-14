<?php

$this->title_bar = '<li><span>Concurso Cultural - Notícias</span></li>';
$this->btn_no_status = false;

$table = array(
    'fields' => array(
        array('Título', 'title', 'width="350"'),
        array('Data', 'date_f', 'width="100"'),
    ),
    'data' => $this->data,
    'links' => $this->links,
);

$this->render_partial('datagrid', $table, array('controller' => 'gwm_main'));
