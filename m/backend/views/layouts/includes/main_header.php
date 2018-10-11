<div class="main-head">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
                <!-- Page title -->
                <h2><i class="fa fa-desktop lblue"></i> Dashboard</h2>
            </div>

            <div class="col-md-3 hidden-sm hidden-xs">
                <!-- Head user -->
                <div class="head-user dropdown pull-right">
                    <a href="#" data-toggle="dropdown" id="profile">
                        <!-- Icon
                        <i class="fa fa-user"></i>  -->

                        <img src="<?= Yii::$app->request->baseUrl; ?>/../backend/web/img/user2.png" alt="" class="img-responsive img-circle">

                        <!-- User name -->
                        ashokram <span class="label label-danger">5</span>
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <!-- Dropdown -->
                    <ul class="dropdown-menu" aria-labelledby="profile">
                        <li><a href="#">View/Edit Profile <span class="badge badge-info pull-right">6</span></a></li>
                        <li><a href="#">Change Settings</a></li>
                        <li><a href="#">Messages <span class="badge badge-danger pull-right">5</span></a></li>
                        <li><a href="#">Sign Out</a></li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

</div>