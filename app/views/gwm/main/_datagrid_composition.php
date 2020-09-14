<h2><?= strip_tags($this->title_bar) ?></h2>
<?php 
$url_filter = $this->url_to(array("action" => "approved")).'/';

$url_filter_habilitado = $url_filter.'?call=approved&status=1';
$url_filter_cancelado = $url_filter.'?call=approved&status=2';
$url_filter_inabilitado = $url_filter.'?call=approved&status=0';
$url_filter_pendente = $url_filter.'?call=approved&status=null';

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
<table id="sort-table" class="filtered-list" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<!-- <th><input type="checkbox" id="selectAll" name="selectAll" value="" /></th> -->
			<th>Nº Inscrição</th>
			<th>Nome</th>
			<th>Pseudônimo</th>
			<th>RG</th>
			<th>Estado</th>
			<th>Obra</th>
			<th>Categoria</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($this->data) == 0): ?>
		<tr>
			<td colspan="9">Nenhum item cadastrado</td>
		</td>
		<?php else: ?>
			<?php foreach ($this->data as $k => $row): ?>
			<tr<?= $k % 2 == 0 ? ' class="zebra"' : '' ?>>
				<!-- <td><input type="checkbox" name="select[]" value="<?= $row->id ?>" class="lista-check" /></td> -->
				<td><?= $row->code ?></td>
				<td><?= $row->name ?></td>
				<td><?= $row->pseudonym ?></td>
				<td><?= $row->rg ?></td>
				<td><?= $row->state ?></td>
				<td><a href="<?= $this->public_url('../' . $row->composition_file) ?>" style="color:blue"><b><?= $row->work_title ?></b></a></td>
				<td><?= $row->category ?></td>
				<td><?= Fishy_StringHelper::status_subscription($row->approved) ?></td>
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
<?php
$qtd = ceil($this->total / $this->pagination_quantity_per_page);
$url = $this->url_to(array("action" => "all")).'/';
for ($x = 1;$x <= $qtd;$x++) {
	$data['links'] = str_replace($url.$x, $url.$x.'?call=approved', $data['links']);
}
?>
<div class="clear"></div>
<div class="pagination">
	<ul>
		<?= $data['links'] ?>
	</ul>
</div><!-- .pagination -->