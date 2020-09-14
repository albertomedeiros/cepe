<?php

class NavBar
{
	private $page;
	private $maxRows;
	private $totalRows;
	private $totalPages;

	//maxRows - número máximo de objetos por página
	public function __construct($page, $maxRows, $totalRows)
	{
		$this->page = $page;
		$this->maxRows = $maxRows;
		$this->totalRows = $totalRows;

		$this->totalPages = floor($totalRows / $maxRows);
		
		if ($totalRows > $maxRows) {
			$resto = $totalRows % $maxRows;

			if ($resto > 0) {
				$this->totalPages = $this->totalPages + 1;
			}
		} else {
			$this->totalPages = 1;
		}
	}

	public function PageNeighbourhood($nPages)
	{
		//prevNextPages contém quantas páginas a aparece de cada lado da página principal
		//caso vPage seja ímpar, será mostrada a quantidade de páginas igual a vPage incluindo a página atual
		//caso vPage seja par, será mostrada a quantidade de páginas igual a vPage mais uma (página atual)
		//Ex.: page = 10; vPage = 5, serão mostradas as páginas 8, 9, 10, 11, 12
		//Ex.: page = 10; vPage = 4, serão mostradas as páginas 8, 9, 10, 11, 12
		//Ex.: page = 10; vPage = 3, serão mostradas as páginas 9, 10, 11
		$prevNextPages = $nPages / 2;
		$startPage = $this->page - $prevNextPages;
		$endPage = $this->page + $prevNextPages;

		if ($startPage < 1) {
			$endPage = $endPage + (abs($startPage) + 1);
			$startPage = 1;
		}

		if ($endPage > $this->totalPages) {
			while ($startPage > 1 && $endPage > $this->totalPages) {
				$startPage = $startPage - 1;
				$endPage = $endPage - 1;
			}

			$endPage = $this->totalPages;
		}

		$pages = array();

		for ($i = $startPage, $arrayIndex = 0; $i <= $endPage; $i++, $arrayIndex++) {
			$pages[$arrayIndex] = $i;
		}

		return $pages;
	}

	public function NextPage()
	{
		if (($this->page + 1) > $this->totalPages) {
			return -1;
		} else {
			return ($this->page + 1);
		}
	}

	public function PrevPage()
	{
		if (($this->page - 1) < 1) {
			return -1;
		} else {
			return ($this->page - 1);
		}
	}

	public function LastPage()
	{
		return $this->totalPages;
	}
}