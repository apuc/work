<?php

namespace frontend\modules\request\filters;

use frontend\modules\request\services\ApplicationService;
use yii\filters\auth\HttpBearerAuth;
use yii\web\UnauthorizedHttpException;

/**
 * Фильтр для аутентификации API-запросов
 *
 * @author Alex Korona ой зря я это подписал...
 */
class AccessTokenAuth extends HttpBearerAuth
{
    /**
     * @var ApplicationService $applicationService
     */
    private $applicationService;

    /**
     * @throws UnauthorizedHttpException
     */
    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function init()
    {
        parent::init();
        $this->applicationService = new ApplicationService();
    }

    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get($this->header);

        if ($authHeader !== null) {
            if ($this->pattern !== null) {
                if (preg_match($this->pattern, $authHeader, $matches)) {
                    $authHeader = $matches[1];
                } else {
                    return null;
                }
            }


            $identity = $this->applicationService->loginByAccessToken($authHeader);
            if ($identity === null) {
                $this->challenge($response);
                $this->handleFailure($response);
            }

            return $identity;
        }

        return null;
    }
}