<?php

$this->title_bar = '<li><span>Concurso Cultural - '. $this->subtitle .'</span></li>';
$this->btn_no_status = true;
$this->btn_no_new = true;
$this->btn_no_remove = true;

$table = array(
    'fields' => array(
        array('N Inscrição', 'code', 'width="100"'),
        array('Autor', 'name', 'width="150"'),
        array('Pseudonimo', 'pseudonym', 'width="150"'),
        array('RG', 'rg', 'width="150"'),
        array('Estado', 'state', 'width="150"'),
        array('Obra', 'work_title', 'width="100"'),
        array('Categoria', 'category', 'width="100"'),
        array('Status', 'approved', 'width="100"'),
    ),
    'data' => $this->data,
    'links' => $this->links,
);

if (get_class($this->data[0]) == "ContestSubscription" && ($this->call == 'approved' || $this->param('call') == 'approved')) {
    $this->render_partial('datagrid_composition', $table, array('controller' => 'gwm_main'));
} elseif (get_class($this->data[0]) == "ContestSubscription" && ($this->call == 'cpl' || $this->param('call') == 'cpl')) {
    $this->render_partial('datagrid_cpl', $table, array('controller' => 'gwm_main'));
} else {
    $this->render_partial('datagrid', $table, array('controller' => 'gwm_main'));
}