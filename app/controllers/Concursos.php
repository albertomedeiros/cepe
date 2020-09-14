<?php

class ConcursosController extends MainController
{
    public function index()
    {
        $this->meta_tags(array(
            'meta_title'       => 'Concursos | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => 'Concursos | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => 'Concursos | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Concursos');

        $page_url = $this->site_url('concursos/page/');
        $this->pagination('Tender', $page_url, 8);
    }

    public function view()
    {
        $slug = $this->param('slug');

        $tender = ActiveRecord::model('Tender')->find_by_slug($slug);

        if (!$tender) {
            $this->page_not_found();
        }

        $this->meta_tags(array(
            'meta_title'       => $tender->title . ' | Concursos | Cepe - Companhia Editora de Pernambuco',
            'tt_title'         => $tender->title . ' | Concursos | Cepe - Companhia Editora de Pernambuco',
            'og_title'         => $tender->title . ' | Concursos | Cepe - Companhia Editora de Pernambuco',
        ));

        $this->addBreadcrumbs('Concursos', $this->site_url('concursos'));
        $this->addBreadcrumbs($tender->title);

        $this->tender = $tender;
    }
}
