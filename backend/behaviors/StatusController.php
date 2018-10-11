<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 14.06.2015
 * Time: 13:44
 */

namespace backend\behaviors;


class StatusController extends \yii\base\Behavior {
    public $model;
    const STATUS_ACTIVE=1;
    const STATUS_DEACTIVE=0;

    public function changeStatus($id){
        $model = $this->model;
        $row = $model::findOne($id);
        if($row->status==self::STATUS_ACTIVE)
            $row->status=self::STATUS_DEACTIVE;
        else
            $row->status=self::STATUS_ACTIVE;

        if($row->save(false))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}