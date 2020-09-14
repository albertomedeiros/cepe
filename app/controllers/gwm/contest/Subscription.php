<?php

class Gwm_Contest_SubscriptionController extends Gwm_CrudController
{
    protected function record_class() { return 'ContestSubscription'; }
    protected function page_base() { return 'contest/subscription'; }

    public function all($query = array())
    {
        
        $this->subtitle = ' Inscrições';
        $array = array('order' => 'created_at asc');

        if ($this->param('status') != '') {
                
            $array['conditions'] = 'approved = '.$this->param('status');
            
            if ($this->param('status') == 'null') { $array['conditions'] = 'approved IS NULL'; }
        }

        if ($this->param('call') == 'approved') { 
            $this->subtitle = ' Obras'; 
        } elseif ($this->param('call') == 'cpl') {
            $this->subtitle = ' CPL';
        }

        parent::all($array);
    }

    public function open($query = array())
    {
        parent::all(array(
            'order' => 'created_at asc'
        ));

        $this->subtitle = ' Inscrições';
        $this->render('all');
    }

    public function cpl($query = array())
    {
        
        $array = array('order' => 'created_at asc');
        
        if ($this->param('genre') != '') {
                
            $array['conditions'] = 'genre = "'.$this->param('genre').'"';
            
        }

        parent::cpl($array);
        
        $this->subtitle = ' CPL';
        $this->call = 'cpl';
        $this->render('all');
    }

    public function approved($query = array())
    {
        
        $this->subtitle = ' Inscrições';
        $array = array('order' => 'created_at asc');

        if ($this->param('status') != '') {
                
            $array['conditions'] = 'approved = '.$this->param('status');
            
            if ($this->param('status') == 'null') { $array['conditions'] = 'approved IS NULL'; }
        }

        if ($this->param('call') == 'approved') { $this->subtitle = ' Obras'; }

        parent::all($array);

        $this->subtitle = ' Obras';
        $this->call = 'approved';
        $this->render('all');
    }

    public function edit()
    {
        $id = $this->param('id');
        $class = $this->record_class();
        $page = $this->page_base();

        $this->object = $id === null ? new $class() : ActiveRecord::model($class)->find($id);

        if (!empty($_POST)) {

            $data['contest_subscription_id'] = $id;
            $data['title'] = 'Cadastro habilitado com sucesso';
            $data['success'] = 3;

            $log = new ContestSubscriptionLog();
            $log->fill($data);
            $log->save();

            $this->object->approved = 1;
            $this->object->save();

            $this->redirect_to(array("action" => "all"));
        }

        $this->id = $id;

        if ($this->object->genre === 'nacional') {
            $categories = array(
                'conto' => 'Conto',
                'poesia' => 'Poesia',
                'romance' => 'Romance',
            );
        } else {
            $categories = array(
                'infantil' => 'Infantil',
                'juvenil' => 'Juvenil',
            );
        }

        $this->logs = ActiveRecord::model('ContestSubscriptionLog')->all(array('conditions' => 'contest_subscription_id = '.$id));

        $this->categories = $categories;
    }

    public function unable()
    {

        $contest_subscription_id = $_POST['data']['contest_subscription_id'];
        $this->addLog($contest_subscription_id, 0);

        foreach($_POST['data']['title'] as $title) {
            $data = array();
            if ($title !="") {
                $data['contest_subscription_id'] = $contest_subscription_id;
                $data['title'] = $title;
                $data['success'] = 0;

                $log = new ContestSubscriptionLog();
                $log->fill($data);
                $log->save();
            }
        }

        $this->redirect_to(array('action' => 'all'));
    }

    public function cancel()
    {

        $contest_subscription_id = $_POST['data']['contest_subscription_id'];
        $this->addLog($contest_subscription_id, 2);

        foreach($_POST['data']['title'] as $title) {
            $data = array();
            if ($title !="") {
                $data['contest_subscription_id'] = $contest_subscription_id;
                $data['title'] = $title;
                $data['success'] = 2;

                $log = new ContestSubscriptionLog();
                $log->fill($data);
                $log->save();
            }
        }

        $this->redirect_to(array('action' => 'all'));
    }

    private function addLog($contest_subscription_id, $approved)
    {   
       
        $object = ActiveRecord::model('ContestSubscription')->find($contest_subscription_id);
        $object->approved = $approved;
        $object->cancelled_at = date('Y-m-d H:i:s');
        $object->save();
        
    }
}
