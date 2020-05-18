<?php

namespace app\controllers;

use app\models\Categories;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\Posts;
use Faker\Factory;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {



        if (Yii::$app->request->get('cat') == true) {
            if (!$post = Categories::find()->where('alias = :alias', [':alias' => Yii::$app->request->get('cat')])->one()) {
                throw new NotFoundHttpException('!@#$%^&*!', 404);
            }
            $cat = Yii::$app->request->get('cat');
            $cat_query = Categories::find()->Where('alias = :alias', [':alias' => $cat])->one();
            //var_dump($cat_query->id);
            $query = Posts::find()->Where('category = :category', [':category' => $cat_query->id])->orderby(['id' => SORT_DESC]);
        } else {
            $query = Posts::find()->orderby(['id' => SORT_DESC]);
        }


        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);

        $pages->pageSizeParam = false;
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);


    }

    public function actionPage()
    {
        if (!$post = Posts::find()->where('id = :id', [':id' => Yii::$app->request->get('id')])->one()) {
            throw new NotFoundHttpException('!@#$%^&*!', 404);
        }


        if (Yii::$app->request->get('id') == true) {

            $page = Yii::$app->request->get('id');

            $query = Posts::find()->Where('id = :id', [':id' => $page])->one();

            $model = $query;


        }
        return $this->render('page', [
            'model' => $model,

        ]);
    }

    public function actionFaker()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $post = new Posts();
            $post->title = $faker->text(30);
            $post->keywords = $faker->text(rand(100, 200));
            $post->description = $faker->text(rand(100, 200));
            $post->text = $faker->text(rand(1000, 2000));
            $post->category = rand(1, 5);
            $post->alias = $faker->text(rand(5, 20));
            $post->created_date = $faker->date();
            $post->save(false);
        }
        die('Data generation is complete!');
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
