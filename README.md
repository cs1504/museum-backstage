# 后台管理子系统

## Api

> 测试 api 可以使用 postman ，postman 是一个跨平台的 post|get 检测软件，很方便


网址改成 http://139.199.102.73:8080/


| 接口名称 | 请求方法 | url |
| --- | --- | --- |
| [获取博物馆信息](#获取博物馆信息) | GET | /api/museum/:id |
| [搜索博物馆](#搜索博物馆) | GET | /api/museum/search/ |
| [管理员登录](#管理员登录) | POST | /api/admin/login/ |
| [用户登录](#用户登录) | POST | /api/user/login/ |
| [获取新闻](#获取新闻) | GET | /api/news/:id |
| [搜索新闻](#搜索新闻) | GET | /api/news/search/ |


### 获取博物馆信息 

```
GET http://139.199.102.73:8080/api/museum/:id
```

返回

```json
{
    "id": 2,
    "name": "测试中国国家博物馆",
    "introduce": "这是测试数据",
    "open_time": "8：00-20：00",
    "edu_activity": null,
    "collection": null,
    "academic": null,
    "lng": null,
    "lat": null
}
```

### 搜索博物馆

```
GET http://139.199.102.73:8080/api/museum/search/
```

待完善


| 参数 | 意义 | 备注 |
| --- | --- | --- |
| name | 搜索关键字 | 必填 |

返回 

```json
[
    {
        "id": 1,
        "name": "测试中国国家博物馆1",
        "introduce": "这是测试数据",
        "open_time": "这是测试数据8：00-20：00",
        "edu_activity": "",
        "collection": "",
        "academic": "",
        "lng": 0,
        "lat": 0
    },
    {
        "id": 2,
        "name": "测试中国国家博物馆",
        "introduce": "这是测试数据",
        "open_time": "8：00-20：00",
        "edu_activity": null,
        "collection": null,
        "academic": null,
        "lng": null,
        "lat": null
    }
]
```


### 管理员登录

```
POST http://139.199.102.73:8080/api/admin/login/
```

| 参数 | 意义 | 备注 |
| --- | --- | --- |
| loginname | 登录名 | 必填 |
| password | 密码 | 必填 | 

返回值

```json
{
    "valid": 1,
    "msg": "登录成功"
}
```

### 用户登录

```
POST http://139.199.102.73:8080/api/user/login/
```

| 参数 | 意义 | 备注 |
| --- | --- | --- |
| loginname | 登录名 | 必填 |
| password | 密码 | 必填 | 

返回值

```json
{
    "valid": 1,
    "msg": "登录成功"
}
```

### 获取新闻

```
POST http://139.199.102.73:8080/api/news/:id
```

返回

```json
{
    "id": 1,
    "title": "浙江良渚古城遗址申遗 博物馆迎参观热",
    "author": "浙江新闻网",
    "release_time": "2018-01-31 00:00:00",
    "modify_time": null,
    "excerpt": "图为:浙江博物馆展出的镇馆之宝——“良渚玉琮王”。 王远 摄 中新网浙江新闻1月31日电(见习记者 王远)近日,中国联合国教科文组织全国委员会秘书处致函联合国 ",
    "content": null,
    "status": 0,
    "nature": null,
    "comment_status": 0,
    "url": null
}
```

### 搜索新闻 


```
GET http://139.199.102.73:8080/api/news/search/
```

待完善


| 参数 | 意义 | 备注 |
| --- | --- | --- |
| title | 按 title 搜索 | 必填 |



----


Nginx 配置文件


```conf
server
	{
		listen 80;
		server_name www.csmuseum.xyz ;
		index index.html index.htm index.php default.html default.htm default.php;
		root  /home/wwwroot/www.csmuseum.xyz/think/public;

		location / {
        		try_files $uri $uri/ /index.php?s=$uri&$args;
    		}	

		location ~ .+.php($|/) {
			set $script $uri;
			set $path_info "/";
			if ($uri ~ "^(.+.php)(/.+)") {
				set $script $1;
				set $path_info $2;
			}

			fastcgi_pass  unix:/tmp/php-cgi.sock;
			fastcgi_index index.php?IF_REWRITE=1;
			include fastcgi.conf;
			fastcgi_param PHP_VALUE "open_basedir=/home/wwwroot/default/tp5/public/:/tmp/:/proc/";
			fastcgi_param PATH_INFO $path_info;
			fastcgi_param SCRIPT_FILENAME $root$fastcgi_script_name;
			include fastcgi_params;
		}


		include none.conf;
		#error_page   404   /404.html;

		include enable-php.conf;

		location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
		{
			expires      30d;
		}

		location ~ .*\.(js|css)?$
		{
			expires      12h;
		}

		location ~ /.well-known {
			allow all;
		}

		location ~ /\.
		{
			deny all;
		}

		access_log off;
	}
```




=================== 华丽的分割线，以下是 ThinkPHP 5.0 的 README ===================




ThinkPHP 5.0
===============

[![Total Downloads](https://poser.pugx.org/topthink/think/downloads)](https://packagist.org/packages/topthink/think)
[![Latest Stable Version](https://poser.pugx.org/topthink/think/v/stable)](https://packagist.org/packages/topthink/think)
[![Latest Unstable Version](https://poser.pugx.org/topthink/think/v/unstable)](https://packagist.org/packages/topthink/think)
[![License](https://poser.pugx.org/topthink/think/license)](https://packagist.org/packages/topthink/think)

ThinkPHP5在保持快速开发和大道至简的核心理念不变的同时，PHP版本要求提升到5.4，对已有的CBD模式做了更深的强化，优化核心，减少依赖，基于全新的架构思想和命名空间实现，是ThinkPHP突破原有框架思路的颠覆之作，其主要特性包括：

 + 基于命名空间和众多PHP新特性
 + 核心功能组件化
 + 强化路由功能
 + 更灵活的控制器
 + 重构的模型和数据库类
 + 配置文件可分离
 + 重写的自动验证和完成
 + 简化扩展机制
 + API支持完善
 + 改进的Log类
 + 命令行访问支持
 + REST支持
 + 引导文件支持
 + 方便的自动生成定义
 + 真正惰性加载
 + 分布式环境支持
 + 更多的社交类库

> ThinkPHP5的运行环境要求PHP5.4以上。

详细开发文档参考 [ThinkPHP5完全开发手册](http://www.kancloud.cn/manual/thinkphp5)

## 目录结构

初始的目录结构如下：

~~~
www  WEB部署目录（或者子目录）
├─application           应用目录
│  ├─common             公共模块目录（可以更改）
│  ├─module_name        模块目录
│  │  ├─config.php      模块配置文件
│  │  ├─common.php      模块函数文件
│  │  ├─controller      控制器目录
│  │  ├─model           模型目录
│  │  ├─view            视图目录
│  │  └─ ...            更多类库目录
│  │
│  ├─command.php        命令行工具配置文件
│  ├─common.php         公共函数文件
│  ├─config.php         公共配置文件
│  ├─route.php          路由配置文件
│  ├─tags.php           应用行为扩展定义文件
│  └─database.php       数据库配置文件
│
├─public                WEB目录（对外访问目录）
│  ├─index.php          入口文件
│  ├─router.php         快速测试文件
│  └─.htaccess          用于apache的重写
│
├─thinkphp              框架系统目录
│  ├─lang               语言文件目录
│  ├─library            框架类库目录
│  │  ├─think           Think类库包目录
│  │  └─traits          系统Trait目录
│  │
│  ├─tpl                系统模板目录
│  ├─base.php           基础定义文件
│  ├─console.php        控制台入口文件
│  ├─convention.php     框架惯例配置文件
│  ├─helper.php         助手函数文件
│  ├─phpunit.xml        phpunit配置文件
│  └─start.php          框架入口文件
│
├─extend                扩展类库目录
├─runtime               应用的运行时目录（可写，可定制）
├─vendor                第三方类库目录（Composer依赖库）
├─build.php             自动生成定义文件（参考）
├─composer.json         composer 定义文件
├─LICENSE.txt           授权说明文件
├─README.md             README 文件
├─think                 命令行入口文件
~~~

> router.php用于php自带webserver支持，可用于快速测试
> 切换到public目录后，启动命令：php -S localhost:8888  router.php
> 上面的目录结构和名称是可以改变的，这取决于你的入口文件和配置参数。

## 命名规范

`ThinkPHP5`遵循PSR-2命名规范和PSR-4自动加载规范，并且注意如下规范：

### 目录和文件

*   目录不强制规范，驼峰和小写+下划线模式均支持；
*   类库、函数文件统一以`.php`为后缀；
*   类的文件名均以命名空间定义，并且命名空间的路径和类库文件所在路径一致；
*   类名和类文件名保持一致，统一采用驼峰法命名（首字母大写）；

### 函数和类、属性命名
*   类的命名采用驼峰法，并且首字母大写，例如 `User`、`UserType`，默认不需要添加后缀，例如`UserController`应该直接命名为`User`；
*   函数的命名使用小写字母和下划线（小写字母开头）的方式，例如 `get_client_ip`；
*   方法的命名使用驼峰法，并且首字母小写，例如 `getUserName`；
*   属性的命名使用驼峰法，并且首字母小写，例如 `tableName`、`instance`；
*   以双下划线“__”打头的函数或方法作为魔法方法，例如 `__call` 和 `__autoload`；

### 常量和配置
*   常量以大写字母和下划线命名，例如 `APP_PATH`和 `THINK_PATH`；
*   配置参数以小写字母和下划线命名，例如 `url_route_on` 和`url_convert`；

### 数据表和字段
*   数据表和字段采用小写加下划线方式命名，并注意字段名不要以下划线开头，例如 `think_user` 表和 `user_name`字段，不建议使用驼峰和中文作为数据表字段命名。

## 参与开发
请参阅 [ThinkPHP5 核心框架包](https://github.com/top-think/framework)。

## 版权信息

ThinkPHP遵循Apache2开源协议发布，并提供免费使用。

本项目包含的第三方源码和二进制文件之版权信息另行标注。

版权所有Copyright © 2006-2017 by ThinkPHP (http://thinkphp.cn)

All rights reserved。

ThinkPHP® 商标和著作权所有者为上海顶想信息科技有限公司。

更多细节参阅 [LICENSE.txt](LICENSE.txt)
