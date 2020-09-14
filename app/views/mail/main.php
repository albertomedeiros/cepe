<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cepe</title>
</head>
<body>
  <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" bgcolor="#FFFFFF">
    <tr height="40" style="font-size:0; line-height:0"><td>&nbsp;</td></tr>
    <tr>
      <td align="center" valign="top">
        <table width="600" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
          <tr height="110">
            <td width="15"></td>
            <td width="500">
              <img src="<?= $this->public_url('img/layout/logo.png') ?>" style="display: block;">
            </td>
            <td>
              <a href="#"><img src="<?= $this->public_url('img/layout/email-face.png') ?>" style="display: block;"></a>
            </td>
            <td>
              <a href="#"><img src="<?= $this->public_url('img/layout/email-twitter.png') ?>" style="display: block;"></a>
            </td>
            <td width="15"></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top">
        <table width="560" border="0" cellpadding="0" cellspacing="0" bgcolor="#d22323">
          <tr height="6"><td></td></tr>
        </table>
      </td>
    </tr>
    <tr>
      <td align="center" valign="top">
        <table width="560" border="0" cellpadding="0" cellspacing="0">
          <tr height="40"><td></td></tr>
          <tr>
            <td>
              <h1 style="font-family:Arial, sans-serif;font-size: 32px;font-weight: 400;margin: 0;color: #d22323;">Seu cadastro foi criado com sucesso!</h1>
            </td>
          </tr>
          <tr height="20"><td></td></tr>
          <tr>
            <td>
              <p style="font-family:Arial, sans-serif;font-size: 16px;font-weight: 400;letter-spacing: .5px; margin: 0;color:#000;">Clique no botão abaixo para ativar seu cadastro. </p>
            </td>
          </tr>
          <tr height="40"><td></td></tr>
          <tr>
            <td align="center" valign="top">
              <table border="0" cellpadding="0" cellspacing="0" bgcolor="#d22323">
                <tr height="15"><td></td></tr>
                <tr>
                  <td width="30"></td>
                  <td align="center" valign="center">
                    <a href="<?=$this->site_url("licitacoes/ativar/" . $this->md5_registro)?>" style="font-family:Arial, sans-serif;font-size: 22px;font-weight: 400;color: #FFFFFF;">Ativar!</a>
                  </td>
                  <td width="30"></td>
                </tr>
                <tr height="15"><td></td></tr>
              </table>
            </td>
          </tr>
          <tr height="50"><td></td></tr>
          <tr height="2" bgcolor="#dedede"><td></td></tr>
        </table>
      </td>
    </tr>
    <tr height="40" style="font-size:0; line-height:0"><td>&nbsp;</td></tr>
  </table>
</body>
</html>
