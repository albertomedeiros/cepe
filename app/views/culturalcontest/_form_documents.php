
<div id="form-step2" class="form-steps files" style="display:none;">
    <div id="form-errors" style="padding:15px;background-color:#ffeeba;color:#856404;width: 100%;">
        <strong>Atenção!</strong> Cadastros anteriores com o mesmo <b>CPF</b> serão cancelados automaticamente para uma inscrição do mesmo tipo.
    </div>
    <div style="clear:both"></div>
    <div class="form-field file">
        <p>RG</p>
        <input type="file" name="subscription[rg_file]" id="rg_file" class="inputfile inputfile-box" required />
        <label for="rg_file"><span></span><strong>Escolher arquivo</strong></label>
        <p class="msg-file">Apenas arquivo em pdf</p>
    </div>

    <div class="form-field file">
        <p>CPF</p>
        <input type="file" name="subscription[cpf_file]" id="cpf_file" class="inputfile inputfile-box" />
        <label for="cpf_file"><span></span><strong>Escolher arquivo</strong></label>
        <p class="msg-file">Apenas arquivo em pdf</p>
    </div>

    <div class="form-field file">
        <p>Comprovante de residência</p>
        <input type="file" name="subscription[proof_of_address_file]" id="proof_of_address_file" class="inputfile inputfile-box" />
        <label for="proof_of_address_file"><span></span><strong>Escolher arquivo</strong></label>
        <p class="msg-file">Apenas arquivo em pdf</p>
    </div>

    <div class="form-field file">
        <p>Obra</p>
        <input type="file" name="subscription[composition_file]" id="composition_file" class="inputfile inputfile-box" required />
        <label for="composition_file"><span></span><strong>Escolher arquivo</strong></label>
        <p class="msg-file">Apenas arquivo em pdf</p>
    </div>

    <div class="form-field file buttons">
        <button type="button" id="step_prev" class="btn">Voltar</button>
        <button type="submit" class="btn">Enviar</button>
    </div>

    <?php if($_SESSION['premio_cepe']['menor']): ?>
        <div class="obs">
            <p>Obs.: Anexar cópia de RG e CPF de responsável.</p>
        </div>
    <?php endif; ?>

</div>