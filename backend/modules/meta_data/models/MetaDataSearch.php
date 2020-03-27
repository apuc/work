<?php

namespace backend\modules\meta_data\models;
use common\models\Category;
use common\models\Professions;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MetaData;
use yii\helpers\ArrayHelper;


/**
 * @property string $category_string
 */
class MetaDataSearch extends MetaData
{
    public $category_string = '';
    public $profession_string = '';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'profession_id'], 'integer'],
            [['category_string', 'profession_string', 'vacancy_meta_title', 'vacancy_meta_description', 'vacancy_header', 'vacancy_meta_title_with_city', 'vacancy_meta_description_with_city', 'vacancy_header_with_city', 'vacancy_bottom_text', 'resume_meta_title', 'resume_meta_description', 'resume_header', 'resume_meta_title_with_city', 'resume_meta_description_with_city', 'resume_header_with_city', 'resume_bottom_text'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = MetaData::find();

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
        $categories = Category::find()->select('id')->where(['like', 'name', $this->category_string])->all();
        $professions = Professions::find()->select('id')->where(['like', 'title', $this->profession_string])->all();
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);
        if($this->category_string)
            $query->andFilterWhere(['category_id' => ArrayHelper::getColumn($categories, 'id')]);
        if($this->profession_string)
            $query->andFilterWhere(['profession_id' => ArrayHelper::getColumn($professions, 'id')]);
        $query->joinWith('category');
        $query->andFilterWhere(['like', 'vacancy_meta_title', $this->vacancy_meta_title])
            ->andFilterWhere(['like', 'vacancy_meta_description', $this->vacancy_meta_description])
            ->andFilterWhere(['like', 'vacancy_header', $this->vacancy_header])
            ->andFilterWhere(['like', 'vacancy_meta_title_with_city', $this->vacancy_meta_title_with_city])
            ->andFilterWhere(['like', 'vacancy_meta_description_with_city', $this->vacancy_meta_description_with_city])
            ->andFilterWhere(['like', 'vacancy_header_with_city', $this->vacancy_header_with_city])
            ->andFilterWhere(['like', 'vacancy_bottom_text', $this->vacancy_bottom_text])
            ->andFilterWhere(['like', 'resume_meta_title', $this->resume_meta_title])
            ->andFilterWhere(['like', 'resume_meta_description', $this->resume_meta_description])
            ->andFilterWhere(['like', 'resume_header', $this->resume_header])
            ->andFilterWhere(['like', 'resume_meta_title_with_city', $this->resume_meta_title_with_city])
            ->andFilterWhere(['like', 'resume_meta_description_with_city', $this->resume_meta_description_with_city])
            ->andFilterWhere(['like', 'resume_header_with_city', $this->resume_header_with_city])
            ->andFilterWhere(['like', 'resume_bottom_text', $this->resume_bottom_text])
            ->andFilterWhere(['like', 'category.name', $this->category_string]);

        return $dataProvider;
    }
}
