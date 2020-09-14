<?php

$this->title_bar = '<li><span>Concurso Cultural - Anexos</span></li>';

$this->btn_no_status = false;

$table = array(
    'fields' => array(
        array('Título', 'title', 'width="250"'),
        array('Criado', 'created_at', 'width="200"'),
    ),
    'data' => $this->data,
    'links' => $this->links,
);

$this->render_partial('datagrid', $table, array('controller' => 'gwm_main'));
