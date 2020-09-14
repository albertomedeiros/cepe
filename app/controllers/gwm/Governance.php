<?php

class Gwm_GovernanceController extends Gwm_CrudController
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

                $governance_id = $this->object->id;

                if (!$governance_id) {
                    $governance_id = ActiveRecord::model('Governance')->last()->id;
                }

                foreach ($_POST['data']['attachments_titles'] as $k => $title) {
                    if (!$title) continue;

                    $attachment['name'] = $_FILES['data']['attachments']['name'][$k];
                    $attachment['type'] = $_FILES['data']['attachments']['type'][$k];
                    $attachment['tmp_name'] = $_FILES['data']['attachments']['tmp_name'][$k];
                    $attachment['error'] = $_FILES['data']['attachments']['error'][$k];
                    $attachment['size'] = $_FILES['data']['attachments']['size'][$k];

                    $governance_file = new GovernanceFile;

                    $governance_file->governance_id = $governance_id;
                    $governance_file->title = $title;
                    $governance_file->path = $attachment;

                    $governance_file->save();
                }

                $this->redirect_to("gwm/governance/all");
            }else{
                echo "deu merda";die;
            }
        }

        $this->id = $id;
    }

    public function remove_file()
    {
        $governance_id = $this->param('governance_id');
        $id = $this->param('id');
        
        $file = ActiveRecord::model('GovernanceFile')->find($id);
        $file->destroy();

        $this->redirect_to(array("controller" => "gwm/governance", "action" => "edit/{$governance_id}"));
    }
}
