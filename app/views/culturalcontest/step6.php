<div class="concursos">

    <?= $this->render_partial('cultural_contest_header') ?>

    <div class="conteudo">
        <div class="container">
            <?= $this->render_partial('page_title', array('title' => $this->title)) ?>

            <section class="alert-msg success-form">
                <h1>Parabéns</h1>

                <p>
                    A sua inscrição foi realizada com sucesso!<br>
                    Guarde o seu número de inscrição para consultas 
                    no site do prêmio.
                </p>

                <b>*NÚMERO DE INSCRIÇÃO <?= $this->subscription->code ?> <i class="fas fa-check-circle"></i></b>

                <br><br><p><a href="javascript:CriaPDF()" class="btn link-inscricao">Imprimir</a></p>
            </section>

        </div>

    </div>
    <!-- conteúdo -->
</div>
<table id="insc-table" style="display:none">
    <thead>
        <tr>
            <th colspan="4">Dados cadastrados</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><strong>Nome:</strong></td>
            <td><?= $this->subscription->name ?></td>
            <th><b>Inscrição:</b></th>
            <td><?= $this->subscription->code ?></td>
        </tr>
        <tr>
            <th><b>Pseudônimo:</b></th>
            <td><?= $this->subscription->pseudonym ?></td>
            <th><b>Título da obra:</b></th>
            <td><?= $this->subscription->work_title ?></td>
        </tr>
        <tr>
            <th><b>Cpf:</b></th>
            <td><?= $this->subscription->cpf ?></td>
            <th><b>Rg:</b></th>
            <td><?= $this->subscription->rg ?></td>
        </tr>
        <tr>
            <th><b>Estado Civil:</b></th>
            <td><?= $this->subscription->civil_status ?></td>
            <th><b>Profissão:</b></th>
            <td><?= $this->subscription->profession ?></td>
        </tr>
        <tr>
            <th><b>Endereço:</b></th>
            <td><?= $this->subscription->address ?></td>
            <th><b>Complemento:</b></th>
            <td><?= $this->subscription->complement ?></td>
        </tr>
        <tr>
            <th><b>Cep:</b></th>
            <td><?= $this->subscription->cep ?></td>
            <th><b>Bairro:</b></th>
            <td><?= $this->subscription->neighborhood ?></td>
        </tr>
        <tr>
            <th><b>Cidade:</b></th>
            <td><?= $this->subscription->city ?></td>
            <th><b>Estado:</b></th>
            <td><?= $this->subscription->state ?></td>
        </tr>
        <tr>
            <th><b>País:</b></th>
            <td><?= $this->subscription->country ?></td>
            <th><b>Nacionalidade:</b></th>
            <td><?= $this->subscription->nationality ?></td>
        </tr>
        <tr>
            <th><b>Categoria:</b></th>
            <td><?= $this->subscription->category ?></td>
            <th></th>
            <td></td>
        </tr>
    </tbody>
</table>

<script src="https://unpkg.com/jspdf" crossorigin="anonymous"></script>
<script src="https://unpkg.com/jspdf-autotable" crossorigin="anonymous"></script> 
<script>
function CriaPDF() {
    var doc = new jsPDF()
    doc.setFontSize(20);
    doc.text("INSCRIÇÃO - Prêmio CEPE Nacional de Literatura", 15, 25);
    doc.autoTable({
        html: '#insc-table',
        margin: {top: 30}
    });     
    doc.save('inscricao.pdf')
}
</script>