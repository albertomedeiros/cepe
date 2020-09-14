<aside id="menu">
	<?php if ($this->user->login == 'FishyMaster'): ?>
	<nav<?= strpos($this->_server_url, "menu") !== false || strpos($this->_server_url, "submenu") !== false ? ' class="active"' : '' ?>>
		<a href="#" title="Sidebar" class="show-menu"><span>Desenvolvedor</span></a>
		<ul>
			<li><a href="<?= $this->url_to(array('controller' => 'gwm_menu')) ?>" title="Menus">Menus</a></li>
			<li><a href="<?= $this->url_to(array('controller' => 'gwm_submenu')) ?>" title="Submenus">Submenus</a></li>
		</ul>
	</nav>
	<?php endif ?>

	<?php foreach ($this->_menus as $menu_id => $submenus): ?>
	<?php $menu = ActiveRecord::model('Menu')->find($menu_id) ?>
	<nav<?= $this->active_menu($menu) ? ' class="active"' : '' ?>>
		<a href="#" title="Sidebar" class="show-menu"><span><?= $menu->name ?></span></a>
		<ul>
			<?php foreach ($submenus as $submenu): ?>
			<?php
				$url_to = array('controller' => 'gwm_' . $submenu->controller);

				if ($submenu->action) {
					$url_to = array_merge($url_to, array('action' => $submenu->action));
				}
			?>
			<?php if($submenu->name != "Pontos de Venda"):?>
				<li><a href="<?= $this->url_to($url_to) ?>" title="<?= $submenu->name ?>"><?= $submenu->name ?></a></li>
			<?php endif;?>
			<?php endforeach ?>
		</ul>
	</nav>
	<?php endforeach ?>
</aside><!-- #menu -->