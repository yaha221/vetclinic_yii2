<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC
 */
class MyRbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;

        $auth->removeAll(); 

        $admin = $auth->createRole('admin');
        $vet = $auth->createRole('vet');
        $client = $auth->createRole('client');
        $administrator = $auth->createRole('administrator');
        
        $auth->add($admin);
        $auth->add($vet);
        $auth->add($client);
        $auth->add($administrator);

        $viewAdminPage = $auth->createPermission('viewAdminPage');
        $viewAdminPage->description = 'Просмотр админ панели';
        
        $logoutUser = $auth->createPermission('logoutUser');
        $logoutUser->description = 'Выход из учётной записи';

        $auth->add($viewAdminPage);
        $auth->add($logoutUser);

        $auth->addChild($client,$logoutUser);

        $auth->addChild($admin, $viewAdminPage);

        $auth->addChild($administrator, $client);

        $auth->addChild($vet, $administrator);

        $auth->addChild($admin, $vet);

        $auth->assign($admin, 1);

        $auth->assign($vet, 2);

        $auth->assign($administrator, 3);

        $auth->assign($client, 4);

        $auth->assign($client, 5);
    }
}