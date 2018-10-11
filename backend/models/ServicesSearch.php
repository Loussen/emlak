<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ServicesSearch represents the model behind the search form about `backend\models\Services`.
 */
class ServicesSearch extends Services
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'position', 'status'], 'integer'],
            [['title_'.Yii::$app->params["defaultLanguage"], 'short_text_'.Yii::$app->params["defaultLanguage"], 'text_'.Yii::$app->params["defaultLanguage"], 'image', 'thumb', 'slug'], 'safe'],
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
        $query = Services::find();

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

        $query->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'thumb', $this->thumb])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        $title='title_'.Yii::$app->params["defaultLanguage"];
        $text='text_'.Yii::$app->params["defaultLanguage"];
        $shortText='short_text_'.Yii::$app->params["defaultLanguage"];

        $query->andFilterWhere(['like', $title, $this->$title])
            ->andFilterWhere(['like', $shortText, $this->$shortText])
            ->andFilterWhere(['like', $text, $this->$text])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        return $dataProvider;
    }
}
