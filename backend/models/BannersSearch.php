<?php

namespace backend\models;

use backend\components\MyFunctions;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BannersSearch represents the model behind the search form about `backend\models\Banners`.
 */
class BannersSearch extends Banners
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'position', 'status', 'save_mode'], 'integer'],
            [MyFunctions::attrForLangs('title'), 'safe'],
            [MyFunctions::attrForLangs('text'), 'safe'],
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
        $query = Banners::find();

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
            'position' => $this->position,
            'status' => $this->status,
        ]);

        $title='title_'.Yii::$app->params["defaultLanguage"];
        $text='text_'.Yii::$app->params["defaultLanguage"];
        $query->andFilterWhere(['like', $title, $this->$title])
            ->andFilterWhere(['like', $text, $this->$text]);

        $orderBy=[];
        if(self::$sortableStatus===true) $orderBy['position'] = self::$sortablePositionOrder;
        if(self::$sortableConditionStatus===true) $orderBy[self::$sortableConditionField]= self::$sortableConditionFieldOrder;
		$orderBy['id']=SORT_ASC;
        $query->orderBy($orderBy);

        return $dataProvider;
    }
}
