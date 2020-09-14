<?php

class Gwm_EstruturaController extends Gwm_CrudController
{
    public function all($query=array())
    {
        $this->btn_no_status = false;

        $query['order'] = "date_published desc";
        parent::all($query);
    }

    public function edit()
    {
        $categories = ActiveRecord::model('Category')->all(array('order' => 'title'));
        $categoriesAno = array();
        // Verificando se as categorias são numéricas
        foreach($categories as $intChave => $arrValor){
            $intAno = (int) $arrValor->title;
            // Caso seja númerico
            if($intAno > 0){
                $categoriesAno[] = $arrValor;
            } 
        }
        $this->categories = $categoriesAno;
        // echo '<pre>';
        // print_r($this->categories);
        // die;
        

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

                $estrutura_id = $this->object->id;

                if (!$estrutura_id) {
                    $estrutura_id = ActiveRecord::model('Estrutura')->last()->id;
                }

                foreach ($_POST['data']['attachments_titles'] as $k => $title) {
                    if (!$title) continue;

                    $attachment['name'] = $_FILES['data']['attachments']['name'][$k];
                    $attachment['type'] = $_FILES['data']['attachments']['type'][$k];
                    $attachment['tmp_name'] = $_FILES['data']['attachments']['tmp_name'][$k];
                    $attachment['error'] = $_FILES['data']['attachments']['error'][$k];
                    $attachment['size'] = $_FILES['data']['attachments']['size'][$k];

                    $estrutura_file = new EstruturaFile;

                    $estrutura_file->estrutura_id = $estrutura_id;
                    $estrutura_file->title = $title;
                    $estrutura_file->path = $attachment;

                    $estrutura_file->save();
                }

                $this->redirect_to("gwm/estrutura/all");
            }else{
                echo "deu merda";die;
            }
        }

        $this->id = $id;
    }

    public function remove_file()
    {
        $estrutura_id = $this->param('estrutura_id');
        $id = $this->param('id');
        
        $file = ActiveRecord::model('EstruturaFile')->find($id);
        $file->destroy();

        $this->redirect_to(array("controller" => "gwm/estrutura", "action" => "edit/{$estrutura_id}"));
    }
}
