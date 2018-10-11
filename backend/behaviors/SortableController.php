<?php
namespace backend\behaviors;

class SortableController extends \yii\base\Behavior {
    public $model;

    public function move($id, $direction, $condition=[])
    {
        $modelClass = $this->model;

        $this->changeZeroPositions();

        if($direction==='up')
        {
            if($modelClass::$sortablePositionOrder == SORT_ASC){
                $eq = '<';
                $order = 'DESC';
            }else {
                $eq = '>';
                $order = 'ASC';
            }
        }
        else
        {
            if($modelClass::$sortablePositionOrder == SORT_ASC){
                $eq = '>';
                $order = 'ASC';
            }else {
                $eq = '<';
                $order = 'DESC';
            }
        }


        $current = $modelClass::findOne($id);
        $whereCondition='';
        if(count($condition)>0)
        {
            foreach($condition as $cond)
            {
                $whereCondition.=$cond.'='.$current->$cond.' ';
            }
        }
        $other = $modelClass::find()->where('position'.$eq.':position ', array(':position'=>$current->position))
            ->andWhere($whereCondition)
            ->orderBy('position '.$order)->one();
        if($other==NULL) return false;
        $currentPosition=$current->position;
        $current->position = $other->position;
        $other->position = $currentPosition;
        if($current->save(false) && $other->save(false)) { return true; }
        else { return false; }
    }

    public function changeZeroPositions()
    {
        $modelClass = $this->model;
        $tableName = $modelClass::tableName();
        $sql="update $tableName set position=id";
        $PositionZeroCount=$modelClass::find()->where(['position' => 0])->count();
        if($PositionZeroCount>1)
        {
            \Yii::$app->db->createCommand($sql)->execute();
        }
    }
}

?>