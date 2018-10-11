<?php

namespace backend\models;

use backend\components\MyFunctions;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;


class SlidersSearch extends Sliders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'create_time', 'status', 'save_mode'], 'integer'],
            [MyFunctions::attrForLangs('title'), 'safe'],
            [MyFunctions::attrForLangs('text'), 'safe'],
            [['table_name'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Sliders::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'create_time' => $this->create_time,
            'status' => $this->status,
        ]);

        $title='title_'.Yii::$app->params["defaultLanguage"];
        $text='text_'.Yii::$app->params["defaultLanguage"];
        $query->andFilterWhere(['like', $title, $this->$title])
            ->andFilterWhere(['like', $text, $this->$text])
            ->andFilterWhere(['like', 'table_name', $this->table_name]);

		$orderBy=[];
        if(self::$sortableStatus===true) $orderBy['position'] = self::$sortablePositionOrder;
        if(self::$sortableConditionStatus===true) $orderBy[self::$sortableConditionField]= self::$sortableConditionFieldOrder;
        $query->orderBy($orderBy);

        return $dataProvider;
    }
}
