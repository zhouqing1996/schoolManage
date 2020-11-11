# Vue-Yii

## (1)介绍：

    Vue为前端，Yii为后台，简单个人问题总结系统

## (2)操作步骤：

 

 - 1、git clone https://github.com/zhouqing1996/Question.git
 - 2、前后端分开操作：
 - [ ] vue(Vue):
 1. 进入项目文件，安装依赖 `cnpm(npm) install`
 2. 运行：`cnpm(npm) run dev`

 3. 浏览器中运行`http://localhost:8080` (具体内容看cnpm run dev的结果)

 - [ ] Yii(YII):
 1. 进入项目文件夹，执行`composer install --ignore-platform-reqs` (忽略版本问题)
 2. 执行`php init`初始化项目，选择`[0]development`
 3. 修改`advanced\common\config\main-local.conf`中的数据库连接信息
```php
<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=***;dbname=**',
            'username' => '*',
            'password' => '*',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
```
	