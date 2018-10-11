<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Apartments;

/**
 * ApartmentsSearch represents the model behind the search form about `backend\models\Apartments`.
 */
class ApartmentsSearch extends Apartments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'album_id', 'status'], 'integer'],
            [['title_az', 'title_en', 'title_ru', 'title_tr', 'short_text_az', 'short_text_en', 'short_text_ru', 'short_text_tr', 'about_project_az', 'about_project_en', 'about_project_ru', 'about_project_tr', 'about_company_az', 'about_company_en', 'about_company_ru', 'about_company_tr', 'google_map', 'price', 'address_az', 'address_en', 'address_ru', 'address_tr', 'email', 'mobile', 'slug'], 'safe'],
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
        $query = Apartments::find();

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
            'album_id' => $this->album_id,
            'status' => $this->status,
        ]);

        $title='title_'.Yii::$app->params["defaultLanguage"];
        $short_text='short_text_'.Yii::$app->params["defaultLanguage"];
        $about_project_az='about_project_'.Yii::$app->params["defaultLanguage"];
        $about_company_en='about_company_'.Yii::$app->params["defaultLanguage"];
        $address='address_'.Yii::$app->params["defaultLanguage"];

        $query->andFilterWhere(['like', $title, $this->$title])
            ->andFilterWhere(['like', $short_text, $this->$short_text])
            ->andFilterWhere(['like', $about_project_az, $this->$about_project_az])
            ->andFilterWhere(['like', $about_company_en, $this->$about_company_en])
            ->andFilterWhere(['like', $address, $this->$address])
            ->andFilterWhere(['like', 'google_map', $this->google_map])
            ->andFilterWhere(['like', 'price', $this->price])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'slug', $this->slug]);

        $orderBy=[];
        if(self::$sortableStatus===true) $orderBy['position'] = self::$sortablePositionOrder;
        if(self::$sortableConditionStatus===true) $orderBy[self::$sortableConditionField]= self::$sortableConditionFieldOrder;
        $query->orderBy($orderBy);

        return $dataProvider;
    }
}
