<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Menu;
use frontend\widgets\Alert;
use yii\helpers\Url;

if(count($this->context->adminLoggedInfo)==0 || Yii::$app->session['logged_admin_password']!=md5(md5($this->context->adminLoggedInfo[0]["ps"]).date('d.m.Y'))){
    echo $this->context->redirect(Url::to(['site/login']));
    exit(); die();
}

/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);

$this->context->getNewCount();
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html>
    <head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags(); ?>
        <title><?= Html::encode($this->title); ?></title>
        <?php $this->head(); ?>
    </head>
    <body>
    <?php $this->beginBody(); ?>
    <div class="outer">
        <div class="sidebar">
            <div class="sidey">
                <div class="logo">
                    <h1><a href="" style="font-size: 14px;"><i class="fa fa-desktop br-red"></i> Admin Panel <span>yii2</span></a></h1>
                </div>
                <div class="sidebar-dropdown"><a href="#" class="br-gray"><i class="fa fa-bars"></i></a></div>
                <div style="" class="side-nav">
                    <div class="side-nav-block">
                        <h4><a href="<?=Url::to(['../site/index?cacheUpdate=1']); ?>">Cache update</a></h4>
                        <input type="hidden" value="<?=Yii::$app->homeUrl; ?>" id="baseurl" />
                        <?php
						if($this->context->menuAnnouncesCountEdited==0) $classEdited='hide'; else $classEdited='';
						if($this->context->newFoward==0) $classFw='hide'; else $classFw='';
						if($this->context->newSearchFoward==0) $classSFw='hide'; else $classSFw='';
						if($this->context->newUrgently==0) $classUrg='hide'; else $classUrg='';
						if($this->context->newPremium==0) $classPrm='hide'; else $classPrm='';
						if($this->context->newFbShared==0) $classFb='hide'; else $classFb='';
						echo Menu::widget([
                            'items' => [
                                ['label' => '<i class="fa fa-list gray"></i> Yeni elanlar <span class="badge badge-warning pull-right" style="margin-right: 12px;">'.$this->context->menuAnnouncesCount0.'</span>', 'url' => ['announces/index']],
                                ['label' => '<i class="fa fa-list gray"></i> Aktiv elanlar <span class="badge badge-gray pull-right" style="margin-right: 12px;">'.$this->context->menuAnnouncesCount1.'</span>', 'url' => ['announces/index?status=1']],
                                ['label' => '<i class="fa fa-list gray"></i> Bitmiş elanlar <span class="badge badge-gray pull-right" style="margin-right: 12px;">'.$this->context->menuAnnouncesCount2.'</span>', 'url' => ['announces/index?status=2']],
                                ['label' => '<i class="fa fa-list gray"></i> Təsdiqlənməyənlər <span class="badge badge-gray pull-right" style="margin-right: 12px;">'.$this->context->menuAnnouncesCount3.'</span>', 'url' => ['announces/index?status=3']],
                                ['label' => '<i class="fa fa-list gray"></i> Silinmiş elanlar <span class="badge badge-gray pull-right" style="margin-right: 12px;">'.$this->context->menuAnnouncesCount4.'</span>', 'url' => ['announces/index?status=4']],
                                ['label' => '<i class="fa fa-list gray"></i> Düzəliş olunan elanlar <span class="badge badge-warning pull-right '.$classEdited.'" style="margin-right: 12px;">'.$this->context->menuAnnouncesCountEdited.'</span>', 'url' => ['announces-edited/index']],
//                                ['label' => '<i class="fa fa-list gray"></i> Bütün elanlar <span class="badge badge-warning pull-right" style="margin-right: 12px;"></span>', 'url' => ['announces-search/index?status=9']],
                                ['label' => '<i class="fa fa-list gray"></i> Bütün elanlar <span class="badge badge-warning pull-right" style="margin-right: 12px;">'.$this->context->menuAllAnnouncesCount.'</span>', 'url' => ['announces/index?status=9']],
                                ['label' => '<i class="fa fa-list gray"></i> Arxivdə görsənən elanlar <span class="badge badge-warning pull-right" style="margin-right: 12px;"></span>', 'url' => ['announces-search/index?status=10']],
                                ['label' => '<i class="fa fa-search gray"></i> Elan axtarışı', 'url' => ['announces-search/index']],
								['label' => '<i class="fa fa-fast-forward gray"></i> İrəli çəkilənlər <span class="badge badge-gray pull-right '.$classFw.'" style="margin-right: 12px;">'.$this->context->newFoward.'</span>', 'url' => ['announces/index/?status=5']],
								['label' => '<i class="fa fa-bolt gray"></i> Təcili elanlar <span class="badge badge-gray pull-right '.$classSFw.'" style="margin-right: 12px;">'.$this->context->newUrgently.'</span>', 'url' => ['announces/index/?status=6']],
								['label' => '<i class="fa fa-search gray"></i> Axtarışda irəli çəkilənlər <span class="badge badge-gray pull-right '.$classUrg.'" style="margin-right: 12px;">'.$this->context->newSearchFoward.'</span>', 'url' => ['announces/index/?status=8']],
								['label' => '<i class="fa fa-star gray"></i> Premium elanlar <span class="badge badge-gray pull-right '.$classPrm.'" style="margin-right: 12px;">'.$this->context->newPremium.'</span>', 'url' => ['do-premium/index']],
								['label' => '<i class="fa fa-star gray"></i> FB və İnstagram <span class="badge badge-warning pull-right '.$classFb.'" style="margin-right: 12px;">'.$this->context->newFbShared.'</span>', 'url' => ['do-share/index']],
								['label' => '<i class="fa fa-star gray"></i> Mobil paketləri', 'url' => ['mobile-package/index']],
								
								['label' => '<i class="fa fa-file gray"></i> Seo Manual', 'url' => ['seo-manual-inner/index']],
								['label' => '<i class="fa fa-file gray"></i> Səhifələr', 'url' => ['pages/index']],
                                ['label' => '<i class="fa fa-file gray"></i> Xidmətlər', 'url' => ['services/index']],
                                ['label' => '<i class="fa fa-server gray"></i> Kateqoriyalar', 'url' => ['categories/index']],
                                ['label' => '<i class="fa fa-pencil gray"></i> Yazılar', 'url' => ['posts/index']],
                                ['label' => '<i class="fa fa-dollar gray"></i> Paket qiymətləri', 'url' => ['package-prices/index']],
                                ['label' => '<i class="fa fa-university gray"></i> Yaşayış kompleksləri', 'url' => ['apartments/index']],
                                ['label' => '<i class="fa fa-globe gray"></i> Ölkələr', 'url' => ['countries/index']],
                                ['label' => '<i class="fa fa-university gray"></i> Şəhərlər', 'url' => ['cities/index']],
                                ['label' => '<i class="fa fa-university gray"></i> Rayonlar', 'url' => ['regions/index']],
                                ['label' => '<i class="fa fa-university gray"></i> Qəsəbələr', 'url' => ['settlements/index']],
                                ['label' => '<i class="fa fa-train gray"></i> Metrolar', 'url' => ['metros/index']],
                                ['label' => '<i class="fa fa-table gray"></i> Nişangahlar', 'url' => ['marks/index']],
                                ['label' => '<i class="fa fa-map-marker gray"></i> Əlaqə', 'url' => ['contact/index']],
                                ['label' => '<i class="fa fa-credit-card gray"></i> Bannerlər', 'url' => ['banners/index']],
                                ['label' => '<i class="fa fa-user gray"></i> İstifadəçilər', 'url' => ['users/index']],
                                ['label' => '<i class="fa fa-file gray"></i> Əmlak sifarişləri', 'url' => ['estate-orders/index']],
								['label' => '<i class="fa fa-sign-out gray"></i> Çıxış', 'url' => ['site/logout']],
/*
                                ['label' => '<i class="fa fa-file gray"></i> Haqqımızda', 'url' => ['about/index']],
                                ['label' => '<i class="fa fa-users gray"></i> Müəlliflər', 'url' => ['authors/index']],
                                ['label' => '<i class="fa fa-file-image-o gray"></i> Albomlar', 'url' => ['albums/index']],
                                ['label' => '<i class="fa fa-file-movie-o gray"></i> Videoqalereya', 'url' => ['videogallery/index']],
                                ['label' => '<i class="fa fa-image gray"></i> Slayderlər', 'url' => ['sliders/index']],



                                ['label' => '<i class="fa fa-home gray fa-2x"></i> Ana səhifə', 'url' => ['home/index']],
                                ['label' => '<i class="fa fa-user-md gray"></i> İşçilər', 'url' => ['workers/index']],
                                ['label' => '<i class="fa fa-navicon gray"></i> Menyular', 'url' => ['menus/index']],
                                ['label' => '<i class="fa fa-question gray"></i> FAQ', 'url' => ['faq/index']],
                                ['label' => '<i class="fa fa-envelope-o gray"></i> Məktublar', 'url' => ['messages/index']],
                                ['label' => '<i class="fa fa-question-circle gray"></i> Sorğular', 'url' => ['surveys/index']],
                                ['label' => '<i class="fa fa-comment gray"></i> Şərhlər', 'url' => ['comments/index']],
                                ['label' => '<i class="fa fa-cogs gray"></i> Sayt tənzimləmələr', 'url' => ['home/settings']],
                                ['label' => '<i class="fa fa-user-secret gray"></i> Adminlər', 'url' => ['admins/index']],
                                
*/
                            ],
                            'options' => [
                                'class' => 'list-unstyled'
                            ],
                            'encodeLabels' => false,
                            //'linkTemplate' => '<a href="{url}">{label}</a>',
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="mainbar">
            <div class="main-content">
                <div class="container">
                    <div class="page-content">
                        <?= Alert::widget(); ?>
                        <?= $content; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <div class="popup-overlay"></div>
    <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>