<div class="page-certificado-digital">

  <?= $this->render_partial('breadcrumbs', $this->breadcrumbs, array('controller'=>'main', 'as'=>'crumbs')) ?>

  <div class="titulo-da-pagina parallax" data-parallax-speed="3">
    <h1>Certificado digital</h1>
  </div>
  <!-- título da página -->

  <div class="pcd-submenu">
    <div class="container">
      <a href="#" class="js-page active" data-page=".page-comprar">COMPRAR CERTIFICADO DIGITAL</a>
      <a href="#" class="js-page" data-page=".page-doc">DOCUMENTOS NECESSÁRIOS</a>
    </div>
  </div>

  <div class="conteudo">

    <div class="container">

      <div class="cpd-page page-comprar page-active">

        <h2 class="pcd-title">Comprar certificado digital</h2>

        <form class="pcd-container" action="#" method="post">
          <p class="pcd-text">Antes de agendar, verifique os <a href="#" class="js-page" data-page=".page-doc">documentos necessários</a>.</p>

          <div class="pcd-list">

            <div class="pcd-item item-active">
              <h4 class="pcd-item-title">1. SELECIONE O TIPO</h4>
              <div class="pcd-content">
                <div class="informacoes">
                  <div class="botao-padrao js-botao-padrao fisica">
                    <input type="radio" name="tipo" value="pessoa-fisica">
                    <i></i>Certificado Pessoa Física
                  </div>
                  <div class="botao-padrao js-botao-padrao juridica">
                    <input type="radio" name="tipo" value="pessoa-juridica">
                    <i></i>Certificado Pessoa Jurídica
                  </div>
                </div>
              </div>
            </div>

            <div class="pcd-item">
              <h4 class="pcd-item-title">2. SELECIONE O ARMAZENAMENTO</h4>
              <div class="pcd-content produtos">
                <?php for ($i=1; $i < 4; $i++) : ?>
                  <div class="pcd-produto">
                    <img src="<?= $this->public_url('img/layout/produto.png') ?>" alt="Produto" class="pcd-produto-img">
                    <div class="pcd-conteudo">
                      <h5 class="pcd-produto-title">TOKEN <?= $i; ?></h5>
                      <p class="pcd-produto-text">Certificado de assinatura Tipo A3, gerado e armazenado em token USB incluído no preço.</p>
                      <div class="checkbox js-checkbox">
                        <span class="check"></span>
                        <input type="radio" name="product" value="item-<?= $i; ?>">
                        <p> Selecionar</p>
                      </div>
                    </div>
                  </div>
                <?php endfor; ?>
              </div>
            </div>

            <div class="pcd-item">
              <h4 class="pcd-item-title">3. VALIDADE</h4>
              <div class="pcd-content produtos validade">
                
                <div class="pcd-produto">
                  <h5 class="pcd-produto-title title-large">12 meses</h5>
                  <div>
                    <div class="checkbox js-checkbox js-checkbox-validade">
                      <input type="radio" name="produto" value="item-12-meses">
                      <span class="check"></span>
                      <p> Selecionar</p>
                    </div>
                  </div>
                </div>

                <div class="pcd-produto">
                  <h5 class="pcd-produto-title title-large">24 meses</h5>
                  <div>
                    <div class="checkbox js-checkbox js-checkbox-validade">
                      <input type="radio" name="produto" value="item-12-meses">
                      <span class="check"></span>
                      <p> Selecionar</p>
                    </div>
                  </div>
                </div>

                <div class="pcd-produto">
                  <h5 class="pcd-produto-title title-large">36 meses</h5>
                  <div>
                    <div class="checkbox js-checkbox js-checkbox-validade">
                      <input type="radio" name="produto" value="item-12-meses">
                      <span class="check"></span>
                      <p> Selecionar</p>
                    </div>
                  </div>
                </div>


              </div>
            </div>

            <div class="pcd-item">
              <h4 class="pcd-item-title">4. DESCONTO ESPECIAL</h4>
              <div class="pcd-content desconto">
                <div class="col-left">
                  <p>EI, ME, MEI, EPP, ou EIRELI?</p>
                  <div class="radios">
                    <label class="radio js-next">
                      <input type="radio" name="desconto" value="item-<?= $i; ?>">Sim
                      <span class="checkmark"></span>
                    </label>
                    <label class="radio js-next">
                      <input type="radio" name="desconto" value="item-<?= $i; ?>">Não
                      <span class="checkmark"></span>
                    </label>
                  </div>
                </div>
                <div class="col-right">
                  <p>Marque a opção ao lado se o certificado digital for para:</p>
                  <ul>
                    <li>- Marque a opção acima se o certificado digital for para:</li>
                    <li>- Empresário Individual (EI)</li>
                    <li>- Microempreendedor individual (MEI)</li>
                    <li>- Sócio de uma EIRELI</li>
                  </ul>
                </div>
              </div>
            </div>

            <div class="pcd-item resumo">
              <h4 class="pcd-item-title">5. RESUMO DO PRODUTO ESCOLHIDO</h4>
              <div class="pcd-content">
                <div class="col-left">
                  <p><b>E-CNPJ</b></p>
                  <p>A3 armazenado em cartão + leitora com validade de 1 ano.</p>
                </div>
                <div class="col-right">
                  <p>VALOR TOTAL:</p>
                  <p><b>R$ 220,00</b></p>
                </div>
                <div class="btn-agendar"><i class="icon"></i>Agendar
                  <input type="submit" name="submit" value="Agendar">
                </div>
              </div>
            </div>

          </div>

          <p class="pcd-text">Desconto concedido mediante a apresentação da documentação necessária e comprovação de enquadramento na Receita Federal, por meio de consulta no site no momento da emissão.</p>

        </form>

      </div><!-- page-comprar -->

      <div class="cpd-page page-doc">

        <h2 class="pcd-title">Documentos necessários</h2>

        <div class="cpd-documentos">
          <p>É necessário agendar um horário na Agenda Eletrônica. A emissão do Certificado Digital só poderá ser feita com horário marcado.</p>
          <p>Se houver necessidade de alterar o horário agendado, basta preencher novamente os campos necessários para o agendamento, e o sistema realizará automaticamente a substituição.</p>
          <p>Em caso de não comparecimento na hora marcada, com tolerância de dez minutos de atraso, o horário será automaticamente cancelado pelo sistema. Se houver interesse, um novo agendamento poderá ser efetuado.</p>
          <p><strong>Atenção: Recomendamos chegar com 5 minutos de antecedência do horário agendado. O horário agendado deverá ser rigorosamente observado, não se admitindo atraso superior a 10 minutos.</strong></p>
          <p><strong>IMPORTANTE</strong></p>
          <p>Todos os documentos solicitados devem ser apresentados no ato da emissão do Certificado Digital.</p>
          <p>Para a emissão do certificado digital, é necessário que o nome, a data de nascimento e o estado civil constantes nos documentos apresentados correspondam aos do banco de dados da Receita Federal do Brasil.</p>
          <p>*** Documentos necessários e-CPF:</p>
          <ul>
            <li>Cédula de Identidade (2) (RG, CNH e OAB com chip) ou Passaporte (no caso de estrangeiros)</li>
            <li>Cadastro de Pessoa Física - CPF</li>
            <li>Comprovante de residência recente (emitido há, no máximo, três meses e em nome do solicitante) (3)</li>
            <li>Título de eleitor (opcional) (4)</li>
            <li>PIS-Pasep (opcional) (4)</li>
            <li>CEI - Cadastro Específico do INSS (opcional) (4)</li>
          </ul>
          <p>*** Documentos necessários e-CNPJ:</p>
          <p>Dos representantes legais e representante tributário:</p>
          <ul>
            <li>Cédula de Identidade (2) (RG, CNH e OAB com chip) ou Passaporte (no caso de estrangeiros)</li>
            <li>Cadastro de Pessoa Física - CPF</li>
            <li>Comprovante de residência recente (emitido há, no máximo, três meses e em nome do solicitante) (3)</li>
            <li>Título de eleitor (opcional) (4)</li>
            <li>PIS-Pasep (opcional) (4)</li>
          </ul>
          <p>Da pressoa jurídica:</p>
          <ul>
            <li>Registro comercial (No caso de empresa individual)</li>
            <li>Ato constitutivo, estatuto ou contrato social consolidade ou não</li>
            <li>Todas as alterações contratuais devidamente registrado no órgão competente (sociedades comerciais ou civis)</li>
            <li>Documentos de eleição de seus administradores (sociedades por ações)</li>
            <li>Prova de inscrição do Cadastro Nacional de Pessoas Jurídicas (CNPJ)</li>
          </ul>
          <p>&nbsp;</p>
          <p>(1) Todos os documentos devem ser apresentados na sua forma original.</p>
          <p>(2) Entende-se por cédula de identidade as carteiras instituídas por lei, desde que contenham foto e a elas seja atribuída fé pública em todo o território nacional: Carteira de Identidade emitida pela Secretaria de Segurança Pública, Carteira Nacional de Habilitação, Carteira de Identidade Funcional ou Carteira de Identidade Profissional.</p>
          <p>(3) Entende-se como comprovante de residência ou de domicílio contas de concessionárias de serviços públicos (luz, água, gás, telefonia fixa ou móvel), extratos bancários ou contrato de aluguel onde conste o nome do titular.</p>
          <p>(4) Caso sejam informados os dados dos documentos opcionais no ato do preenchimento da solicitação, o solicitante deverá apresentar à Autoridade de Registro (AR) cópias simples acompanhadas dos originais. Para acesso à Conectividade Social, é necessária a apresentação do PIS/PASEP no momento da emissão do Certificado Digital. Empregadores sem CNPJ (Cadastro Nacional da Pessoa Jurídica) deverão apresentar o CEI (Cadastro Específico do INSS).</p><div class="attachmentsContainer">


          </div>
        </div><!--.page-doc-->

      </div>

    </div>
    <!-- conteúdo -->

  </div>
