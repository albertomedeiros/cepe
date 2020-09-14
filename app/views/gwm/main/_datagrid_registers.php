<h2><?= strip_tags($this->title_bar) ?></h2>
<form method="post" action="<?= $this->site_url('biddingregister/all') ?>">
	<input type="text" value="" name="request" id="request" style="float:left"><input type="submit" value="Buscar" class="button" style="float:left">
</form>
<div style="clear:both"></div>
<table id="sort-table" class="filtered-list" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th>Título</th>
			<th>Status</th>
			<th>Data</th>
			<th>Funções</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($this->data) == 0): ?>
		<tr>
			<td colspan="4">Nenhum item cadastrado</td>
		</td>
		<?php else: ?>
			<?php foreach ($this->data as $k => $row): ?>
			<tr<?= $k % 2 == 0 ? ' class="zebra"' : '' ?>>
				<td style="text-align: left;padding-left: 10px"><?= $row->title ?></td>
				<td style="width:100px"><?= $row->status_text ?></td>
				<td style="width:100px"><?= $row->date_published_f ?></td>
				<td><a href="<?= $this->url_to(array("action" => "edit", "id" => $row->id)) ?>" title="Visualizar"><img src="<?= $this->public_url('img/content/visible.gif') ?>" alt="Ativo"></a></td>
			</tr>
			<?php endforeach ?>
		<?php endif ?>
  	</tbody>
</table>