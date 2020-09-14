<?php

class Gwm_Contest_NewsController extends Gwm_CrudController
{
    protected function record_class() { return 'ContestNews'; }
    protected function page_base() { return 'contest/news'; }

    public function all($query = array())
    {
        parent::all(array('order' => 'date asc'));
    }
}
