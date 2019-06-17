<?php


namespace frontend\controllers;


use common\classes\Debug;
use common\models\Resume;
use common\models\Vacancy;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;

class SitemapController extends Controller
{

    public function actionIndex()
    {
        Yii::$app->cache->delete('sitemap');
        if (!$xml_sitemap = Yii::$app->cache->get('sitemap')) {

            $urls = [
                [
                    'loc' => '/',
                    'changefreq' => 'daily',
                    'priority' => 1.0,
                ],
                [
                    'loc' => '/vacancy/search',
                    'changefreq' => 'daily',
                    'priority' => 0.9,
                ],
                [
                    'loc' => '/resume/search',
                    'changefreq' => 'daily',
                    'priority' => 0.9,
                ],
            ];

            /** @var Vacancy[] $vacancies */
            $vacancies = Vacancy::find()->where(['status'=>Vacancy::STATUS_ACTIVE])->orderBy('id DESC')->all();
            foreach ($vacancies as $vacancy) {
                $urls[] = [
                    'loc' => '/vacancy/view/'.$vacancy->id,
                    'lastmod' => date( DATE_W3C, $vacancy->updated_at),
                    'changefreq' => 'daily',
                    'priority' => 0.8
                ];
            }

            /** @var Resume[] $resumes */
            $resumes = Resume::find()->where(['status'=>Resume::STATUS_ACTIVE])->orderBy('id DESC')->all();
            foreach ($resumes as $resume) {
                $urls[] = [
                    'loc' => '/resume/view/'.$resume->id,
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

        //Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');

        return $xml_sitemap;
    }

}