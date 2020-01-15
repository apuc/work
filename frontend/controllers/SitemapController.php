<?php


namespace frontend\controllers;


use common\classes\Debug;
use common\models\Category;
use common\models\City;
use common\models\Resume;
use common\models\Vacancy;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\HttpException;

class SitemapController extends Controller
{

    public function actionIndex() {
        $siteMaps = [];

        $vacanciesPagesCount = ceil(Vacancy::find()->where(['status'=>Vacancy::STATUS_ACTIVE])->count()/10000);
        for($i=1;$i<=$vacanciesPagesCount;$i++)
            $siteMaps[] = "vacancy_$i";

        $resumePagesCount = ceil(Resume::find()->where(['status'=>Resume::STATUS_ACTIVE])->count()/10000);
        for($i=1;$i<=$resumePagesCount;$i++)
            $siteMaps[] = "resume_$i";

        $citiesCount = City::find()->where(['status'=>City::TYPE_SHOWN])->count();
        $categoriesCount = Category::find()->count();

        $cityPagesCount = ceil($citiesCount/5000);
        for($i=1;$i<=$cityPagesCount;$i++)
            $siteMaps[] = "city_$i";

        $categoryPagesCount = ceil($categoriesCount/5000);
        for($i=1;$i<=$cityPagesCount;$i++)
            $siteMaps[] = "category_$i";

        $cityWithCategoryPagesCount = ceil(($citiesCount*$categoriesCount)/5000);
        for($i=1;$i<=$cityWithCategoryPagesCount;$i++)
            $siteMaps[] = "city_with_category_$i";


        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        return $this->renderPartial('index', [
            'siteMaps'=>$siteMaps
        ]);
    }

    public function actionVacancy($number) {
        if (!$xml_sitemap = Yii::$app->cache->get("vacancy_$number")) {
            /** @var Vacancy[] $vacancies */
            $vacancies = Vacancy::find()
                ->where(['status' => Vacancy::STATUS_ACTIVE])
                ->select(['id', 'updated_at'])
                ->limit($number * 10000)
                ->offset(($number - 1) * 10000)
                ->all();
            $host = Yii::$app->request->hostInfo;
            $urls = [];
            foreach ($vacancies as $vacancy) {
                $urls[] = [
                    'loc' => "$host/vacancy/view/$vacancy->id",
                    'lastmod' => date(DATE_W3C, $vacancy->updated_at),
                    'changefreq' => 'daily',
                    'priority' => 0.8
                ];
            }
            $xml_sitemap = $this->renderPartial('urlset', [
                'host' => Yii::$app->request->hostInfo,
                'urls' => $urls,
            ]);
            if (!$urls)
                throw new HttpException(404, 'Not Found');
            Yii::$app->cache->set("vacancy_$number", $xml_sitemap, 3600);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        return $xml_sitemap;
    }

    public function actionResume($number) {
        if (!$xml_sitemap = Yii::$app->cache->get("resume_$number")) {
            /** @var Resume[] $resumes */
            $resumes = Resume::find()
                ->where(['status' => Resume::STATUS_ACTIVE])
                ->select(['id', 'updated_at'])
                ->limit($number * 10000)
                ->offset(($number - 1) * 10000)
                ->all();
            $host = Yii::$app->request->hostInfo;
            $urls = [];
            foreach ($resumes as $resume) {
                $urls[] = [
                    'loc' => "$host/resume/view/$resume->id",
                    'lastmod' => date(DATE_W3C, $resume->updated_at),
                    'changefreq' => 'daily',
                    'priority' => 0.8
                ];
            }
            $xml_sitemap = $this->renderPartial('urlset', [
                'host' => Yii::$app->request->hostInfo,
                'urls' => $urls,
            ]);
            if (!$urls)
                throw new HttpException(404, 'Not Found');
            Yii::$app->cache->set("resume_$number", $xml_sitemap, 3600);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        return $xml_sitemap;
    }

    public function actionCity($number) {
        if (!$xml_sitemap = Yii::$app->cache->get("city_$number")) {
            /** @var City[] $cities */
            $cities = City::find()
                ->where(['status' => City::TYPE_SHOWN])
                ->select(['slug'])
                ->limit($number * 5000)
                ->offset(($number - 1) * 5000)
                ->all();
            $host = Yii::$app->request->hostInfo;
            $urls = [];
            foreach ($cities as $city) {
                $urls[] = [
                    'loc' => "$host/resume/$city->slug",
                    'changefreq' => 'daily',
                    'priority' => 0.8
                ];
                $urls[] = [
                    'loc' => "$host/vacancy/$city->slug",
                    'changefreq' => 'daily',
                    'priority' => 0.8
                ];
            }
            $xml_sitemap = $this->renderPartial('urlset', [
                'host' => Yii::$app->request->hostInfo,
                'urls' => $urls,
            ]);
            if (!$urls)
                throw new HttpException(404, 'Not Found');
            Yii::$app->cache->set("city_$number", $xml_sitemap, 3600);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        return $xml_sitemap;
    }

    public function actionCategory($number) {
        if (!$xml_sitemap = Yii::$app->cache->get("category_$number")) {
            /** @var Category[] $categories */
            $categories = Category::find()
                ->select(['slug'])
                ->limit($number * 5000)
                ->offset(($number - 1) * 5000)
                ->all();
            $host = Yii::$app->request->hostInfo;
            $urls = [];
            foreach ($categories as $category) {
                $urls[] = [
                    'loc' => "$host/resume/$category->slug",
                    'changefreq' => 'daily',
                    'priority' => 0.8
                ];
                $urls[] = [
                    'loc' => "$host/vacancy/$category->slug",
                    'changefreq' => 'daily',
                    'priority' => 0.8
                ];
            }
            $xml_sitemap = $this->renderPartial('urlset', [
                'host' => Yii::$app->request->hostInfo,
                'urls' => $urls,
            ]);
            if (!$urls)
                throw new HttpException(404, 'Not Found');
            Yii::$app->cache->set("category_$number", $xml_sitemap, 3600);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        return $xml_sitemap;
    }

    public function actionCityWithCategory($number) {
        if (!$xml_sitemap = Yii::$app->cache->get("city_with_category_$number")) {
            /** @var Category[] $categories */
            $categories = Category::find()->select(['slug'])->all();
            /** @var City[] $cities */
            $cities = City::find()
                ->where(['status' => City::TYPE_SHOWN])
                ->select(['slug'])
                ->limit((int)($number * (5000/count($categories))))
                ->offset((int)(($number - 1) * (5000/count($categories))))
                ->all();
            $host = Yii::$app->request->hostInfo;
            $urls = [];
            foreach ($categories as $category){
                foreach ($cities as $city) {
                    $urls[] = [
                        'loc' => "$host/resume/$city->slug/$category->slug",
                        'changefreq' => 'daily',
                        'priority' => 0.8
                    ];
                    $urls[] = [
                        'loc' => "$host/vacancy/$city->slug/$category->slug",
                        'changefreq' => 'daily',
                        'priority' => 0.8
                    ];
                }
            }
            $xml_sitemap = $this->renderPartial('urlset', [
                'host' => Yii::$app->request->hostInfo,
                'urls' => $urls,
            ]);
            if (!$urls)
                throw new HttpException(404, 'Not Found');
            Yii::$app->cache->set("city_with_category_$number", $xml_sitemap, 3600);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        return $xml_sitemap;
    }



    public function actionTest($id)
    {
        return $id;
        Yii::$app->cache->delete('sitemap');
        $host = Yii::$app->request->hostInfo;
        if (!$xml_sitemap = Yii::$app->cache->get('sitemap')) {

            $urls = [
                [
                    'loc' => $host,
                    'changefreq' => 'daily',
                    'priority' => 1.0,
                ],
                [
                    'loc' => "$host/vacancy/search",
                    'changefreq' => 'daily',
                    'priority' => 0.9,
                ],
                [
                    'loc' => "$host/resume/search",
                    'changefreq' => 'daily',
                    'priority' => 0.9,
                ],
            ];

            /** @var Vacancy[] $vacancies */
            $vacancies = Vacancy::find()->where(['status'=>Vacancy::STATUS_ACTIVE])->orderBy('id DESC')->all();
            foreach ($vacancies as $vacancy) {
                $urls[] = [
                    'loc' => "$host/vacancy/view/$vacancy->id",
                    'lastmod' => date( DATE_W3C, $vacancy->updated_at),
                    'changefreq' => 'daily',
                    'priority' => 0.8
                ];
            }

            /** @var Resume[] $resumes */
            $resumes = Resume::find()->where(['status'=>Resume::STATUS_ACTIVE])->orderBy('id DESC')->all();
            foreach ($resumes as $resume) {
                $urls[] = [
                    'loc' => "$host/resume/view/$resume->id",
                    'lastmod' => date( DATE_W3C, $resume->updated_at),
                    'changefreq' => 'daily',
                    'priority' => 0.8
                ];
            }

            $xml_sitemap = $this->renderPartial('index', [
                'host' => Yii::$app->request->hostInfo,
                'urls' => $urls,
            ]);

            Yii::$app->cache->set('sitemap', $xml_sitemap, 3600);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        return $xml_sitemap;
    }

}