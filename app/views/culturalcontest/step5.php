<div class="concursos">

    <?= $this->render_partial('cultural_contest_header') ?>

    <div class="conteudo">
        <div class="container" style="float: left">
            <?= $this->render_partial('page_title', array('title' => $this->title)) ?>

            <form action="" id="form-cadastro-cultural" class="form cultural-contest" method="post" enctype="multipart/form-data">
                <?php if($this->problems): ?>
                    <div id="form-errors">
                        <p><strong>Atenção!</strong> Preencha corretamente os campos marcados.</p>
                        <ul>
                            <?php foreach ($this->problems as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                        </ul>

                    </div>
                <?php endif; ?>

                <input type="hidden" name="terms_agreed" value="true">
                <input type="hidden" name="subscription[genre]" value="<?= $this->genre ?>">

                <div id="form-step1" class="form-steps">
                    <div class="col-form">

                        <div class="form-col-1">
                            <label class="form-field">
                                <span class="form-label">E-mail:</span>
                                <input type="text" name="subscription[email]" class="form-text" value="<?= $this->subscription->email ?>" maxlength="64">
                            </label>
                        </div>

                        <div class="form-col-1">
                            <label class="form-field">
                                <span class="form-label">Nome:</span>
                                <input type="text" name="subscription[name]" class="form-text" value="<?= $this->subscription->name ?>" maxlength="255">
                            </label>

                            <label class="form-field">
                                <span class="form-label">Pseudônimo:</span>
                                <input type="text" name="subscription[pseudonym]" class="form-text" value="<?= $this->subscription->pseudonym ?>" maxlength="255">
                            </label>

                            <label class="form-field">
                                <span class="form-label">Título da obra:</span>
                                <input type="text" name="subscription[work_title]" class="form-text" value="<?= $this->subscription->work_title ?>" maxlength="255">
                            </label>
                        </div>

                        <div class="form-col-2">
                            <label class="form-field">
                                <span class="form-label">CPF:</span>
                                <input type="text" name="subscription[cpf]" class="form-text" value="<?= $this->subscription->cpf ?>" maxlength="14">
                            </label>

                            <label class="form-field">
                                <span class="form-label">RG:</span>
                                <input type="text" name="subscription[rg]" class="form-text" value="<?= $this->subscription->rg ?>" maxlength="32">
                            </label>
                        </div>

                        <div class="form-col-2">
                            <label class="form-field">
                                <span class="form-label">Estado Civil:</span>
                                <input type="text" name="subscription[civil_status]" class="form-text" value="<?= $this->subscription->civil_status ?>" maxlength="16">
                            </label>

                            <label class="form-field">
                                <span class="form-label">Profissão:</span>
                                <input type="text" name="subscription[profession]" class="form-text" value="<?= $this->subscription->profession ?>" maxlength="64">
                            </label>
                        </div>
                    </div>

                    <div class="col-form">
                        <div class="form-col-1">
                            <label class="form-field">
                                <span class="form-label">Endereço:</span>
                                <input type="text" name="subscription[address]" class="form-text" value="<?= $this->subscription->address ?>" maxlength="64">
                            </label>
                        </div>
                        <div class="form-col-2">
                            <label class="form-field">
                                <span class="form-label">Complemento:</span>
                                <input type="text" name="subscription[complement]" class="form-text" value="<?= $this->subscription->complement ?>" maxlength="64">
                            </label>
                            <label class="form-field">
                                <span class="form-label">CEP:</span>
                                <input type="text" name="subscription[zipcode]" class="form-text" value="<?= $this->subscription->zipcode ?>" maxlength="20">
                            </label>
                        </div>

                        <div class="form-col-2">
                            <label class="form-field">
                                <span class="form-label">Bairro:</span>
                                <input type="text" name="subscription[neighborhood]" class="form-text" value="<?= $this->subscription->neighborhood ?>" maxlength="64">
                            </label>
                            <label class="form-field">
                                <span class="form-label">Cidade:</span>
                                <input type="text" name="subscription[city]" class="form-text" value="<?= $this->subscription->city ?>" maxlength="64">
                            </label>
                        </div>

                        <div class="form-col-2">
                            <label class="form-field form-field-select">
                                <span class="form-label">Estado:</span>
                                <span class="form-text"></span>
                                <select id="estado" name="subscription[state]">
                                    <option value=""></option>
                                    <option value="AC"  <?= $this->subscription->state === 'AC' ? 'selected' : '' ?> >Acre</option>
                                    <option value="AL"  <?= $this->subscription->state === 'AL' ? 'selected' : '' ?> >Alagoas</option>
                                    <option value="AP"  <?= $this->subscription->state === 'AP' ? 'selected' : '' ?> >Amapá</option>
                                    <option value="AM"  <?= $this->subscription->state === 'AM' ? 'selected' : '' ?> >Amazonas</option>
                                    <option value="BA"  <?= $this->subscription->state === 'BA' ? 'selected' : '' ?> >Bahia</option>
                                    <option value="CE"  <?= $this->subscription->state === 'CE' ? 'selected' : '' ?> >Ceará</option>
                                    <option value="DF"  <?= $this->subscription->state === 'DF' ? 'selected' : '' ?> >Distrito Federal</option>
                                    <option value="ES"  <?= $this->subscription->state === 'ES' ? 'selected' : '' ?> >Espírito Santo</option>
                                    <option value="GO"  <?= $this->subscription->state === 'GO' ? 'selected' : '' ?> >Goiás</option>
                                    <option value="MA"  <?= $this->subscription->state === 'MA' ? 'selected' : '' ?> >Maranhão</option>
                                    <option value="MT"  <?= $this->subscription->state === 'MT' ? 'selected' : '' ?> >Mato Grosso</option>
                                    <option value="MS"  <?= $this->subscription->state === 'MS' ? 'selected' : '' ?> >Mato Grosso do Sul</option>
                                    <option value="MG"  <?= $this->subscription->state === 'MG' ? 'selected' : '' ?> >Minas Gerais</option>
                                    <option value="PA"  <?= $this->subscription->state === 'PA' ? 'selected' : '' ?> >Pará</option>
                                    <option value="PB"  <?= $this->subscription->state === 'PB' ? 'selected' : '' ?> >Paraíba</option>
                                    <option value="PR"  <?= $this->subscription->state === 'PR' ? 'selected' : '' ?> >Paraná</option>
                                    <option value="PE"  <?= $this->subscription->state === 'PE' ? 'selected' : '' ?> >Pernambuco</option>
                                    <option value="PI"  <?= $this->subscription->state === 'PI' ? 'selected' : '' ?> >Piauí</option>
                                    <option value="RJ"  <?= $this->subscription->state === 'RJ' ? 'selected' : '' ?> >Rio de Janeiro</option>
                                    <option value="RN"  <?= $this->subscription->state === 'RN' ? 'selected' : '' ?> >Rio Grande do Norte</option>
                                    <option value="RS"  <?= $this->subscription->state === 'RS' ? 'selected' : '' ?> >Rio Grande do Sul</option>
                                    <option value="RO"  <?= $this->subscription->state === 'RO' ? 'selected' : '' ?> >Rondônia</option>
                                    <option value="RR"  <?= $this->subscription->state === 'RR' ? 'selected' : '' ?> >Roraima</option>
                                    <option value="SC"  <?= $this->subscription->state === 'SC' ? 'selected' : '' ?> >Santa Catarina</option>
                                    <option value="SP"  <?= $this->subscription->state === 'SP' ? 'selected' : '' ?> >São Paulo</option>
                                    <option value="SE"  <?= $this->subscription->state === 'SE' ? 'selected' : '' ?> >Sergipe</option>
                                    <option value="TO"  <?= $this->subscription->state === 'TO' ? 'selected' : '' ?> >Tocantins</option>
                                    <option value="ES"  <?= $this->subscription->state === 'ES' ? 'selected' : '' ?> >Estrangeiro</option>
                                </select>

                            </label>
                        </div>

                        <div class="form-col-2">
                            <label class="form-field">
                                <span class="form-label">País:</span>
                                <input type="text" name="subscription[country]" class="form-text" value="<?= $this->subscription->country ?>" maxlength="64">
                            </label>
                        </div>

                        <div class="form-col-2">
                            <label class="form-field form-field-select">
                                <span class="form-label">Nacionalidade:</span>
                                <span class="form-text"></span>
                                <select id="nacionalidade" name="subscription[nationality]">
                                    <option value=""></option>
                                    <option value="brasileiro"   <?= $this->subscription->nationality === 'brasileiro' ? 'selected' : '' ?> >Brasileiro</option>
                                    <option value="naturalizado" <?= $this->subscription->nationality === 'naturalizado' ? 'selected' : '' ?> >Naturalizado</option>
                                    <option value="estrangeiro"  <?= $this->subscription->nationality === 'estrangeiro' ? 'selected' : '' ?> >Estrangeiro</option>
                                </select>
                            </label>
                        </div>

                        <div class="form-col-1">
                            <p class="text">Categoria:</p>

                            <?php foreach($this->categories as $slug => $label): ?>
                                <label class="form-field radio">
                                    <input type="radio" name="subscription[category]" value="<?= $slug ?>"  <?= $this->subscription->category === $slug ? 'checked' : '' ?>><?= $label ?>
                                </label>
                            <?php endforeach ?>

                            <button type="button" id="step_next" class="btn next_step">Pŕoximo</button>
                        </div>
                    </div>
                </div>

                <?= $this->render_partial('form_documents') ?>
            </form>
            <br style="clear: both">
        </div>

    </div>
    <!-- conteúdo -->
</div>