<?php

class Gwm_Contest_AttachmentController extends Gwm_CrudController
{
    protected function record_class() { return 'ContestAttachment'; }
    protected function page_base() { return 'contest/attachments'; }

    public function all($query = array())
    {
        parent::all(array('order' => 'created_at asc'));
    }

    public function edit()
    {
        if($_POST) {
            $_POST['data']['contest'] = 'cultural_contest_2019';
        }

        parent::edit();
    }
}
