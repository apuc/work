<?php


namespace frontend\controllers;


use common\models\Country;
use common\models\Category;
use common\models\City;
use common\models\Company;
use common\models\Professions;
use common\models\Resume;
use common\models\Vacancy;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class SitemapController extends Controller
{

    public function actionIndex() {
        $siteMaps = ["other"];

        $vacanciesPagesCount = ceil(Vacancy::find()->where(['status'=>Vacancy::STATUS_ACTIVE])->count()/10000);
        for($i=1;$i<=$vacanciesPagesCount;$i++)
            $siteMaps[] = "vacancy_$i";

        $resumePagesCount = ceil(Resume::find()->where(['!=', 'status', Resume::STATUS_INACTIVE])->count()/10000);
        for($i=1;$i<=$resumePagesCount;$i++)
            $siteMaps[] = "resume_$i";

        $companyPagesCount = ceil(Company::find()->where(['status'=>Company::STATUS_ACTIVE])->count()/10000);
        for($i=1;$i<=$companyPagesCount;$i++)
            $siteMaps[] = "company_$i";

        $citiesCount = City::find()->where(['status'=>City::TYPE_SHOWN])->count();
        $categoriesCount = Category::find()->count();
        $professionsCount = Professions::find()->count();
        $countriesCount = Country::find()->count();

        $cityPagesCount = ceil($citiesCount/5000);
        for($i=1;$i<=$cityPagesCount;$i++)
            $siteMaps[] = "city_$i";

        $categoryPagesCount = ceil($categoriesCount/5000);
        for($i=1;$i<=$categoryPagesCount;$i++)
            $siteMaps[] = "category_$i";

        $professionPagesCount = ceil($professionsCount/9999);
        for($i=1;$i<=$professionPagesCount;$i++)
            $siteMaps[] = "profession_$i";

        $cityWithCategoryPagesCount = ceil(($citiesCount*$categoriesCount)/5000);
        for($i=1;$i<=$cityWithCategoryPagesCount;$i++)
            $siteMaps[] = "city_with_category_$i";
        $cityWithProfessionPagesCount = ceil($citiesCount*$professionsCount/10000);
        for($i=1;$i<=$cityWithProfessionPagesCount;$i++)
            $siteMaps[] = "city_with_profession_$i";

        $countryWithCategoryPagesCount = ceil(($countriesCount*$categoriesCount)/10000);
        for($i=1;$i<=$countryWithCategoryPagesCount;$i++)
            $siteMaps[] = "country_with_category_$i";
        $countryWithProfessionPagesCount = ceil($countriesCount*$professionsCount/10000);
        for($i=1;$i<=$countryWithProfessionPagesCount;$i++)
            $siteMaps[] = "country_with_profession_$i";


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

    public function actionCompany($number) {
        if (!$xml_sitemap = Yii::$app->cache->get("company_$number")) {
            /** @var Company[] $companies */
            $companies = Company::find()
                ->where(['status' => Company::STATUS_ACTIVE])
                ->andWhere(['!=', 'name', ''])
                ->select(['id', 'updated_at'])
                ->limit($number * 10000)
                ->offset(($number - 1) * 10000)
                ->all();
            $host = Yii::$app->request->hostInfo;
            $urls = [];
            foreach ($companies as $company) {
                $urls[] = [
                    'loc' => "$host/company/view/$company->id",
                    'lastmod' => date(DATE_W3C, $company->updated_at),
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
            Yii::$app->cache->set("company_$number", $xml_sitemap, 3600);
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
                ->where(['!=', 'status', Resume::STATUS_INACTIVE])
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

    public function actionProfession($number) {
        if (!$xml_sitemap = Yii::$app->cache->get("profession_$number")) {
            /** @var Professions[] $professions */
        $professions = Professions::find()
                ->select(['slug'])
                ->limit($number * 9999)
                ->offset(($number - 1) * 9999)
                ->all();
            $host = Yii::$app->request->hostInfo;
            $urls = [];
            foreach ($professions as $profession) {
                $urls[] = [
                    'loc' => "$host/vacancy/$profession->slug",
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
            Yii::$app->cache->set("profession_$number", $xml_sitemap, 3600);
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

    public function actionCityWithProfession($number) {
        if (!$xml_sitemap = Yii::$app->cache->get("city_with_profession_$number")) {
            /** @var Professions[] $professions */
            $professions = Professions::find()->select(['slug'])->all();
            /** @var City[] $cities */
            $cities = City::find()
                ->where(['status' => City::TYPE_SHOWN])
                ->select(['slug'])
                ->limit((int)($number * (10000/count($professions))))
                ->offset((int)(($number - 1) * (10000/count($professions))))
                ->all();
            $host = Yii::$app->request->hostInfo;
            $urls = [];
            foreach ($professions as $profession){
                foreach ($cities as $city) {
                    $urls[] = [
                        'loc' => "$host/vacancy/$city->slug/$profession->slug",
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
            Yii::$app->cache->set("city_with_profession_$number", $xml_sitemap, 3600);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        return $xml_sitemap;
    }

    public function actionCountryWithCategory($number) {
        if (!$xml_sitemap = Yii::$app->cache->get("country_with_category_$number")) {
            /** @var Category[] $categories */
            $categories = Category::find()->select(['slug'])->all();
            /** @var Country[] $countries */
            $countries = Country::find()
                ->select(['slug'])
                ->limit((int)($number * (10000/count($categories))))
                ->offset((int)(($number - 1) * (10000/count($categories))))
                ->all();
            $host = Yii::$app->request->hostInfo;
            $urls = [];
            foreach ($categories as $category){
                foreach ($countries as $country) {
                    $urls[] = [
                        'loc' => "$host/vacancy/$country->slug/$category->slug",
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
            Yii::$app->cache->set("country_with_category_$number", $xml_sitemap, 3600);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        return $xml_sitemap;
    }

    public function actionCountryWithProfession($number) {
        if (!$xml_sitemap = Yii::$app->cache->get("country_with_profession_$number")) {
            /** @var Professions[] $professions */
            $professions = Professions::find()->select(['slug'])->all();
            /** @var Country[] $countries */
            $countries = Country::find()
                ->select(['slug'])
                ->limit((int)($number * (10000/count($professions))))
                ->offset((int)(($number - 1) * (10000/count($professions))))
                ->all();
            $host = Yii::$app->request->hostInfo;
            $urls = [];
            foreach ($professions as $profession){
                foreach ($countries as $country) {
                    $urls[] = [
                        'loc' => "$host/vacancy/$country->slug/$profession->slug",
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
            Yii::$app->cache->set("country_with_profession_$number", $xml_sitemap, 3600);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        return $xml_sitemap;
    }

    public function actionOther()
    {
        $host = Yii::$app->request->hostInfo;
        if (!$xml_sitemap = Yii::$app->cache->get('other_sitemap')) {
            $urls = [
                [
                    'loc' => $host,
                    'changefreq' => 'daily',
                    'priority' => 1.0,
                ],
                [
                    'loc' => "$host/vacancy",
                    'changefreq' => 'daily',
                    'priority' => 0.9,
                ],
                [
                    'loc' => "$host/resume",
                    'changefreq' => 'daily',
                    'priority' => 0.9,
                ],
                [
                    'loc' => "$host/cities",
                    'changefreq' => 'daily',
                    'priority' => 0.9,
                ],
                [
                    'loc' => "$host/employer",
                    'changefreq' => 'daily',
                    'priority' => 0.9,
                ],
                [
                    'loc' => "$host/professions",
                    'changefreq' => 'daily',
                    'priority' => 0.9,
                ],
            ];
            /** @var Country $country */
            foreach (Country::find()->all() as $country) {
                $urls[] = [
                    'loc' => "$host/$country->slug/professions",
                    'changefreq' => 'daily',
                    'priority' => 0.9,
                ];
                $urls[] = [
                    'loc' => "$host/$country->slug",
                    'changefreq' => 'daily',
                    'priority' => 1.0,
                ];
            }

            $xml_sitemap = $this->renderPartial('urlset', [
                'host' => Yii::$app->request->hostInfo,
                'urls' => $urls,
            ]);

            Yii::$app->cache->set('other_sitemap', $xml_sitemap, 3600);
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml');
        return $xml_sitemap;
    }

}