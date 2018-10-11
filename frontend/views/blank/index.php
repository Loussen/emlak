<div class="content clearfix haqqimizda">
    <h2 class="main-title classic-margin"><span>Emlak.az</span></h2>
    <main class="main">
        <?php
        if(Yii::$app->session->hasFlash('error')) echo '<div class="alert-danger alert">'.Yii::$app->session->getFlash('error').'</div>';
        if(Yii::$app->session->hasFlash('success')) echo '<div class="alert-success alert">'.Yii::$app->session->getFlash('success').'</div>';
        ?>
    </main>
</div>