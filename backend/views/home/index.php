<div class="page-content">
    <div class="single-head">
        <h3 class="pull-left"><i class="fa fa-bars green"></i> Xidmətlər</h3>
        <!-- Bread crumbs -->
        <div class="breads pull-right">
            <div id="breadCrumb">
                <a href="/ibar/ru/admin/main/index">MintAdmin</a> / Xidmətlər
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!-- Content -->
    <div class="page-tabs">
        <ul class="nav nav-tabs">
            <li><a href="/ibar/ru/admin/services/create" class="br-green"><i class="fa fa-plus red"></i> Yeni əlavə et</a></li>
        </ul>
    </div>
    <hr>
    <form method="post" action="/ibar/ru/admin/services/deleteMore">
        <div class="table-responsive" id="services">
            <div class="col-md-12">
                <div class="pull-right">
                    <!-- Pagination -->
                    <ul class="pagination">
                    </ul>
                </div>
                <div class="pull-left">
                    <!-- summaryText -->
                    <div class="summary">
                        <h5 style="color: green"><u><b><i>Ümumi məlumatların sayı : 12</i></b></u></h5>
                    </div>
                </div>
                <div class="clearfix"></div>
                <!-- Pages widget -->
                <div class="widget pages-widget">
                    <div class="widget-head br-green">
                        <h3><i class="fa fa-list"></i> Xidmətlər</h3>
                    </div>
                    <div class="widget-body no-padd">
                        <div class="table-responsive">
                            <table class="table table-bordered table">
                                <thead>
                                <tr>
                                    <th class="checkbox-column" id="check"><input value="1" name="check_all" id="check_all" type="checkbox"></th>
                                    <th id="services_c1"><a class="sort-link" href="/ibar/ru/admin/services/index?sort=id">ID<span class="caret"></span></a></th>
                                    <th id="services_c2">Adı Azərbaycanca</th>
                                    <th id="services_c3">Əsas xidmət</th>
                                    <th id="services_c4">Status</th>
                                    <th class="button-column" id="services_c5">Sıralama</th>
                                    <th class="button-column" id="services_c6">Əməliyyatlar</th>
                                </tr>
                                <tr class="filters">
                                    <td>&nbsp;</td>
                                    <td>
                                        <div class="filter-container"><input class="form-control" name="Services[id]" id="Services_id" type="text"></div>
                                    </td>
                                    <td>
                                        <div class="filter-container"><input class="form-control" name="Services[name_az]" id="Services_name_az" maxlength="255" type="text"></div>
                                    </td>
                                    <td>
                                        <div class="filter-container">
                                            <select class="form-control" name="Services[parent_id]" id="Services_parent_id">
                                                <option value="">Hamısı</option>
                                                <option value="0">Ana Xidmət</option>
                                                <option value="1">Kreditlər</option>
                                                <option value="2">Əmanətlər</option>
                                                <option value="3">Kartlar </option>
                                                <option value="7">Köçürmələr</option>
                                                <option value="8">InternetBank</option>
                                                <option value="10">MobilBank</option>
                                                <option value="11">SMS Xəbərdarlıq</option>
                                                <option value="12">Avtomatik Ödəmə</option>
                                                <option value="13">R@ndevu</option>
                                                <option value="15">TPIN kodu</option>
                                                <option value="16">ElKart</option>
                                                <option value="17">Pensiya+</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="filter-container">
                                            <select class="form-control" name="Services[status]" id="Services_status">
                                                <option value="">Hamısı</option>
                                                <option value="1">Görsənən</option>
                                                <option value="0">Görsənməyən</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr id="2" class="odd">
                                    <td style="width: 10px;"><input class="checkbox1" value="2" id="check_0" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">2</td>
                                    <td style="width: 200px;">Əmanətlər</td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/2">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/2?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/2?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/2"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/2"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/2" id="yt1"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <tr id="1" class="even">
                                    <td style="width: 10px;"><input class="checkbox1" value="1" id="check_1" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">1</td>
                                    <td style="width: 200px;">Kreditlər</td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/1">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/1?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/1?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/1"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/1"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/1" id="yt2"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <tr id="3" class="odd">
                                    <td style="width: 10px;"><input class="checkbox1" value="3" id="check_2" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">3</td>
                                    <td style="width: 200px;">Kartlar </td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/3">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/3?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/3?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/3"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/3"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/3" id="yt3"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <tr id="7" class="even">
                                    <td style="width: 10px;"><input class="checkbox1" value="7" id="check_3" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">7</td>
                                    <td style="width: 200px;">Köçürmələr</td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/7">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/7?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/7?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/7"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/7"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/7" id="yt4"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <tr id="8" class="odd">
                                    <td style="width: 10px;"><input class="checkbox1" value="8" id="check_4" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">8</td>
                                    <td style="width: 200px;">InternetBank</td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/8">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/8?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/8?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/8"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/8"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/8" id="yt5"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <tr id="10" class="even">
                                    <td style="width: 10px;"><input class="checkbox1" value="10" id="check_5" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">10</td>
                                    <td style="width: 200px;">MobilBank</td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/10">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/10?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/10?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/10"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/10"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/10" id="yt6"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <tr id="11" class="odd">
                                    <td style="width: 10px;"><input class="checkbox1" value="11" id="check_6" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">11</td>
                                    <td style="width: 200px;">SMS Xəbərdarlıq</td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/11">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/11?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/11?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/11"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/11"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/11" id="yt7"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <tr id="12" class="even">
                                    <td style="width: 10px;"><input class="checkbox1" value="12" id="check_7" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">12</td>
                                    <td style="width: 200px;">Avtomatik Ödəmə</td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/12">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/12?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/12?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/12"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/12"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/12" id="yt8"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <tr id="13" class="odd">
                                    <td style="width: 10px;"><input class="checkbox1" value="13" id="check_8" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">13</td>
                                    <td style="width: 200px;">R@ndevu</td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/13">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/13?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/13?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/13"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/13"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/13" id="yt9"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <tr id="15" class="even">
                                    <td style="width: 10px;"><input class="checkbox1" value="15" id="check_9" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">15</td>
                                    <td style="width: 200px;">TPIN kodu</td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/15">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/15?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/15?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/15"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/15"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/15" id="yt10"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <tr id="16" class="odd">
                                    <td style="width: 10px;"><input class="checkbox1" value="16" id="check_10" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">16</td>
                                    <td style="width: 200px;">ElKart</td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/16">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/16?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/16?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/16"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/16"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/16" id="yt11"><i class="fa fa-times"></i></a></td>
                                </tr>
                                <tr id="17" class="even">
                                    <td style="width: 10px;"><input class="checkbox1" value="17" id="check_11" name="check[]" type="checkbox"></td>
                                    <td style="width: 20px;">17</td>
                                    <td style="width: 200px;">Pensiya+</td>
                                    <td style="width: 200px;">Ana Xidmət</td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" href="/ibar/ru/admin/services/status/17">Active</a></td>
                                    <td style="width: 100px;"><a class="btn btn-success btn-sm position" title="Yuxarı" data-move="up" href="/ibar/ru/admin/services/changePosition/17?move=up"><i class="fa fa-arrow-circle-up"></i></a> <a class="btn btn-danger btn-sm position" title="Aşağı" data-move="down" href="/ibar/ru/admin/services/changePosition/17?move=down"><i class="fa fa-arrow-circle-down"></i></a></td>
                                    <td style="width: 140px;"><a class="btn btn-warning btn-sm" title="Bax" href="/ibar/ru/admin/services/view/17"><i class="fa fa-eye"></i></a> <a class="btn btn-success btn-sm" title="" href="/ibar/ru/admin/services/update/17"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-sm" title="" href="/ibar/ru/admin/services/delete/17" id="yt12"><i class="fa fa-times"></i></a></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="widget-foot">
				  <span class="pull-left">
				  <input class="btn btn-danger btn-sm" name="yt0" value="Seçilmişləri sil" id="yt0" type="submit">
				  </span>
                        <div class="pull-right">
                            <!-- Pagination -->
                            <ul class="pagination">
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="keys" style="display:none" title="/ibar/ru/admin/services"><span>2</span><span>1</span><span>3</span><span>7</span><span>8</span><span>10</span><span>11</span><span>12</span><span>13</span><span>15</span><span>16</span><span>17</span></div>
        </div>
    </form>
    <div class="clearfix"></div>
</div>