<div class="concursos">

    <?= $this->render_partial('cultural_contest_header') ?>

    <style>
        button[disabled] {
            cursor: default !important;
            background: gray !important;
        }

    </style>

    <div class="conteudo">
        <div class="container">
            <?= $this->render_partial('page_title', array('title' => $this->title)) ?>

            <form class="alert-msg" method="post" action="<?= $this->site_url('premio-cepe/inscricao/5/'.$this->genre) ?>">
                <h1>DECLARAÇÃO DE PARTICIPAÇÃO</h1>
    
                <p>No ato de inscrição, o(a) candidato(a) declara que:<br><br>

                    a) Está de acordo com o Termo de Concordância de Exclusividade de Edição, concedendo direitos de publicação à Companhia Editora de Pernambuco — Cepe pelo prazo de 5 (cinco) anos, a contar da assinatura do contrato;<br>
                    b) Está ciente das penas da lei e da própria desclassificação do Prêmio no caso de inveracidade das informações prestadas;<br>
                    c) Está regular perante a Receita Federal e Dívida Ativa da União, a Seguridade Social, a Fazenda Pública Estadual e em dia com as obrigações relativas ao FGTS.<br><br>

                    Declaro como verdadeiras as afirmações acima e aceito os termos.
                </p>
    
                <div class="footer-alert">
                    <label>
                        <input type="checkbox" name="terms_agreed" value="1">Eu aceito os termos deste edital
                    </label>
    
                    <button class="btn" disabled>Próximo</button>
                </div>
            </form>

        </div>

    </div>
    <!-- conteúdo -->
</div>
