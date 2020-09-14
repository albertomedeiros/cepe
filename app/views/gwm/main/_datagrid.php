<script type="text/javascript" charset="utf-8">
_remove = function(id) {
	if (confirm('Remover esse item?')) {
		send_post('<?= $this->url_to(array("action" => "remove")) ?>', {id: id})
	}
};

_remove_selected = function() {
	var selected = $.map($(".filtered-list input.lista-check:checked"), function(v) {
		return v.value;
	});
	
	if (selected.length == 0) {
		$('.take-action select').get(0).selectedIndex = 0;
		alert('Selecione pelo menos um item para remover.');

		return;
	}
	
	if (confirm("Remover itens selecionados?")) {
		send_post('<?= $this->url_to(array("action" => "remove")) ?>', {id: selected.join(',')});
	}
};
</script>

<h2><?= strip_tags($this->title_bar) ?></h2>

<?php if (!$this->btn_no_new): ?>
<a href="<?= $this->url_to(array("action" => "edit")) ?>" title="Novo" class="button" style="margin-bottom:10px;">Novo</a>
<?php endif ?>

<?php if ($this->btn_down): ?>
<a href="<?= $this->url_to(array("action" => "download")) ?>" class="button" style="margin-bottom:10px;">Download lista</a>&nbsp;
<?php endif ?>

<?php 
if (get_class($this->data[0]) == "ContestSubscription"):
$url_filter = $this->url_to(array("action" => "all")).'/';

$url_filter_habilitado = $url_filter.'?status=1';
$url_filter_cancelado = $url_filter.'?status=2';
$url_filter_inabilitado = $url_filter.'?status=0';
$url_filter_pendente = $url_filter.'?status=null';

?>
<h4>Filtros</h4>
<ul class="filter">
	<li><a href="<?= $url_filter ?>">Todos</a></li>
	<li><a href="<?= $url_filter_habilitado ?>">Habilitados</a></li>
	<li><a href="<?= $url_filter_inabilitado ?>">Inabilitados</a></li>
	<li><a href="<?= $url_filter_cancelado ?>">Cancelados</a></li>
	<li><a href="<?= $url_filter_pendente ?>">Pendentes</a></li>
</ul>
<div style="float:right"><b>Total de Inscrições:</b> <?php print $this->total; ?></div>
<div style="clear:both"></div>
<?php endif; ?>	
<table id="sort-table" class="filtered-list" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th></th>
			<?php foreach ($data['fields'] as $field): ?>
			<th><?= $field[0] ?></th>
			<?php endforeach ?>
			<th>Funções</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($this->data) == 0): ?>
		<tr>
			<td colspan="<?= count($data['fields']) + (int)((!$this->btn_no_remove) ? 2 : 1) ?>">Nenhum item cadastrado</td>
		</td>
		<?php else: ?>
			<?php foreach ($this->data as $k => $row): ?>
			<tr<?= $k % 2 == 0 ? ' class="zebra"' : '' ?>>
				<td><input type="checkbox" name="select[]" value="<?= $row->id ?>" class="lista-check" /></td>
				<?php foreach ($data['fields'] as $field): ?>
				<?php if (get_class($row) == 'ContestSubscription' && $field[1] == 'approved'): ?>
				<td <?= isset($field[2]) ? $field[2] : '' ?>><?= Fishy_StringHelper::status_subscription($row->$field[1]); ?></td>
				<?php else: ?>
				<td <?= isset($field[2]) ? $field[2] : '' ?>><?= $row->$field[1] ?></td>
				<?php endif; ?>
				<?php endforeach ?>
				<td>
					<?php if (isset($data['menu_extra'])): ?>
					<?= Fishy_StringHelper::simple_template($data['menu_extra'], array('id' => $row->id)) ?>
					<?php endif ?>

					<?php if (get_class($row) == 'News'): ?>
					<a href="<?= str_replace('/gwm', '', $this->site_url('noticias/' . $row->slug)) ?>" title="Visualizar" target="_blank"><img src="<?= $this->public_url('img/lupa.gif') ?>" alt="Visualizar"/></a>
					<?php endif ?>
					
					<?php if (!$this->btn_no_status): ?>
						<?php if ($row->status): ?>
						<a href="<?= $this->url_to(array("action" => "deactivate", "id" => $row->id)) ?>" title="Desativar"><img src="<?= $this->public_url('img/content/visible.gif') ?>" alt="Ativo"></a>	
						<?php else: ?>
						<a href="<?= $this->url_to(array("action" => "activate", "id" => $row->id)) ?>" title="Ativar"><img src="<?= $this->public_url('img/content/invisible.gif') ?>" alt="Inativo"></a>
						<?php endif ?>
					<?php endif ?>

					<?php if (!$this->btn_no_edit): ?>
					<a href="<?= $this->url_to(array("action" => "edit", "id" => $row->id)) ?>" title="Editar"><img src="<?= $this->public_url('img/content/icon-paper.gif') ?>" alt="Editar"/></a>
					<?php endif ?>
					
					<?php if (!$this->btn_no_remove): ?>
					<a href="javascript:;" onclick="_remove('<?= $row->id ?>')" title="Remover"><img src="<?= $this->public_url('img/content/remove.gif') ?>" alt="Remover" /></a>
					<?php endif ?>						
				</td>
			</tr>
			<?php endforeach ?>
		<?php endif ?>
	</tbody>
</table>

<?php if (!$this->btn_no_remove): ?>
<ul class="select-which">
	<li><strong>Selecionar:</strong></li>
	<li><a href="#" title="Todos" class="all">Todos</a></li>
	<li><a href="#" title="Nenhum" class="none">Nenhum</a></li>
</ul><!-- select-which -->
<label class="take-action">
	<strong>Ações:</strong>
	<select>
		<option>Selecione</option>
		<option>Apagar</option>
	</select>
</label><!-- .take-action -->
<?php endif ?>

<div class="clear"></div>

<div class="pagination">
	<ul>
		<?= $data['links'] ?>
	</ul>
</div><!-- .pagination -->