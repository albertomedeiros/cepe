<?php

class ApplicationController extends Fishy_Controller
{
	private $_active_register;
	public $breadcrumbs = array();

	protected function initialize()
	{
		$this->_active_register = false;

		$detect = new MobileDetect;

		$this->isMobile = $detect->isMobile();
		$this->isTablet = $detect->isTablet();

		$this->meta_tags(array(
			'meta_title'       => '',
			'meta_description' => '',
			'meta_keywords'    => '',
			'meta_author'      => 'Fishy',
			'tt_creator'       => '',
			'tt_image'         => $this->site_url('img/content/img-compartilhamento.jpg'),
			'tt_title'         => '',
			'og_title'         => '',
			'tt_description'   => '',
			'og_description'   => '',
			'og_image'         => $this->site_url('img/content/img-compartilhamento.jpg'),
			'og_image_width'   => '300',
			'og_image_height'  => '300',
			'og_locale'        => 'pt-BR',
			'og_url'           => $this->current_url,
			'og_site_name'     => '',
		));

		$this->addBreadcrumbs('Página Inicial', $this->site_url(''));
	}

	protected function current_url()
	{
		return $this->site_url(Fishy_Uri::get_querystring());
	}

	public function get_current_register()
	{
		if ($this->_active_register === false) {
			$id = isset($_SESSION['register_id']) ? $_SESSION['register_id'] : 0;

			$this->_active_register = $id ? ActiveRecord::model('Register')->find($id) : null;
		}

		return $this->_active_register;
	}

	public function set_current_register($register)
	{
		if ($register === null) {
			session_destroy();
		} else {
			$_SESSION['register_id'] = $register->id;
		}

		$this->_active_register = $register;
	}

	public function show_object($obj, $width = 0, $height = 0, $crop = 1)
	{
		$tmp = $obj;

		if (is_array($tmp)) {
			$obj = $tmp[0];
		}

		$path = FISHY_PUBLIC_PATH . '/uploads/' . $obj->gallery_id . "/" . $obj->id . '.' . $width . 'x' . $height . '.' . $obj->object_type_id;
		$path_redir = $this->public_url('uploads/' . $obj->gallery_id . '/' . $obj->id . '.' . $width . 'x' . $height . '.' . $obj->object_type_id);

		if (!file_exists($path)) {
			$dir_real = FISHY_PUBLIC_PATH . '/uploads/' . $obj->gallery_id . "/" . $obj->id . "." . $obj->object_type_id;

			if (!file_exists($dir_real)) {
				$pos = strrpos($dir_real, "/");
				$dir_gallery = substr($dir_real, 0, $pos);

				if (!is_dir($dir_gallery)) {
					mkdir($dir_gallery, 0777);
				}

				$obj = ActiveRecord::model('Object')->find($obj->id);

				file_put_contents($dir_real, $obj->blob);
			}

			if ($width || $height) {
				$dir = $this->public_url('uploads/' . $obj->gallery_id . '/' . $obj->id . '.' . $obj->object_type_id);
				$path_save = FISHY_PUBLIC_PATH . '/uploads/' . $obj->gallery_id . "/" . $obj->id . '.' . $width . 'x' . $height . '.' . $obj->object_type_id;

				$image = new Fishy_Image($dir);
				$image->resize($width, $height, $crop);
				$image->save($path_save);
			} else {
				return $dir_real;
			}
		}

		return $path_redir;
	}

	protected function create_token($email)
	{
		return sha1(md5($email . '_fishy@mv#'));
	}

	protected function meta_tags($tags)
	{
		// ordem de precedência
		// 1. valor passado como patâmetro
		// 2. valor passado anteriormente como parâmetro
		// 3. valor padrão
		// $this->tags_METATAG = isset($tags['METATAG']) ? $tags['METATAG'] : ($this->tags_METATAG ? $this->tags_METATAG : '');

		$this->tags_meta_title       = isset($tags['meta_title'])       ? $tags['meta_title']       : ($this->tags_meta_title       ? $this->tags_meta_title       : '');
		$this->tags_meta_description = isset($tags['meta_description']) ? $tags['meta_description'] : ($this->tags_meta_description ? $this->tags_meta_description : '');
		$this->tags_meta_keywords    = isset($tags['meta_keywords'])    ? $tags['meta_keywords']    : ($this->tags_meta_keywords    ? $this->tags_meta_keywords    : '');
		$this->tags_meta_author      = isset($tags['meta_author'])      ? $tags['meta_author']      : ($this->tags_meta_author      ? $this->tags_meta_author      : '');
		$this->tags_tt_creator       = isset($tags['tt_creator'])       ? $tags['tt_creator']       : ($this->tags_tt_creator       ? $this->tags_tt_creator       : '');
		$this->tags_tt_image         = isset($tags['tt_image'])         ? $tags['tt_image']         : ($this->tags_tt_image         ? $this->tags_tt_image         : '');
		$this->tags_og_image         = isset($tags['og_image'])         ? $tags['og_image']         : ($this->tags_og_image         ? $this->tags_og_image         : '');
		$this->tags_tt_title         = isset($tags['tt_title'])         ? $tags['tt_title']         : ($this->tags_tt_title         ? $this->tags_tt_title         : '');
		$this->tags_og_title         = isset($tags['og_title'])         ? $tags['og_title']         : ($this->tags_og_title         ? $this->tags_og_title         : '');
		$this->tags_tt_description   = isset($tags['tt_description'])   ? $tags['tt_description']   : ($this->tags_tt_description   ? $this->tags_tt_description   : '');
		$this->tags_og_description   = isset($tags['og_description'])   ? $tags['og_description']   : ($this->tags_og_description   ? $this->tags_og_description   : '');
		$this->tags_og_image_width   = isset($tags['og_image_width'])   ? $tags['og_image_width']   : ($this->tags_og_image_width   ? $this->tags_og_image_width   : '');
		$this->tags_og_image_height  = isset($tags['og_image_height'])  ? $tags['og_image_height']  : ($this->tags_og_image_height  ? $this->tags_og_image_height  : '');
		$this->tags_og_locale        = isset($tags['og_locale'])        ? $tags['og_locale']        : ($this->tags_og_locale        ? $this->tags_og_locale        : '');
		$this->tags_og_url           = isset($tags['og_url'])           ? $tags['og_url']           : ($this->tags_og_url           ? $this->tags_og_url           : '');
		$this->tags_og_site_name     = isset($tags['og_site_name'])     ? $tags['og_site_name']     : ($this->tags_og_site_name     ? $this->tags_og_site_name     : '');
	}

	protected function addBreadcrumbs($title, $url='', $subtitle=false)
	{
		$this->breadcrumbs[] = array(
			'title' => $title,
			'url' => $url,
			'subtitle' => $subtitle,
		);
	}

  public function public_url_mobile($path = '')
  {
      $path = $this->public_url($path);

      if ($this->isMobile && !$this->isTablet) {
          $ext = pathinfo($path, PATHINFO_EXTENSION);

          $path = str_replace('.' . $ext, '-mobile.' . $ext, $path);
          $path = $this->public_url($path);
      }

      return $path;
  }

  /**
	 * Checa se endereço de email já foi cadastrado na tabela de newsletters
	*/
	protected function check_email($email)
	{
		$news = ActiveRecord::model('Newsletter')->all(array(
			'conditions' => array(
				'email' => $email
			)
		));

		return empty($news);
	}

	protected function page_not_found()
	{
		dispatch_error(new Exception("Page not found!"), 404);
	}

	protected function size_units($filename)
    {
    	$bytes = filesize($filename);

        if ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
	}

	public function import_news()
	{
		$this->import(10, 'News');
		echo "Done!";
	}

	public function import_biddings()
	{
		$this->import(9, 'Bidding');
		echo "Done!";
	}

	private function import($category_id, $model)
	{
		$this->_render_layout = false;

		$records = DbCommand::all("SELECT id, alias AS slug, title, IF(`fulltext` is NULL OR `fulltext` = '', introtext, `fulltext`) AS text, publish_up AS date_published, state AS status, created AS created_at from ceped_content where catid = $category_id and state = 1");

		foreach ($records as $item) {
			$news = new $model;

			$news->fill($item);
			$news->title = utf8_encode($item['title']);
			$text = utf8_encode($item['text']);

			$xpath = new DOMXPath(@DOMDocument::loadHTML($text));
			$image_list = $xpath->query("//img[@src]");
			
			if ($image_list) {
				for ($i = 0; $i < $image_list->length; $i++) {
					$src = $image_list->item($i)->getAttribute("src");

					if (strpos($src, 'http') === false) {
						$url = 'https://www.cepe.com.br/' . str_replace(' ', '%20', $src);
						$tmp = explode('/', $src);
						$filename = end($tmp);

						$content = file_get_contents($url);
						file_put_contents(FISHY_PUBLIC_PATH . '/uploads/data/files/' . $filename, $content);

						$image = 'https://www.cepe.com.br/uploads/data/files/' . $filename;
						$text = str_replace($src, $image, $text);
					}
				}
			}

			$news->text = $text;
			$news->save();

			list($date, $time) = explode(' ', $item['created_at']);
			$this->save_attachments($date, $item['id'], $model . 'File');
		}
	}

	private function save_attachments($date, $id, $model)
	{
		$path = FISHY_PUBLIC_PATH . '/article/' . $id . '/';

		if (is_dir($path) && $handle = opendir($path)) {
			while (false !== ($entry = readdir($handle))) {
				if ($entry != "." && $entry != ".." && strpos($entry, '.html') === false) {
					$entry = utf8_encode($entry);
					$new_name = self::normalize_filename($entry);
		
					$dir = FISHY_PUBLIC_PATH . '/uploads/';
					$rel_path = self::create_uniq_path($date, $dir, $new_name);
					$new_path = $dir . $rel_path;

					copy($path . utf8_decode($entry), $new_path);

					$file = new $model;

					$field = str_replace('file', '', strtolower($model)) . '_id';

                    $file->$field = $id;
                    $file->title = $entry;
                    $file->path = 'uploads/' . $rel_path;

                    $file->save();
				}
			}

			closedir($handle);
		}
	}

	private static function create_uniq_path($date, $dir, $name)
	{
		$arr_date = explode('-', $date);
		foreach ($arr_date as $value) {
			$bits[] = $value;
		}

		$current = "";
		
		foreach ($bits as $part) {
			$dir .= $part . '/';
			$current .= $part . '/';
			
			if (!is_dir($dir)) {
				mkdir($dir);
			}
		}
		
		return $current . uniqid() . '.' . $name;
	}

	private static function normalize_filename($name)
	{
		$name = Fishy_StringHelper::remove_accents($name);
		$name = str_replace(" ", "-", strtolower($name));
		$output = '';
		
		for ($i = 0; $i < strlen($name); $i++) {
			if (preg_match("/[a-z0-9.-]/", $name[$i])) {
				$output .= $name[$i];
			}
		}

		return $output;
	}
}
