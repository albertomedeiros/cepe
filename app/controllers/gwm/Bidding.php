<?php

class Gwm_BiddingController extends Gwm_CrudController
{
    public function all($query=array())
    {
        $this->btn_no_status = false;

        $query['order'] = "date_published desc";
        parent::all($query);
    }

    public function edit()
    {
        $id = $this->param('id');
        $class = $this->record_class();
        $page = $this->page_base();
        
        $this->object = $id === null ? new $class() : ActiveRecord::model($class)->find($id);
        
        if (isset($_POST['data'])) {
            $this->object->fill($_POST['data']);
            $this->before_treat_data($this->object);
            
            if ($this->object->is_valid()) {
                $this->object->save();
                $this->expire_cache();

                $bidding_id = $this->object->id;

                if (!$bidding_id) {
                    $bidding_id = ActiveRecord::model('Bidding')->last()->id;
                }

                foreach ($_POST['data']['attachments_titles'] as $k => $title) {
                    if (!$title) continue;

                    $attachment['name'] = $_FILES['data']['attachments']['name'][$k];
                    $attachment['type'] = $_FILES['data']['attachments']['type'][$k];
                    $attachment['tmp_name'] = $_FILES['data']['attachments']['tmp_name'][$k];
                    $attachment['error'] = $_FILES['data']['attachments']['error'][$k];
                    $attachment['size'] = $_FILES['data']['attachments']['size'][$k];

                    $bidding_file = new BiddingFile;

                    $bidding_file->bidding_id = $bidding_id;
                    $bidding_file->title = $title;
                    $bidding_file->path = $attachment;

                    $bidding_file->save();
                }

                $this->redirect_to("gwm/bidding/all");
            }
        }

        $this->id = $id;
    }

    public function remove_file()
    {
        $bidding_id = $this->param('bidding_id');
        $id = $this->param('id');
        
        $file = ActiveRecord::model('BiddingFile')->find($id);
        $file->destroy();

        $this->redirect_to(array("controller" => "gwm/bidding", "action" => "edit/{$bidding_id}"));
    }
}
