<?php

class Gwm_ApplicationController extends ApplicationController
{
	private $_active_user;
	private $_active_language;
	protected $_server_url;
	
	protected function initialize()
	{
		if (isset($_SERVER['PATH_INFO']) || isset($_SERVER['ORIG_PATH_INFO'])) {
			$this->_server_url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $_SERVER['ORIG_PATH_INFO'];
		}

		$this->_active_user = false;
		$this->_active_language = false;
		
		if (!$this->logged() && Fishy_Uri::segment(1) != 'login') {
			$this->redirect_to('gwm/login?backurl=' . Fishy_Uri::segment_slice(0));
		}
		
		$this->_layout = 'gwm';
		
		$this->user = $this->get_current_user();
		$this->language_gwm = $this->get_current_language_gwm();

		switch ($this->language_gwm) {
			case "pt_br":
				$lang_text = "Portugu&ecirc;s";
				$lang_icon = "brasil";
				break;
			case "en_us":
				$lang_text = "Ingl&ecirc;s";
				$lang_icon = "usa";
				break;
			case "es_es":
				$lang_text = "Espanhol";
				$lang_icon = "espanha";
				break;
			default:
				$lang_text = "Portugu&ecirc;s";
				$lang_icon = "brasil";
				break;
		}

		$this->lang_text = $lang_text;

		$hours = (int) date("H");
		$msg = "";

		if ($hours >=  0) $msg = "Madrugou hoje";
		if ($hours >  5) $msg = "Bom dia";
		if ($hours >= 12) $msg = "Boa tarde";
		if ($hours > 17) $msg = "Boa noite";
		if ($hours > 22) $msg = "Hora de descansar";

		$this->greeting_message = $msg;

		$this->btn_no_status = true;

		if (isset($_SESSION['submenus'])) {
			$arr = array();
			
			if (is_object($this->user)) {
				foreach ($this->user->individual_submenus() as $submenu_id) {
					$submenu = ActiveRecord::model('Submenu')->find($submenu_id);
					$arr[$submenu->menu->id][] = $submenu;
				}
			}

			ksort($arr);

			$this->_menus = $arr;
		}

		$this->has_access();
	}

	private function has_access()
	{
		if (Fishy_Uri::segment(1) != '' && Fishy_Uri::segment(1) != 'change_password' && Fishy_Uri::segment(1) != 'login' && Fishy_Uri::segment(1) != 'logout' && Fishy_Uri::segment(1) != 'menu' && Fishy_Uri::segment(1) != 'change_language' && Fishy_Uri::segment(1) != 'submenu' && Fishy_Uri::segment(1) != 'main') {
			$access_denied = true;

			foreach ($this->user->submenus as $submenu) {
				if ($submenu->controller == Fishy_Uri::segment(1) || $submenu->controller == Fishy_Uri::segment(1) . "/" . Fishy_Uri::segment(2)) {
					$access_denied = false;

					break 1;
				}
			}

			if ($access_denied) {
				$this->redirect_to('gwm');
				exit;
			}
		}
	}

	public function active_menu($menu)
	{
		$active = false;

		foreach ($menu->submenus as $submenu) {
			if (strpos($this->_server_url, $submenu->controller) !== false) {
				$active = true;

				break 1;
			}
		}
		
		return $active;
	}
	
	public function site_url($path = '')
	{
		return parent::site_url('gwm/' . $path);
	}
	
	public function public_url($path = '')
	{
		return parent::public_url('gwm/' . $path);
	}
	
	protected function get_current_user()
	{
		if ($this->_active_user === false) {
			$id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
			
			$this->_active_user = $id ? ActiveRecord::model('User')->find($id) : null;
		}
		
		return $this->_active_user;
	}
	
	protected function set_current_user($user)
	{
		if ($user === null) {
			session_destroy();
		} else {
			$_SESSION['user_id'] = $user->id;
		}
		
		$this->_active_user = $user;
	}

	protected function get_current_language_gwm()
	{
		if ($this->_active_language === false) {
			$this->_active_language = isset($_SESSION['language_id']) ? $_SESSION['language_id'] : null;
		}
		
		return $this->_active_language;
	}
	
	protected function set_current_language_gwm($language)
	{
		if ($language === null) {
			$_SESSION['language_id'] = null;
		} else {
			$_SESSION['language_id'] = $language;
		}
		
		$this->_active_language = $language;
	}
	
	protected function refresh_user_submenus()
	{
		$_SESSION['submenus'] = $this->get_current_user()->individual_submenus();
	}
	
	protected function logged()
	{
		return $this->get_current_user() !== null;
	}

	public function date_format($date, $format_in, $format_out)
	{
		$date_ = DateTime::createFromFormat($format_in, $date);
		return date($format_out, $date_->getTimestamp());
	}
	
	protected function configure_pagination($pagination)
	{
		$pagination->set_config(array(
			'num_links'       => 10,
		
			'full_tag_open'   => '',
			'full_tag_close'  => '',
			
			'first_link'      => '',
			'first_tag_open'  => '',
			'first_tag_close' => '',
			
			'last_link'       => '',
			'last_tag_open'   => '',
			'last_tag_close'  => '',
			
			'next_link'       => 'Pr&oacute;xima &rarr;',
			'next_tag_open'   => '<li class="next">',
			'next_tag_close'  => '</li>',
			
			'prev_link'       => '&larr; Anterior',
			'prev_tag_open'   => '<li class="prev">',
			'prev_tag_close'  => '</li>',
			
			'first_inactive_link'       => '',
			'first_inactive_tag_open'   => '',
			'first_inactive_tag_close'  => '',
			
			'last_inactive_link'       => '',
			'last_inactive_tag_open'   => '',
			'last_inactive_tag_close'  => '',
			
			'next_inactive_link'       => 'Pr&oacute;xima &rarr;',
			'next_inactive_tag_open'   => '<li class="next disabled"><a href="#">',
			'next_inactive_tag_close'  => '</a></li>',
			
			'prev_inactive_link'       => '&larr; Anterior',
			'prev_inactive_tag_open'   => '<li class="prev disabled"><a href="#">',
			'prev_inactive_tag_close'  => '</a></li>',
			
			'cur_tag_open'   => '<li class="active"><a href="#">',
			'cur_tag_close'  => '</a></li>',
			
			'num_tag_open'   => '<li>',
			'num_tag_close'  => '</li>'
		));
	}

	public function objects()
	{
		$this->_render_layout = false;
		
		$objGetFunc = $this->param("objGetFunc");
		$objCountFunc = $this->param("objCountFunc");
		$objMaxDrops = $this->param("objMaxDrops");
		$objCbFunc = $this->param("objCbFunc");


		$src = "main?objGetFunc=" . $objGetFunc . "&objCountFunc=" . $objCountFunc . "&objMaxDrops=" . $objMaxDrops . "&objCbFunc=" . $objCbFunc;
		$this->render_partial('objects', $src, array('controller' => 'gwm_main'));
	}

	public function main()
	{
		$this->_render_layout = false;

		$this->objGetFunc = $this->param("objGetFunc");
		$this->objCountFunc = $this->param("objCountFunc");
		$this->objMaxDrops = $this->param("objMaxDrops");
		$this->objCbFunc = $this->param("objCbFunc");

		$this->render_partial('main', null, array('controller' => 'gwm_main'));
	}

	public function top()
	{
		$this->_render_layout = false;

		$this->render_partial('top', null, array('controller' => 'gwm_main'));
	}

	public function menu()
	{
		$this->_render_layout = false;

		$galleries = ActiveRecord::model('Gallery')->all(array('conditions' => array('parent_id' => 0), 'order' => 'name asc'));

		$this->render_partial('menu.multiloader', $galleries, array('as' => 'galleries', 'controller' => 'gwm_main'));
	}

	public function getObjectTypes()
	{
		$this->_render = false;

		header('content-type:text/xml; charset=utf-8');

		$output = new Fishy_StringBuilder();
		
		$output->appendln('<?xml version="1.0" encoding="utf-8" ?>');
		$output->appendln('<data>');
		$output->increase_indent();
		
		foreach (ActiveRecord::model('ObjectType')->all() as $entry) {
			$output->appendln('<objectType id="' . $entry->ext . '">');
			$output->increase_indent();

			$output->appendln("<type>{$entry->name}</type>");
			
			$output->decrease_indent();
			$output->appendln('</objectType>');
		}
		
		$output->decrease_indent();
		$output->appendln('</data>');
		
		echo $output->get_data();
	}

	public function gallerySave()
	{
		$this->_render = false;

		header('content-type:text/xml; charset=utf-8');

		$id = $this->param('objectGalleryId', false);
		$name = $this->param('folderName');
		$parent_id = $this->param('fatherId', 0);

		$gallery = $id !== false ? ActiveRecord::model('Gallery')->find($id) : new Gallery;

		$gallery->name = $name;
		$gallery->parent_id = $parent_id ? $parent_id : $gallery->parent_id;
		$gallery->save();

		$output = new Fishy_StringBuilder();
		
		$output->appendln('<?xml version="1.0" encoding="utf-8" ?>');
		$output->appendln('<data>');
		$output->increase_indent();

		if ($id) {
			$output->appendln('<id value="' . $id . '">');
		} else {
			if ($parent_id) {
				$output->appendln('<newId value="' . DbCommand::insert_id() . '" />');
			} else {
				$output->appendln('<newId value="" />');
			}
		}
		
		$output->decrease_indent();
		$output->appendln('</data>');
		
		echo $output->get_data();
	}

	public function getGalByFatherId()
	{
		$this->_render = false;

		header('content-type:text/xml; charset=utf-8');

		$parent_id = $this->param('fId');

		$galleries = ActiveRecord::model('Gallery')->all(array('conditions' => array('parent_id' => $parent_id), 'order' => 'name asc'));

		$output = new Fishy_StringBuilder();
		
		$output->appendln('<?xml version="1.0" encoding="utf-8" ?>');
		$output->appendln('<data>');
		$output->increase_indent();

		foreach ($galleries as $gallery) {
			$output->appendln('<gallery>');
			$output->increase_indent();

			$output->appendln("<id>{$gallery->id}</id>");
			$output->appendln("<name>{$gallery->name}</name>");
			
			$output->decrease_indent();
			$output->appendln('</gallery>');
		}
		
		$output->decrease_indent();
		$output->appendln('</data>');
		
		echo $output->get_data();
	}

	public function getGalleryDep()
	{
		$this->_render = false;

		header('content-type:text/xml; charset=utf-8');

		$id = $this->param('refGalleryId');

		$gallery = ActiveRecord::model('Gallery')->find($id);

		$output = new Fishy_StringBuilder();
		
		$output->appendln('<?xml version="1.0" encoding="utf-8" ?>');
		$output->appendln('<data>');
		$output->increase_indent();

		if (!$gallery->objects) {
			$galleries = ActiveRecord::model('Gallery')->all(array('conditions' => array('parent_id' => $id)));

			if (!$galleries) {
				$output->appendln("<canExclude />");
			}
		}

		$output->decrease_indent();
		$output->appendln('</data>');
		
		echo $output->get_data();
	}

	public function galleryDel()
	{
		$this->_render = false;

		header('content-type:text/xml; charset=utf-8');

		$id = $this->param('objectGalleryId');

		$gallery = ActiveRecord::model('Gallery')->find($id);

		$output = new Fishy_StringBuilder();
		
		$output->appendln('<?xml version="1.0" encoding="utf-8" ?>');
		$output->appendln('<data>');
		$output->increase_indent();

		if (!$gallery->objects) {
			$galleries = ActiveRecord::model('Gallery')->all(array('conditions' => array('parent_id' => $id)));

			if (!$galleries) {
				$gallery->destroy();
				$output->appendln('<result value="' . $id . '"/>');
			}
		}
		
		$output->decrease_indent();
		$output->appendln('</data>');
		
		echo $output->get_data();
	}

	public function getObjectsByGallery()
	{
		$this->_render = false;

		header('content-type:text/xml; charset=utf-8');

		$objectGalleryId = $this->param('objectGalleryId');
		$objectTypeId = $this->param('objectTypeId', '#');
		$maxRows = $this->param('maxRows');
		$query = $this->param('query');
		$imgSrcView = $this->param('imgSrcView');
		$imgSrcThumb = $this->param('imgSrcThumb');
		$itemsPage = $this->param('itemsPage');
		$page = $this->param('page', 1);

		if (!$itemsPage) {
			$maxRows = 15;
		} else {
			$maxRows = $itemsPage;
		}

		$thumbWidth = 90;
		$thumbHeight = 67;
		$viewWidth = 400;
		$viewHeight = 300;

		$startRow = (($page - 1) * $maxRows);

		if (!$query) {
			if (!$objectGalleryId) {
				//Pega últimos objetos inseridos objetos
				$objectsPage = ActiveRecord::model('Object')->all(array('order' => 'id desc', 'offset' => $startRow, 'limit' => $maxRows));
				$totalRows = $maxRows;
			} else {
				//Pega objetos por galeria
				$conditions = array('gallery_id' => $objectGalleryId);
				$objectsPage = ActiveRecord::model('Object')->all(array('conditions' => $conditions, 'order' => 'id desc', 'offset' => $startRow, 'limit' => $maxRows));
				$totalRows = ActiveRecord::model('Object')->count(array('conditions' => $conditions));
			}
		} else {
			if ($objectTypeId == "") {
				$conditions = 'description LIKE "%' . $query . '%"';
			} else {
				$conditions = 'object_type_id = "' . $objectTypeId . '" AND (description LIKE "%' . $query . '%")';	
			}
			
			$objectsPage = ActiveRecord::model('Object')->all(array('conditions' => $conditions, 'order' => 'display_order asc, id desc', 'offset' => $startRow, 'limit' => $maxRows));
			$totalRows = ActiveRecord::model('Object')->count(array('conditions' => $conditions));
		}

		if ($objectGalleryId) {
			$dir = FISHY_PUBLIC_PATH . "/uploads/" . $objectGalleryId;
			
			if (!is_dir($dir)) {
				mkdir($dir);
			}
		}

		$output = new Fishy_StringBuilder();
		
		$output->appendln('<?xml version="1.0" encoding="utf-8" ?>');
		$output->appendln('<data>');
		$output->increase_indent();

		foreach ($objectsPage as $obj) {
			//Verifica se o objeto é interno
			if ($obj->url != "") {
				$imgSrcThumb = $this->getThumbSrcByType($obj->object_type_id, $obj->id, $obj->gallery_id);
				$imgSrcView = $obj->objectURL;
			} else {
				//Gera arquivo thumb em disco
				if (strtolower($obj->object_type_id) == "jpg") {
					//Nova chamada mostrando a imagem na proporção correta
					$imgSrcView = $this->ShowObject($obj->id, $obj->object_type_id, $obj->description, $obj->gallery_id, $viewWidth, $viewHeight);
					$imgSrcThumb = $this->ShowObject($obj->id, $obj->object_type_id, $obj->description, $obj->gallery_id, $thumbWidth, $thumbHeight);
				} else {
					$imgSrcThumb = $this->getThumbSrcByType($obj->object_type_id, $obj->id, $obj->gallery_id);
					$imgSrcView = $this->getViewSrc($obj->id, $obj->gallery_id, $obj->object_type_id);
				}
			}

			$output->appendln("<object id='" . $obj->id . "' type='" . $obj->object_type_id . "' >");
			$output->increase_indent();

			$output->appendln("<description><![CDATA[" . $obj->description . "]]></description>");
			$output->appendln("<author><![CDATA[" . $obj->author . "]]></author>");
			$output->appendln("<keywords><![CDATA[" . $obj->keywords . "]]></keywords>");
			$output->appendln("<postDate><![CDATA[" . $obj->created_at('d/m/Y H:i') . "]]></postDate>");
			$output->appendln("<srcThumb><![CDATA[" . $imgSrcThumb . "]]></srcThumb>");
			$output->appendln("<srcView><![CDATA[" . $imgSrcView . "]]></srcView>");

			$output->decrease_indent();
			$output->appendln("</object>");
		}

		$navbar = new Navbar($page, $maxRows, $totalRows);
		$output->appendln("<navBar prevPage='" . $navbar->PrevPage() . "' nextPage='" . $navbar->NextPage() . "' lastPage='" . $navbar->LastPage() . "' thisPage='" . $page . "' />");

		$output->decrease_indent();
		$output->appendln('</data>');

		echo $output->get_data();
	}

	protected function getThumbSrcByType($type, $id, $objectGalleryId)
	{
		$src = "";

		switch(strtolower($type)) {
			case "gif":
			case "png":
				$src = $this->public_url('../uploads') . "/" . $objectGalleryId . "/" . $id . "." . $type;

				$dir_real = FISHY_PUBLIC_PATH . '/uploads/' . $objectGalleryId . "/" . $id . "." . $type;

				if (!file_exists($dir_real)) {
					$obj = ActiveRecord::model('Object')->find($id);
					file_put_contents($dir_real, $obj->blob);
				}

				break;

			default:
				$src = $this->public_url('img/obj') . "/" . $type . ".gif";
				break;
		}

		return $src;
	}

	protected function getViewSrc($id, $objectGalleryId, $type_id)
	{
		$src = "";
		$src = $this->public_url('../uploads') . "/" . $objectGalleryId . "/" . $id . "." . $type_id;

		$dir_real = FISHY_PUBLIC_PATH . '/uploads/' . $objectGalleryId . "/" . $id . "." . $type_id;

		if (!file_exists($dir_real)) {
			$obj = ActiveRecord::model('Object')->find($id);
			file_put_contents($dir_real, $obj->blob);
		}
		
		return $src;
	}

	public function getObjectsByModuleObjId()
	{
		$this->_render = false;

		header('content-type:text/xml; charset=utf-8');

		$moduleObjId = $this->param('moduleObjId');
		$moduleTypeId = $this->param('moduleTypeId');

		$objects = ActiveRecord::model('ContentObject')->all(array(
			'select' => 'content_objects.*',
			'joins' => 'right join objects on objects.id = content_objects.object_id',
			'conditions' => array(
				'content_id' => $moduleObjId, 
				'module' => $moduleTypeId,
				),
			'order' => 'objects.display_order',
			));
		
		$thumbWidth = 90;
		$thumbHeight = 67;
		$viewWidth = 400;
		$viewHeight = 300;
		$zoomWidth = 800;

		$output = new Fishy_StringBuilder();
		
		$output->appendln('<?xml version="1.0" encoding="utf-8" ?>');
		$output->appendln('<data>');
		$output->increase_indent();

		foreach ($objects as $obj) {
			$obj = ActiveRecord::model('Object')->find($obj->object_id);

			if ($obj->object_type_id == "jpg") {
				$imgSrcThumb = $this->ShowObject($obj->id, $obj->object_type_id, $obj->description, $obj->gallery_id, $thumbWidth, $thumbHeight);
				$imgSrcZoom = $this->ShowObject($obj->id, $obj->object_type_id, $obj->description, $obj->gallery_id, $zoomWidth, 0);

				if ($viewHeight != 0) {
					$imgSrcView = $this->ShowObject($obj->id, $obj->object_type_id, $obj->description, $obj->gallery_id, $viewWidth, $viewHeight);
				} else {
					$imgSrcView = $this->ShowObject($obj->id, $obj->object_type_id, $obj->description, $obj->gallery_id, $viewWidth, 0);
				}
			} else {
				$imgSrcThumb = $this->getThumbSrcByType($obj->object_type_id, $obj->id, $obj->gallery_id);
				$imgSrcView = $this->getViewSrc($obj->id, $obj->gallery_id, $obj->object_type_id);
				$imgSrcZoom = $imgSrcView;
			}

			$output->appendln("<object id='" . $obj->id . "' type='" . $obj->object_type_id . "' >");
			$output->increase_indent();
			
			$output->appendln("<description><![CDATA[" . $obj->description . "]]></description>");
			$output->appendln("<author><![CDATA[" . $obj->author . "]]></author>");
			$output->appendln("<postDate><![CDATA[" . $obj->created_at('d/m/Y H:i') . "]]></postDate>");
			$output->appendln("<srcThumb><![CDATA[" . $imgSrcThumb . "]]></srcThumb>");
			$output->appendln("<srcView><![CDATA[" . $imgSrcView . "]]></srcView>");
			$output->appendln("<srcZoom><![CDATA[" . $imgSrcZoom . "]]></srcZoom>");

			$output->decrease_indent();
			$output->appendln("</object>");
		}
		
		$output->decrease_indent();
		$output->appendln('</data>');
		
		echo $output->get_data();
	}

	public function getObjectsByObjId()
	{
		$this->_render = false;

		header('content-type:text/xml; charset=utf-8');

		$aObj = $this->param('aObj');
		$vW = $this->param('vW');

		//Configurações tamanho das imagens
		$thumbWidth = 90;
		$thumbHeight = 67;

		$viewWidth = 400;
		$viewHeight = 300;
		
		$zoomWidth = 800;

		if ($vW) {
			$viewWidth = $vW;
			$viewHeight = 0;
		} else {
			$viewWidth = 400;
			$viewHeight = 300;
		}

		$output = new Fishy_StringBuilder();
		
		$output->appendln('<?xml version="1.0" encoding="utf-8" ?>');
		$output->appendln('<data>');
		$output->increase_indent();

		if ($aObj) {
			$arr_id = explode(",", $aObj);

			foreach ($arr_id as $id) {
				$obj = ActiveRecord::model('Object')->find($id);

				if ($obj->object_type_id == "jpg") {
					$imgSrcThumb = $this->ShowObject($obj->id, $obj->object_type_id, $obj->description, $obj->gallery_id, $thumbWidth, $thumbHeight);
					$imgSrcZoom = $this->ShowObject($obj->id, $obj->object_type_id, $obj->description, $obj->gallery_id, $zoomWidth, 0);

					//Se veio um tamanho customizado, gera imagem com altura proporcional
					if ($viewHeight != 0) {
						$imgSrcView = $this->ShowObject($obj->id, $obj->object_type_id, $obj->description, $obj->gallery_id, $viewWidth, $viewHeight);
					} else {
						$imgSrcView = $this->ShowObject($obj->id, $obj->object_type_id, $obj->description, $obj->gallery_id, $viewWidth, $viewHeight);
					}
				} else {
					$imgSrcThumb = $this->getThumbSrcByType($obj->object_type_id, $obj->id, $obj->gallery_id);
					$imgSrcView = $this->getViewSrc($obj->id, $obj->gallery_id, $obj->object_type_id);
					$imgSrcZoom = $imgSrcView;
				}

				$output->appendln("<object id='" . $obj->id . "' type='" . $obj->object_type_id . "' >");
				$output->appendln("<description><![CDATA[" . $obj->description . "]]></description>");
				$output->appendln("<author><![CDATA[" . $obj->author . "]]></author>");
				$output->appendln("<postDate><![CDATA[" . $obj->created_at('d/m/Y H:i') . "]]></postDate>");
				$output->appendln("<srcThumb><![CDATA[" . $imgSrcThumb . "]]></srcThumb>");
				$output->appendln("<srcView><![CDATA[" . $imgSrcView . "]]></srcView>");
				$output->appendln("<srcZoom><![CDATA[" . $imgSrcZoom . "]]></srcZoom>");
				$output->appendln("</object>");
			}
		}
		
		$output->decrease_indent();
		$output->appendln('</data>');
		
		echo $output->get_data();
	}

	public function objects_edt_img()
	{
		$this->_render = false;

		$objectId = $this->param('objectId');
		$objectGalleryId = $this->param('objectGalleryId');

		$object = ActiveRecord::model('Object')->find($objectId);
		$this->types = ActiveRecord::model('ObjectType')->all();

		$object->path = $this->ShowObject($object->id, $object->object_type_id, $object->description, $object->gallery_id, 90, 67);

		$this->render_partial('objects_edit_image', $object, array('as' => 'object', 'controller' => 'gwm_main'));
	}

	public function objects_edt()
	{
		$this->_render = false;

		$this->objectId = $this->param('objectId');
		$this->objectGalleryId = $this->param('objectGalleryId');
		$this->types = ActiveRecord::model('ObjectType')->all();

		$this->render_partial('objects_edit', null, array('controller' => 'gwm_main'));
	}

	public function object_save_image()
	{
		$this->_render = false;

		$id = $this->param('id');
		$gallery_id = $this->param('gallery_id');
		$description = $this->param('description');
		$author = $this->param('author');

		$object = ActiveRecord::model('Object')->find($id);

		$object->description = $description;
		$object->author = $author;

		if ($object->is_valid()) {
			$object->save();
		}

		$restoreObjects = "
			<script>
				window.parent.hideEditArea();
				window.parent.loadObjects();
			</script>
		";

		echo $restoreObjects;
	}




	public function object_save()
	{
		$this->_render = false;

		foreach ($_POST as $field => $value) {
			$$field = $value;
		}

		$file = $_FILES['blob'];

		$object = $id != '' ? ActiveRecord::model('Object')->find($id) : new Object;

		$new_description = $description;
		$filesize = $file['size'];
		$filename = $file['name'];
		$hash = uniqid(time());
		$blob = file_get_contents($file['tmp_name']);

		$ext = pathinfo($filename, PATHINFO_EXTENSION);

		if (strtolower($ext) == "zip") {
			$zip = zip_open($file['tmp_name']);

			if (is_resource($zip)) {
				while ($zip_entry = zip_read($zip)) {
					if (zip_entry_open($zip, $zip_entry, "r")) {
						$filesize = zip_entry_filesize($zip_entry);
						$filename = zip_entry_name($zip_entry);
						$blob = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

						zip_entry_close($zip_entry);

						if ($type == "jpg") {
							if ($zip_description != "#") {
								$pos = strrpos($filename, ".");

								$filename_original = substr($filename, 0, $pos);

								switch ($zip_description) {
									case '1':
										$new_description = $filename_original;
										break;
									case '2':
										$new_description = $description;
										break;
									case '3':
										$new_description = $description . " - " . $filename_original;
										break;
									
									default:
										break;
								}
							}
						}

						$object = new Object;

						$object->object_type_id = $type;
						$object->gallery_id = $gallery_id;
						$object->description = $new_description;
						$object->author = $author;
						$object->blob = $blob;
						$object->filesize = $filesize;
						$object->filename = $filename;
						$object->hash = $hash;
						$object->orientation = 'V';

						if ($object->is_valid()) {
							$object->save();

							$this->saveFile($object);
						}
					}
				}

				zip_close($zip);
			}
		} else {			
			$object->object_type_id = $type;
			$object->gallery_id = $gallery_id;
			$object->description = $new_description;
			$object->author = $author;
			$object->blob = $blob;
			$object->filesize = $filesize;
			$object->filename = $filename;
			$object->hash = $hash;
			$object->orientation = 'V';

			if ($object->is_valid()) {
				$object->save();

				$this->saveFile($object);
			}
		}

		$restoreObjects = "
			<script>
				window.parent.hideEditArea();
				window.parent.loadObjects();
			</script>
		";

		echo $restoreObjects;
	}

	private function saveFile($obj) 
	{
		$id = $obj->id != '' ? $obj->id : DbCommand::insert_id();

		$dir = FISHY_PUBLIC_PATH . '/uploads/';
		
		if (!is_dir($dir)) {
			mkdir($dir);
		}

		if (!is_dir($dir . $obj->gallery_id)) {
			mkdir($dir . $obj->gallery_id);
		}

		$path =  $dir . $obj->gallery_id . "/" . $id . "." . $obj->object_type_id;
		
		try {
			file_put_contents($path, $obj->blob);
		} catch (Exception $e) {
			echo "Objeto Multidia UPLOAD", $e->getMessage();
		}
	}

	private function ShowObject($id, $object_type_id, $description, $gallery_id, $width, $height, $crop = 1)
	{
		$this->_render = false;

		$path = FISHY_PUBLIC_PATH . '/uploads/' . $gallery_id . "/" . $id . '.' . $width . 'x' . $height . '.' . $object_type_id;
		$path_redir = $this->public_url('../uploads/' . $gallery_id . '/' . $id . '.' . $width . 'x' . $height . '.' . $object_type_id);

		if (!file_exists($path)) {
			$dir = $this->public_url('../uploads/' . $gallery_id . '/' . $id . '.' . $object_type_id);

			$dir_real = FISHY_PUBLIC_PATH . '/uploads/' . $gallery_id . "/" . $id . "." . $object_type_id;

			if (!file_exists($dir_real)) {
				$obj = ActiveRecord::model('Object')->find($id);
				file_put_contents($dir_real, $obj->blob);
			}

			$path_save =  FISHY_PUBLIC_PATH . '/uploads/' . $gallery_id . "/" . $id . '.' . $width . 'x' . $height . '.' . $object_type_id;
			
			$image = new Fishy_Image($dir);
			$image->resize($width, $height, $crop);
			$image->save($path_save);
		}

		return $path_redir;
	}

	public function getObjectDep()
	{
		$this->_render = false;

		header('content-type:text/xml; charset=utf-8');

		$objectId = $this->param('objectId');

		$content_objects = ActiveRecord::model('ContentObject')->find_by_object_id($objectId);

		$output = new Fishy_StringBuilder();
		
		$output->appendln('<?xml version="1.0" encoding="utf-8" ?>');
		$output->appendln('<data>');
		$output->increase_indent();

		if (!$content_objects) {
			$output->appendln("<canExclude />");
		}

		$output->decrease_indent();
		$output->appendln('</data>');
		
		echo $output->get_data();
	}

	public function objectDel()
	{
		$this->_render = false;

		header('content-type:text/xml; charset=utf-8');

		$objectId = $this->param('objectId');

		$content_objects = ActiveRecord::model('ContentObject')->all(array("conditions" => array("object_id" => $objectId)));

		if ($content_objects) {
			foreach ($content_objects as $content) {
				$content->destroy();
			}
		}

		$object = ActiveRecord::model('Object')->find($objectId);
		
		if ($object) {
			$object->destroy();
		}

		$output = new Fishy_StringBuilder();
		
		$output->appendln('<?xml version="1.0" encoding="utf-8" ?>');
		$output->appendln('<data>');
		$output->increase_indent();

		$output->appendln('<result value="' . $objectId . '" />');

		$output->decrease_indent();
		$output->appendln('</data>');
		
		echo $output->get_data();
	}

	public function copyMoveSelected()
	{
		$this->_render = false;

		header('content-type:text/xml; charset=utf-8');

		$objectGalleryId = $this->param('objectGalleryId');
		$op = $this->param('op');
		$aObjects = $this->param('aObjects');
				
		$output = new Fishy_StringBuilder();
		
		$output->appendln('<?xml version="1.0" encoding="utf-8" ?>');
		$output->appendln('<data>');
		$output->increase_indent();

		if ($objectGalleryId && $aObjects) {
			//Resgata objectIds dos objetos selecionados
			$aObjectIds = explode(',', $aObjects);
			
			foreach ($aObjectIds as $objectId) {
				$obj = ActiveRecord::model('Object')->find($objectId);
				
				if ($op == 1) {
					//Copiar
					$new_obj = new Object;

					$new_obj->object_type_id = $obj->object_type_id;
					$new_obj->gallery_id = $objectGalleryId;
					$new_obj->description = $obj->description;
					$new_obj->author = $obj->author;
					$new_obj->url = $obj->url;
					$new_obj->blob = $obj->blob;
					$new_obj->filename = $obj->filename;
					$new_obj->filesize = $obj->filesize;
					$new_obj->hash = $obj->hash;
					$new_obj->orientation = $obj->orientation;
					$new_obj->created_at = $obj->created_at;

					$new_obj->save();

					$this->saveFile($new_obj);
				} else {
					//Mover
					$obj->gallery_id = $objectGalleryId;

					$obj->save();
					$this->saveFile($obj);
				}
			}

			$output->appendln('<result value="true">');
			$output->appendln('</result>');
		}

		$output->decrease_indent();
		$output->appendln('</data>');
		
		echo $output->get_data();
	}

	public function objects_order()
	{
		$this->_render = false;

		$order = json_decode($this->param('order'));

		if (count($order)) {
			foreach ($order as $obj) {
				$object = ActiveRecord::model('Object')->find($obj->id);

				$object->display_order = $obj->display_order;
				$object->save();
			}

			echo "ok";
		}
	}
}