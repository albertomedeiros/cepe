<?php

class Gwm_RegisterController extends Gwm_CrudController
{

  public function all($query=array())
  {
    parent::all($query);
  }

  public function download()
  {
    $this->_render = false;

    $arr_register = ActiveRecord::model('Register')->all(array('order' => 'email asc'));

    $csv = array('E-mail');
    foreach ($arr_register as $register) {
      $csv[] = utf8_decode(strtolower($register->email));
    }

    $csv = implode("\n", $csv);

    Fishy_DownloadHelper::force_download("register.csv", $csv);
  }

}
