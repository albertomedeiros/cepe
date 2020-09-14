<?php

class DevController extends Fishy_Controller
{

  public function initialize()
  {
    if(production_environment()) $this->redirect_to('');
  }

	public function index()
	{
    phpinfo();
  }

	public function server()
	{
    var_dump($_SERVER);
  }

	public function time()
	{
    echo date('d/m/Y H:i:s');
  }
}
