<h2><?= strip_tags($this->title_bar) ?></h2>
<?php 
$url_filter = $this->url_to(array("action" => "cpl")).'/';

$url_filter_infantojuvenil = $url_filter.'?call=cpl&genre=infantojuvenil';
$url_filter_nacional = $url_filter.'?call=cpl&genre=nacional';

?>
<h4>Filtros</h4>
<div style="float:left">
<ul class="filter">
	<li><a href="<?= $url_filter ?>">Todos</a></li>
	<li><a href="<?= $url_filter_infantojuvenil ?>">Infantojuvenil</a></li>
	<li><a href="<?= $url_filter_nacional ?>">Nacional</a></li>
</ul>
</div>
<div style="float:right"><input type="button" value="Criar PDF" id="btnImprimir" onclick="CriaPDF()" /></div>
<div style="clear:both"></div>
<table id="sort-table" class="filtered-list" cellpadding="0" cellspacing="0">
	<thead>
		<tr>
			<th>Cod.</th>
			<th>Nome</th>
			<th>RG</th>
			<th>Estado</th>
			<th>Categoria</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
		<?php if (count($this->data) == 0): ?>
		<tr>
			<td colspan="5">Nenhum item cadastrado</td>
		</td>
		<?php else: ?>
			<?php foreach ($this->data as $k => $row): ?>
			<tr<?= $k % 2 == 0 ? ' class="zebra"' : '' ?>>
				<td><?= $row->code ?></td>
				<td><?= $row->name ?></td>
				<td><?= $row->rg ?></td>
				<td><?= $row->state ?></td>
				<td><?= $row->category ?></td>
				<td><?= Fishy_StringHelper::status_subscription($row->approved) ?></td>
			</tr>
			<?php endforeach ?>
		<?php endif ?>
	<!-- </tbody>
	<tfoot> -->
	    <tr>
	      	<td colspan="5" style="text-align: right;padding-right:10px"><b>Total de Inscrições</b></td>
	      	<td><b><?php print $this->total; ?></b></td>
	    </tr>
  	<!-- </tfoot> -->
  	</tbody>
</table>

<?php
$qtd = ceil($this->total / $this->pagination_quantity_per_page);
$url = $this->url_to(array("action" => "all")).'/';
for ($x = 1;$x <= $qtd;$x++) {
	$data['links'] = str_replace($url.$x, $url.$x.'?call=cpl', $data['links']);
}
?>
<div class="clear"></div>
<div class="pagination">
	<ul>
		<?= $data['links'] ?>
	</ul>
</div><!-- .pagination -->
<script src="https://unpkg.com/jspdf" crossorigin="anonymous"></script>
<script src="https://unpkg.com/jspdf-autotable" crossorigin="anonymous"></script> 
<script>
function CriaPDF() {
	var doc = new jsPDF()
	doc.setFontSize(30);
	doc.text("<?php if ($this->param('genre') !="") { print ucfirst($this->param('genre')); } else { print 'Todos os cadastros'; } ?>", 15, 25);
	doc.autoTable({
		html: '#sort-table',
		margin: {top: 30}
	});		
	doc.save('cpl-<?php print date('d-m-Y')."-".$this->param('genre'); ?>.pdf')
}
</script>