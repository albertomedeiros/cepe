<div class="concursos">

    <?= $this->render_partial('cultural_contest_header') ?>

    <div class="conteudo">
        <div class="container">
            <div class="anexos result-list">

            <?php if($this->subscription): ?>
                <table>
                    <?php
                    $data1 = strtotime(date("Y-m-d"));
                    $data2 = strtotime('2019-09-20');
                    ?>
                    <?php foreach($this->subscription->logs as $log): ?>
                        <?php if ($log->success == 1 || $log->success == 2): ?>
                        <tr>
                            <td>
                                <?= Fishy_StringHelper::status_subscription_log($log->success); ?>
                            </td>
                            <td>
                                <?= $log->title ?>
                            </td>
                            <td>
                                <?= $log->created_at('d/m/Y') ?>
                            </td>
                        </tr>
                        <?php elseif ($data1 > $data2): ?>
                        <tr>
                            <td>
                                <?= Fishy_StringHelper::status_subscription_log($log->success); ?>
                            </td>
                            <td>
                                <?= $log->title ?>
                            </td>
                            <td>
                                <?= $log->created_at('d/m/Y') ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                    <?php endforeach ?>
                </table>
            <?php else: ?>
                <h1>Lamentamos. Nenhuma inscrição com esse código foi encontrada.</h1>
            <?php endif ?>

            </div>
        </div>

        <?php if($this->subscription): ?>
            <?= $this->render_partial('check_subscription_sidebar') ?>
        <?php else: ?>
            <?= $this->render_partial('sidebar') ?>
        <?php endif ?>

    </div>
    <!-- conteúdo -->
</div>
