<?php $this->title_bar = '<li><a href="' . $this->site_url('contest/news') . '">Concurso Cultural - Notícias</a>/</li><li><span>' . (!$this->object->exists() ? 'Adicionar novo' : 'Editar') . '</span></li>' ?>
<h2><?= !$this->object->exists() ? 'Inserir' : 'Editar' ?> Notícia</h2>

<section id="main">
    <?php $this->render_partial('form_errors', $this->object->problems(), array('controller' => 'gwm_main')) ?>
    <?= Fishy_FormHelper::form_for($this->object, array("multipart" => true), array("class" => "form-stacked")) ?>

    <fieldset>

        <div class="row">
            <div class="span4">
                <label for="title_field">Título <?= Fishy_FormHelper::text_field('title') ?></label>
            </div>
        </div>

        <div class="row">
            <div class="span2">
                <label for="date_f_field">Data <?= Fishy_FormHelper::text_field('date_f') ?></label>
            </div>
        </div>

    </fieldset>

    <a href="javascript: document.forms[0].submit();" class="button">Salvar</a>
    <a href="<?= $this->site_url('news') ?>" class="cancel-form">Cancelar</a>
    <?= Fishy_FormHelper::form_end() ?>
</section>

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