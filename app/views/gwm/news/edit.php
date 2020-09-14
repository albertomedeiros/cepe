<?php $this->title_bar = '<li><a href="' . $this->site_url('news') . '">Notícias</a>/</li><li><span>' . (!$this->object->exists() ? 'Adicionar novo' : 'Editar') . '</span></li>' ?>

<h2><?= !$this->object->exists() ? 'Inserir' : 'Editar' ?> notícia</h2>

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
            <div class="span4" style="margin-bottom:15px;">
               <label for="text_field">Texto <?= Fishy_FormHelper::text_area('text', array(), array('class' => 'tinymce')) ?></label>
           </div>
        </div>

        <div class="row">
            <div class="span2">
               <label for="date_published_f_field">Data de publicação <?= Fishy_FormHelper::text_field('date_published_f') ?></label>
           </div>
        </div>

        <div class="row">
          <div class="span4">
            <label for="image_field">Imagem <?= Fishy_FormHelper::file_field('image') ?></label>
          </div>
        </div>

        <?php if ($this->object->image): ?>
        <div class="row">
          <div class="span4">
            <img src="<?= $this->site_url('../image/view/news/image/' . $this->object->id . '/gwm') ?>"><br>
            <a href="<?= $this->url_to(array('action' => 'remove_image', 'id' => $this->object->id)) ?>" class="block" title="Remover imagem">Remover imagem</a>
          </div>
        </div>
        <?php endif ?>

        <hr class="in-form">
        <h3 class="form-box">Anexos</h3>
        <?php if ($this->object->files): ?>
          <?php foreach ($this->object->files as $k => $file): ?>
            <div class="attachment">
              <div class="row">
                <div class="span4">
                  <a href="<?= $this->public_url('../' . $file->path) ?>" class="block" target="_blank" title="Visualizar anexo">
                    <img src="<?= $this->public_url('img/obj/' . $file->ext_file . '.gif') ?>"><br>Visualizar anexo
                  </a>
                  <br><br>
                  <label>Nome / Título <input type="text" name="data[attachments][title][]" value="<?= $file->title ?>" disabled="disabled"></label>

                  <a href="<?= $this->url_to(array('action' => 'remove_file', 'id' => $this->object->id . '/' . $file->id)) ?>" class="cancel-form" style="width: auto;padding: 0 13px;margin:10px -10px 0;">Remover</a>
                </div>
              </div>
              <hr class="in-form">
            </div>
          <?php endforeach ?>
        <?php endif ?>
        
        <div class="attachment">
          <div class="row">
            <div class="span4">
              <label>Arquivo <input type="file" name="data[attachments][]" value=""></label>
              <label>Nome / Título <input type="text" name="data[attachments_titles][]" value=""></label>
            </div>
          </div>
          <hr class="in-form">
        </div>

        <div class="row">
          <div class="span4">
            <div class="more_attachment"></div>
          </div>
        </div>

        <div class="row">
          <div class="span4">
            <a href="#" title="Adicionar anexo" class="button btn-attachment" style="margin-right:-10px">Adicionar anexo</a>
          </div>
        </div>
        <div class="row">
        <div class="span2">
          <label for="submenus_field">Caretegorias: </label>
          <?= Fishy_FormHelper::checkbox_tree('categories[]', $this->categories, array('selected' => $this->object->individual_categories(),'label'=>'title')) ?>
        </div>
      </div>
    </fieldset>

    <hr class="in-form">

    <a href="javascript: document.forms[0].submit();" class="button">Salvar</a>
    <a href="<?= $this->site_url('news') ?>" class="cancel-form">Cancelar</a>
    <?= Fishy_FormHelper::form_end() ?>
</section>

<script>
  var _get_filename = function(){
    $('input[type=file]').each(function(){
      $(this).on('change', function(){
        $(this).parent().siblings().find('input[type=text]').val($(this).val().split('\\').pop());
      });
    });
  };

  $(function() {  
    _get_filename();

    $('#date_published_f_field').datetimepicker({
      dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
      dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
      dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
      monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
      monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
      currentText: 'Agora',
      closeText: 'Fechar',
      timeText: 'Horário',
      hourText: 'Hora',
      minuteText: 'Minuto',
      dateFormat: "d/m/yy",
      timeFormat: "HH:mm"
    });

    $('a.btn-attachment').click(function() {
      $('div.attachment').last().clone().appendTo($('.more_attachment')).find('input').attr('value', '').attr('name', function(i,oldVal) {
        return oldVal.replace(/\[(\d+)\]/, function(_, m){
          return '[' + (+m + 1) + ']';
        });
      });

      _get_filename();

      return false;
    });
  });
</script>