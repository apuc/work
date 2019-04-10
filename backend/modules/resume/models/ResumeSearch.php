<?php

namespace backend\modules\resume\models;

use common\classes\Debug;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Resume;

/**
 * ResumeSearch represents the model behind the search form of `common\models\Resume`.
 *
 * @property int $employment_type_id
 */
class ResumeSearch extends Resume
{
    public $employment_type_id;
    public $category_id;
    public $skill_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'employer_id', 'status', 'created_at', 'updated_at', 'category_id', 'skill_id'], 'integer'],
            [['title', 'image_url', 'min_salary', 'max_salary', 'city', 'description', 'skype', 'instagram', 'facebook', 'vk'], 'safe'],
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
        $query = Resume::find();
        $query->joinWith(['skill']);
        $query->joinWith(['category']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        //Debug::dd($this->employment_type_id);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'employer_id' => $this->employer_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'skill.id' => $this->skill_id,
            'category.id' => $this->category_id
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);
        return $dataProvider;
    }
}
