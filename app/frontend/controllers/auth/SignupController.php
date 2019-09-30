<?php
namespace frontend\controllers\auth;

use common\auth\Identity;
use Yii;
use cinema\forms\auth\SignupForm;
use cinema\useCases\auth\SignupService;
use yii\web\Controller;

class SignupController extends Controller
{

    private $service;

    public function __construct($id, $module, SignupService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex()
    {
        $form = new SignupForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->signup($form);
                Yii::$app->user->login(new Identity($user), Yii::$app->params['user.rememberMeDuration']);
                Yii::$app->session->setFlash('success', 'Welcome!!!');
                return $this->goHome();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('index', [
            'model' => $form,
        ]);
    }

}