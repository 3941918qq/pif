<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();

        // 添加 "viewSuccessExample" 权限
        $viewSuccessExample = $auth->createPermission('viewSuccessExample');
        $viewSuccessExample->description = '查看案例';
        $auth->add($viewSuccessExample);
        
        // 添加 "createSuccessExample" 权限
        $createSuccessExample = $auth->createPermission('createSuccessExample');
        $createSuccessExample->description = '添加案例';
        $auth->add($createSuccessExample);

        // 添加 "updateSuccessExample" 权限
        $updateSuccessExample = $auth->createPermission('updateSuccessExample');
        $updateSuccessExample->description = '更新案例';
        $auth->add($updateSuccessExample);
        
        //删除 "deleteSuccessExample" 权限
        $deleteSuccessExample = $auth->createPermission('deleteSuccessExample');
        $deleteSuccessExample->description = '删除案例';
        $auth->add($deleteSuccessExample);

        // 添加 "viewDataManage" 权限
        $viewDataManage = $auth->createPermission('viewDataManage');
        $viewDataManage->description = '查看产品';
        $auth->add($viewDataManage);
        
        // 添加 "createDataManage" 权限
        $createDataManage = $auth->createPermission('createDataManage');
        $createDataManage->description = '添加产品';
        $auth->add($createDataManage);

        // 添加 "updateDataManage" 权限
        $updateDataManage = $auth->createPermission('updateDataManage');
        $updateDataManage->description = '更新产品';
        $auth->add($updateDataManage);
        
        //删除 "deleteDataManage" 权限
        $deleteDataManage = $auth->createPermission('deleteDataManage');
        $deleteDataManage->description = '删除产品';
        $auth->add($deleteDataManage);
        
        // 查看 "viewUser" 权限
        $viewUser = $auth->createPermission('viewUser');
        $viewUser->description = '查看用户';
        $auth->add($viewUser);
               
        // 添加 "updateUser" 权限
        $updateUser = $auth->createPermission('updateUser');
        $updateUser->description = '更新用户';
        $auth->add($updateUser);
        
        //删除 "deleteUser" 权限
        $deleteUser = $auth->createPermission('deleteUser');
        $deleteUser->description = '删除用户';
        $auth->add($deleteUser);
        
        // 查看 "viewComment" 权限
        $viewComment = $auth->createPermission('viewComment');
        $viewComment->description = '评论查看管理';
        $auth->add($viewComment);
        
        // 查看 "viewHome" 权限
        $viewHome = $auth->createPermission('viewHome');
        $viewHome->description = '首页查看';
        $auth->add($viewHome);
        
        //查看"viewAdminuser"权限
        $viewAdminuser = $auth->createPermission('viewAdminuser');
        $viewAdminuser->description = '权限管理';
        $auth->add($viewAdminuser);
        
              
        // 添加 "exampleAdmin" 角色并赋予权限
        $exampleAdmin = $auth->createRole('exampleAdmin');
        $exampleAdmin->description="案例管理员";
        $auth->add($exampleAdmin);
        $auth->addChild($exampleAdmin, $viewSuccessExample);
        $auth->addChild($exampleAdmin, $createSuccessExample);
        $auth->addChild($exampleAdmin, $updateSuccessExample);
        $auth->addChild($exampleAdmin, $deleteSuccessExample);

        // 添加 "productAdmin" 角色并赋予权限
        $productAdmin = $auth->createRole('productAdmin');
        $productAdmin->description="产品管理员";
        $auth->add($productAdmin);
        $auth->addChild($productAdmin, $viewDataManage);
        $auth->addChild($productAdmin, $createDataManage);
        $auth->addChild($productAdmin, $updateDataManage);
        $auth->addChild($productAdmin, $deleteDataManage);
        
        // 添加 "userAdmin" 角色并赋予权限
        $userAdmin = $auth->createRole('userAdmin');
        $userAdmin->description="用户管理员";
        $auth->add($userAdmin);
        $auth->addChild($userAdmin, $viewUser);
        $auth->addChild($userAdmin, $updateUser);
        $auth->addChild($userAdmin, $deleteUser);
        
        // 添加 "commentAdmin" 角色并赋予权限
        $commentAdmin = $auth->createRole('commentAdmin');
        $commentAdmin->description="评论管理员";
        $auth->add($commentAdmin);
        $auth->addChild($commentAdmin, $viewComment);
        
        // 添加 "homeAdmin" 角色并赋予权限
        $homeAdmin = $auth->createRole('homeAdmin');
        $homeAdmin->description="首页管理员";
        $auth->add($homeAdmin);
        $auth->addChild($homeAdmin, $viewHome);
        
        
        // 添加 "admin" 角色并赋予 "updatePost" 
		// 和 "author" 权限
        $admin = $auth->createRole('admin');
        $admin->description="系统管理员";
        $auth->add($admin);
        $auth->addChild($admin, $exampleAdmin);
        $auth->addChild($admin, $productAdmin);
        $auth->addChild($admin, $userAdmin);
        $auth->addChild($admin, $commentAdmin);
        $auth->addChild($admin, $homeAdmin);
        $auth->addChild($admin, $viewAdminuser);
        
        // 为用户指派角色。其中 1 和 2 是由 IdentityInterface::getId() 返回的id
        // 通常在你的 User 模型中实现这个函数。
        $auth->assign($admin, 1);
    }
}

