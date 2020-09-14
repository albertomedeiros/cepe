<?php
class Gwm_BiddingRegisterController extends Gwm_CrudController
{
   
    public function all($query=array())
    {
    	
    	$array = array('order' => 'date_published desc');

    	if ($this->param('request') !="") {
    		$request = strtolower($this->param('request'));
    		$array["conditions"] = 'title LIKE "%'.$request.'%"';	
    	}

    	$this->data = ActiveRecord::model('Bidding')->all($array);
    	
    	//$array = array('order' => 'id asc');
    	//parent::all($query);

    } 

    public function edit($query=array())
    {

    	$id = $this->param('id');

    	$array['conditions'] = 'id= "' .  $id . '"';

        $this->data_bidding = ActiveRecord::model('Bidding')->first($array);

    	$query['select'] = 'registers.*';
        $query['joins']='inner join bidding_registers on (bidding_registers.register_id = registers.id and bidding_registers.bidding_id='.$id.')';
        
        $this->data = ActiveRecord::model('Register')->all($query);

    	//var_dump($this->data);

    } 



}