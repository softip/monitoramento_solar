<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-12">
            <?php
            if (isset($falhas) && !empty($falhas)) {
                foreach($falhas as $f){
            
            ?>
            <div class="callout callout-danger">
                <h4>Falha no sistema:  <?= $f->categoria ?></h4>
                <?= $f->mensagem ?>
            </div>
            
            <?php } }else{
            ?>
            <div class="callout callout-success">
                <h4>Funcionamento normal</h4>
                O sistema não apresenta falhas no momento.
            </div>
            <?php }?>
        </div>
    </div>
</section>

