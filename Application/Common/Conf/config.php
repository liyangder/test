<?php
return array(
	//'配置项'=>'配置值'
    'LOAD_EXT_CONFIG'   =>  'dbconfig',
    'ACTION_SUFFIX'         =>  'Action', // 操作方法后缀
    'SHOW_PAGE_TRACE'   =>'true',

    //授权认证的配置
    'NON_AUTH_ACTION'=>['back/admin/login', 'home/admin/list',],
    'ALLOW_ACTION'=>['back/manage/dashboard',],

);