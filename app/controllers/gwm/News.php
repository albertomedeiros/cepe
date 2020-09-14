<?php

class Gwm_NewsController extends Gwm_CrudController
{
    public function all($query=array())
    {
        $this->btn_no_status = false;

        $query['order'] = "date_published desc";
        parent::all($query);
    }

    public function edit()
    {
        $this->categories = ActiveRecord::model('Category')->all(array('order' => 'title'));
        
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

                $news_id = $this->object->id;

                if (!$news_id) {
                    $news_id = ActiveRecord::model('News')->last()->id;
                }

                foreach ($_POST['data']['attachments_titles'] as $k => $title) {
                    if (!$title) continue;

                    $attachment['name'] = $_FILES['data']['attachments']['name'][$k];
                    $attachment['type'] = $_FILES['data']['attachments']['type'][$k];
                    $attachment['tmp_name'] = $_FILES['data']['attachments']['tmp_name'][$k];
                    $attachment['error'] = $_FILES['data']['attachments']['error'][$k];
                    $attachment['size'] = $_FILES['data']['attachments']['size'][$k];

                    $news_file = new NewsFile;

                    $news_file->news_id = $news_id;
                    $news_file->title = $title;
                    $news_file->path = $attachment;

                    $news_file->save();
                }

                $this->redirect_to("gwm/news/all");
            }
        }

        $this->id = $id;
    }

    public function remove_file()
    {
        $news_id = $this->param('news_id');
        $id = $this->param('id');
        
        $file = ActiveRecord::model('NewsFile')->find($id);
        $file->destroy();

        $this->redirect_to(array("controller" => "gwm/news", "action" => "edit/{$news_id}"));
    }

    public function remove_image()
    {
        $id = $this->param('id');

        $news = ActiveRecord::model('News')->find($id);
        
        @unlink(FISHY_PUBLIC_PATH . '/' . $news->image);

        $news->write_attribute('image', null);
        $news->save();

        $this->redirect_to(array('action' => 'edit', 'id' => $id));
    }
}
