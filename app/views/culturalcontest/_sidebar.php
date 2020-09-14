<div class="follow-registration">
    <form method="POST" action="<?= $this->site_url('premio-cepe/acompanhar-inscricao') ?>" class="form check-subscription">
        <label for="subscription_id">Acompanhe sua inscrição</label>

        <div class="form-field">
            <input type="text" name="subscription_id" class="form-text" />
        </div>

        <button type="submit"></button>     
    </form>

    <small>*Para consultar digite o número recebido no ato da inscrição</small>

    <p>Notícias</p>
    
    <table>
        <?php foreach($this->news as $news): ?>
            <tr>
                <td><?= $news->title ?></td>
                <td><?= $news->date('d/m/Y') ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
