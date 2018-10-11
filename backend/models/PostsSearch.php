<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PostsSearch represents the model behind the search form about `backend\models\Posts`.
 */
class PostsSearch extends Posts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'album_id', 'author_id', 'view_count', 'like_count', 'dislike_count', 'comment_count',  'flash_status', 'status'], 'integer'],
            [['title_'.Yii::$app->params["defaultLanguage"], 'tags', 'slug','desc','news_time','create_time'], 'safe'],
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
        $query = Posts::find()->select('posts.*, ca.table_name')->leftJoin('categories ca','posts.category_id=ca.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if($this->news_time!='') $this->news_time=strtotime($this->news_time);

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'album_id' => $this->album_id,
            'author_id' => $this->author_id,
            'view_count' => $this->view_count,
            'like_count' => $this->like_count,
            'dislike_count' => $this->dislike_count,
            'comment_count' => $this->comment_count,
            'news_time' => $this->news_time,
            'flash_status' => $this->flash_status,
            'status' => $this->status,
        ]);

        $query->leftJoin('categories','categories.id=posts.category_id');

        $query->andFilterWhere(['between', 'create_time', $this->create_time, $this->create_time+86399]);

        $title='title_'.Yii::$app->params["defaultLanguage"];
        $text='text_'.Yii::$app->params["defaultLanguage"];
        $shortText='short_text_'.Yii::$app->params["defaultLanguage"];

        $query->andFilterWhere(['like', $title, $this->$title])
            ->andFilterWhere(['like', $shortText, $this->$shortText])
            ->andFilterWhere(['like', $text, $this->$text])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'slug', $this->slug]);
			
		$orderBy['news_time']=SORT_DESC;
        $query->orderBy($orderBy);

        return $dataProvider;
    }
}
