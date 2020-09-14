<?php

class ImageController extends ApplicationController
{
	public function view()
	{
		$model = $this->param('model');
		$field = $this->param('field');
		$id = $this->param('id');
		$format = $this->param('f', 'default');

		$class = ucfirst($model);
		$presets = $class::$presets;

		if (!$presets) {
			return;
		}

		$f = explode('x', $presets[$field][$format]);

		$setup = array(
			'width'   => $f[0],
			'height'  => $f[1],
			'mode'    => $f[2],
			'default' => isset($f[3]) ? $f[3] : '',
			'grow'    => isset($f[4]) ? $f[4] : true,
			'bgcolor' => isset($f[5]) ? $f[5] : '#ffffff'
		);

		$this->image_cache($model, $field, $id, $setup);
	}
}