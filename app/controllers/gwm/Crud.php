<?php

class Gwm_CrudController extends Gwm_ApplicationController
{
	protected function record_class() { return substr(get_class($this), 4, -10); }
	protected function page_base() { return strtolower($this->record_class()); }
	
	protected function expire_cache() {}
	
	//Quantidade de Itens por pagina
	protected $pagination_quantity_per_page = 50;

	public function index()
	{
		$this->redirect_to(array("action" => "all"));
	}
	
	protected function pagination_url()
	{
		return $this->url_to(array("action" => "all")) . '/';
	}
	
	public function all($query = array())
	{
		$page = $this->param('page', 1);
		$pagination = new Fishy_ArPagination($this->record_class(), $this->pagination_quantity_per_page, $query);

		$pagination->set_config('base_url', $this->pagination_url());
		$pagination->set_config('cur_page', $page);
		$this->configure_pagination($pagination);
		
		$this->links = $pagination->create_links(true);
		$this->data  = $pagination->data();
		$this->total = $pagination->get_total();

	}

	public function cpl($query = array())
	{
		$page = $this->param('page', 1);
		$pagination = new Fishy_ArPagination($this->record_class(), 10000, $query);

		$pagination->set_config('base_url', $this->pagination_url());
		$pagination->set_config('cur_page', $page);
		$this->configure_pagination($pagination);
		
		$this->links = $pagination->create_links(true);
		$this->data  = $pagination->data();
		$this->total = $pagination->get_total();

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
			
			$this->validate_and_save($this->object);
		}

		$this->id = $id;
	}

	public function activate()
	{
		$id = $this->param('id');
		$class = $this->record_class();
		$page = $this->param('page', 1);
		
		$object = ActiveRecord::model($class)->find($id);
		$object->status = 1;
		$object->save();

		$this->redirect_to(array("action" => "all", "page" => $page));
	}

	public function deactivate()
	{
		$id = $this->param('id');
		$class = $this->record_class();
		$page = $this->param('page', 1);
		
		$object = ActiveRecord::model($class)->find($id);
		$object->status = 0;
		$object->save();

		$this->redirect_to(array("action" => "all", "page" => $page));
	}
	
	protected function before_treat_data($object) {}
	
	protected function validate_and_save($object)
	{
		if ($object->is_valid()) {
			$object->save();
			$this->expire_cache();
			$this->redirect_to(array("action" => "all"));
		}
	}
	
	public function remove()
	{
		$id = $this->param('id', '');
		$ids = explode(',', $id);
		
		$records = ActiveRecord::model($this->record_class())->all(array('conditions' => array('id' => $ids)));
		
		foreach ($records as $record) {
			$record->destroy();
		}
		
		$this->expire_cache();
		
		$this->redirect_to(array("action" => "all"));
	}

	public function remove_image()
	{
		$id = $this->param('id');

		$record = ActiveRecord::model($this->record_class())->find($id);

		$path = FISHY_PUBLIC_PATH . '/' . $record->image;
		@unlink($path);

		$record->write_attribute('image', null);
		$record->save();

		$this->redirect_to(array('action' => 'edit', 'id' => $id));
	}

	public function remove_banner()
	{
		$id = $this->param('id');

		$record = ActiveRecord::model($this->record_class())->find($id);

		$path = FISHY_PUBLIC_PATH . '/' . $record->banner;
		$old_path = dirname($path);

		if (is_dir($old_path)) {
			$dir = dir($old_path);
			while($file = $dir->read()) {
				if(($file != '.') && ($file != '..')) {
					unlink($old_path.'/'.$file);
				}
			}
			$dir->close();
			rmdir($old_path);
		}

		$record->write_attribute('banner', null);
		$record->save();

		$this->redirect_to(array('action' => 'edit', 'id' => $id));
	}
}
