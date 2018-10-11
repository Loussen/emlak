<?php

namespace backend\models;

use backend\components\MyFunctions;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SlidersInnerSearch represents the model behind the search form about `backend\models\SlidersInner`.
 */
class SlidersInnerSearch extends SlidersInner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'parent_id', 'position', 'create_time', 'status'], 'integer'],
            [MyFunctions::attrForLangs('title'), 'safe'],
            [['image', 'thumb', 'target', 'url'], 'safe'],
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
        $query = SlidersInner::find();

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
            'parent_id' => $this->parent_id,
            'position' => $this->position,
            'create_time' => $this->create_time,
            'status' => $this->status,
        ]);

        $title='title_'.Yii::$app->params["defaultLanguage"];
        $query->andFilterWhere(['like', $title, $this->$title])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'target', $this->target])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
