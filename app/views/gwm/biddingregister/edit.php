<?php $this->title_bar = '<li><a href="' . $this->site_url('bidding') . '">Licitações</a>/</li><li><span>Listagem de Inscritos</span></li>' ?>

<h2>Inscritos da licitação</h2>
<h4><?= $this->data_bidding->title; ?></h4>
<br>
<div style="float:right"><input type="button" value="Download PDF" id="btnImprimir" onclick="CriaPDF()" /></div>
<br>
<div style="clear:both"></div>
<table id="sort-table" class="filtered-list" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th>Nome</th>
			<th>Email</th>
			<th>CPF/CNPJ</th>
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
				<td style="text-align: left;padding-left: 10px"><?= $row->name ?></td>
				<td style="width:250px"><?= $row->email ?></td>
				<td style="width:150px"><?= $row->cpf_cnpj ?></td>
			</tr>
			<?php endforeach ?>
		<?php endif ?>
  	</tbody>
</table>
<script src="https://unpkg.com/jspdf" crossorigin="anonymous"></script>
<script src="https://unpkg.com/jspdf-autotable" crossorigin="anonymous"></script> 
<script>
function CriaPDF() {
	var doc = new jsPDF()
	doc.setFontSize(10);
	doc.text("<?php print $this->data_bidding->title ?>", 15, 25);
	doc.autoTable({
		html: '#sort-table',
		margin: {top: 30}
	});		
	doc.save('<?php print $this->data_bidding->slug; ?>.pdf')
}
</script>