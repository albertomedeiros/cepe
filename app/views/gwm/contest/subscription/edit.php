<?php $this->title_bar = '<li><a href="' . $this->site_url('contest/news') . '">Concurso Cultural - Inscrições</a>/</li><li><span>' . (!$this->object->exists() ? 'Adicionar novo' : 'Editar') . '</span></li>' ?>
<h2><?= !$this->object->exists() ? 'Inserir' : 'Visualizar' ?> Inscrição: <?= $this->object->code ?></h2>

<style>
    #main { width: 100%; }
    form { width: 100%; }
    .row {
        display: block;
        width: 100%;
        overflow: hidden;
    }
    div.col1 { width: 21%; float: left }
    div.col1:not(:last-child) { margin-right: 16px; }

    .col3 { width: 74%; float: left }
    .mb-1 { margin-bottom:3%; }
    
    .col2 { width: 46%; float: left }
    .col2:not(:last-child) { margin-right: 16px; }

    div.col4 { width: 97%; float: left }
    .danger-btn {
        padding:0;
        cursor:pointer;
        float:right;
        width:68px;
        height:26px;
        font:12px/26px Arial, Helvetica, sans-serif;
        text-align:center;
        color: white;
        border:1px solid #BBB;
        border-radius:3px;
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#a90329+0,8f0222+44,6d0019+100;Brown+Red+3D */
        background: #a90329; /* Old browsers */
        background: -moz-linear-gradient(top, #a90329 0%, #8f0222 44%, #6d0019 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(top, #a90329 0%,#8f0222 44%,#6d0019 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to bottom, #a90329 0%,#8f0222 44%,#6d0019 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a90329', endColorstr='#6d0019',GradientType=0 ); /* IE6-9 */        margin:10px 10px 0 0;
    }

    .inative-btn {
        padding: 0;
        cursor: pointer;
        float: right;
        width: 68px;
        height: 26px;
        font: 12px/26px Arial, Helvetica, sans-serif;
        text-align: center;
        color: black;
        border: 1px solid #BBB;
        border-radius: 3px;
        background: #a90329;
        background: -moz-linear-gradient(top, #a90329 0%, #8f0222 44%, #6d0019 100%);
        background: -webkit-linear-gradient(top, #a90329 0%,#8f0222 44%,#6d0019 100%);
        background: linear-gradient(to bottom, #9a9a9a 0%,#a9a9a9 44%,#444444 100%);
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#a90329', endColorstr='#6d0019',GradientType=0 );
        margin: 10px 10px 0 0;
    }

    .modal h3  { font-size: 16px; font-weight: bold; }

</style>

<section id="main">
    <?php $this->render_partial('form_errors', $this->object->problems(), array('controller' => 'gwm_main')) ?>
    <?= Fishy_FormHelper::form_for($this->object, array("multipart" => true), array("class" => "form-stacked")) ?>
    <input type="hidden" name="canelada-pra-forcar-post-no-controlador" value="true">

    <fieldset class="col2">

        <div class="row">
            <div class="col4">
                <label for="name_field">Nome <?= Fishy_FormHelper::text_field('name', null, array('disabled'=>'disabled')) ?></label>
            </div>
        </div>

        <div class="row">
            <div class="col4">
                <label for="pseudonym_field">Pseudônimo <?= Fishy_FormHelper::text_field('pseudonym', null, array('disabled'=>'disabled')) ?></label>
            </div>
        </div>

        <div class="row">
            <div class="col4">
                <label for="work_title_field">Título da obra <?= Fishy_FormHelper::text_field('work_title', null, array('disabled'=>'disabled')) ?></label>
            </div>
        </div>

        <div class="row">
            <div class="col2">
                <label for="cpf_field">CPF <?= Fishy_FormHelper::text_field('cpf', null, array('disabled'=>'disabled')) ?></label>
            </div>

            <div class="col2">
                <label for="rg_field">RG <?= Fishy_FormHelper::text_field('rg', null, array('disabled'=>'disabled')) ?></label>
            </div>
        </div>

        <div class="row">
            <div class="col2">
                <label for="civil_status_field">Estado Civil <?= Fishy_FormHelper::text_field('civil_status', null, array('disabled'=>'disabled')) ?></label>
            </div>

            <div class="col2">
                <label for="profession_field">Profissão <?= Fishy_FormHelper::text_field('profession', null, array('disabled'=>'disabled')) ?></label>
            </div>
        </div>

        <div class="row">
            <div class="col2">
                <label for="address_field">Endereço <?= Fishy_FormHelper::text_field('address', null, array('disabled'=>'disabled')) ?></label>
            </div>

            <div class="col2">
                <label for="complement_field">Complemento <?= Fishy_FormHelper::text_field('complement', null, array('disabled'=>'disabled')) ?></label>
            </div>
        </div>

        <div class="row">
            <div class="col1">
                <label for="zipcode_field">CEP <?= Fishy_FormHelper::text_field('zipcode', null, array('disabled'=>'disabled')) ?></label>
            </div>

            <div class="col1">
                <label for="neighborhood_field">Bairro <?= Fishy_FormHelper::text_field('neighborhood', null, array('disabled'=>'disabled')) ?></label>
            </div>

            <div class="col1">
                <label for="city_field">Cidade <?= Fishy_FormHelper::text_field('city', null, array('disabled'=>'disabled')) ?></label>
            </div>

            <div class="col1">
                <label for="state_field">Estado <?= Fishy_FormHelper::select('state', array(
                        'AC'=>'Acre',
                        'AL'=>'Alagoas',
                        'AP'=>'Amapá',
                        'AM'=>'Amazonas',
                        'BA'=>'Bahia',
                        'CE'=>'Ceará',
                        'DF'=>'Distrito Federal',
                        'ES'=>'Espírito Santo',
                        'GO'=>'Goiás',
                        'MA'=>'Maranhão',
                        'MT'=>'Mato Grosso',
                        'MS'=>'Mato Grosso do Sul',
                        'MG'=>'Minas Gerais',
                        'PA'=>'Pará',
                        'PB'=>'Paraíba',
                        'PR'=>'Paraná',
                        'PE'=>'Pernambuco',
                        'PI'=>'Piauí',
                        'RJ'=>'Rio de Janeiro',
                        'RN'=>'Rio Grande do Norte',
                        'RS'=>'Rio Grande do Sul',
                        'RO'=>'Rondônia',
                        'RR'=>'Roraima',
                        'SC'=>'Santa Catarina',
                        'SP'=>'São Paulo',
                        'SE'=>'Sergipe',
                        'TO'=>'Tocantins'
                    ), array(), array('disabled'=>'disabled')) ?></label>
            </div>
        </div>

        <div class="row">
            <div class="col4">
                <label for="nationality_field">Nacionalidade <?= Fishy_FormHelper::select('nationality', array(
                        'brasileiro' => 'Brasileiro',
                        'naturalizado' => 'Naturalizado',
                        'estrangeiro' => 'Estrangeiro',
                    ), array(), array('disabled'=>'disabled')) ?></label>
            </div>
        </div>

        <div class="row">
            <div class="col2">
                <label for="email_field">E-mail <?= Fishy_FormHelper::text_field('email', array(), array('disabled'=>'disabled')) ?></label>
            </div>

            <div class="col2">
                <label for="category_field">Categoria <?= Fishy_FormHelper::select('category', $this->categories, array(), array('disabled'=>'disabled')) ?></label>
            </div>
        </div>

    </fieldset>

    <fieldset class="col2">
        <div class="row">
            <div class="col4">
                <label for="field">
                    <p>RG</p>

                    <input type="text" value="<?= $this->object->rg_file ?>" style="width: calc(100% - 96px); display: inline-block"  disabled>
                    <a href="<?= $this->public_url('../' . $this->object->rg_file) ?>" download title="Download" class="button" style="margin-bottom:10px;">Download</a>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col4">
                <label for="field">
                    <p>Obra</p>

                    <input type="text" value="<?= $this->object->composition_file ?>" style="width: calc(100% - 96px); display: inline-block"  disabled>
                    <a href="<?= $this->public_url('../' . $this->object->composition_file) ?>" download="<?= $this->object->code ?>.<?= $this->object->composition_ext ?>" title="Download" class="button" style="margin-bottom:10px;">Download</a>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col4">
                <label for="field">
                    <p>CPF</p>

                    <input type="text" value="<?= $this->object->cpf_file ?>" style="width: calc(100% - 96px); display: inline-block"  disabled>
                    <a href="<?= $this->public_url('../' . $this->object->cpf_file) ?>" download title="Download" class="button" style="margin-bottom:10px;">Download</a>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col4">
                <label for="field">
                    <p>Termo de Concordância</p>

                    <input type="text" value="<?= $this->object->agreement_file ?>" style="width: calc(100% - 96px); display: inline-block"  disabled>
                    <a href="<?= $this->public_url('../' . $this->object->agreement_file) ?>" download title="Download" class="button" style="margin-bottom:10px;">Download</a>
                </label>
            </div>
        </div>

        <div class="row mb-1">
            <div class="col4">
                <label for="field">
                    <p>Comprovante de Residência</p>

                    <input type="text" value="<?= $this->object->proof_of_address_file ?>" style="width: calc(100% - 96px); display: inline-block"  disabled>
                    <a href="<?= $this->public_url('../' . $this->object->proof_of_address_file) ?>" download title="Download" class="button" style="margin-bottom:10px;">Download</a>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col3 mb-1"><b>Historico</b></div>
            <div class="col1 mb-1"><b>Status</b></div>
            <?php foreach($this->logs as $logs): ?>
            <div class="col3 mb-1"><?php print $logs->title; ?></div>
            <div class="col1 mb-1"><?php print Fishy_StringHelper::status_subscription_log($logs->success); ?></div>
            <?php endforeach; ?>
        </div>
        
    </fieldset>
    <br style="clear: both">

    <?php #if($this->object->approved === null): ?>
        <a href="javascript: document.forms[0].submit();" class="button">Habilitado</a>
        <a class="button inative-btn" href="#unable_modal" rel="modal:open">Inabilitado</a></p>
        <a class="button danger-btn" href="#cancel_modal" rel="modal:open">Cancelado</a></p>
    <?php #endif ?>

    <?= Fishy_FormHelper::form_end() ?>
</section>

<div id="unable_modal" class="modal">
    <form method="POST" action="<?= $this->site_url('contest/subscription/unable') ?>" id="subscription-errors">
        <input type="hidden" name="data[contest_subscription_id]" value="<?= $this->object->id ?>">
        <h3>Inabilitando cadastro.</h3>
        <div style="width: 75%; float: left; margin-right: 18px;">
            <p><input type="text" name="data[title][]" style="width: 100%"></p>
            <p><input type="text" name="data[title][]" style="width: 100%"></p>
            <p><input type="text" name="data[title][]" style="width: 100%"></p>
            <p><input type="text" name="data[title][]" style="width: 100%"></p>
        </div>
        <br style="clear: both" />
        <button type="submit" class="button">Salvar</button>
        <a href="#" rel="modal:close" class="cancel-form">Cancelar</a>
    </form>
</div>

<div id="cancel_modal" class="modal">
    <form method="POST" action="<?= $this->site_url('contest/subscription/cancel') ?>" id="subscription-errors">
        <input type="hidden" name="data[contest_subscription_id]" value="<?= $this->object->id ?>">
        <h3>Cancelando cadastro.</h3>
        <div style="width: 75%; float: left; margin-right: 18px;">
            <p><input type="text" name="data[title][]" style="width: 100%"></p>
            <p><input type="text" name="data[title][]" style="width: 100%"></p>
            <p><input type="text" name="data[title][]" style="width: 100%"></p>
            <p><input type="text" name="data[title][]" style="width: 100%"></p>
        </div>
        <!--
        <div style="width: 20%; float: left">
            <a href="#" id="add-reason-input" class="button">Adicionar</a>
        </div> -->

        <br style="clear: both" />
        <button type="submit" class="button">Salvar</button>
        <a href="#" rel="modal:close" class="cancel-form">Cancelar</a>
    </form>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />

<script>
    $(document).ready(function(){
        $('#date_f_field').datepicker({
            dayNames: ['Domingo','Segunda','TerÃ§a','Quarta','Quinta','Sexta','SÃ¡bado'],
            dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
            dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','SÃ¡b','Dom'],
            monthNames: ['Janeiro','Fevereiro','MarÃ§o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
            monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
            currentText: 'Agora',
            closeText: 'Fechar',
            timeText: 'HorÃ¡rio',
            hourText: 'Hora',
            minuteText: 'Minuto',
            dateFormat: "d/m/yy",
            timeFormat: "HH:mm"
        });
    });
</script>