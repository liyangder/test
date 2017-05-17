<?php

namespace Common\Rbac;


class Rbac
{
    /**
     * 获取用户具有的权限
     * @param $user_id
     * @return array 含有全部权限的数组
     */
    public function getActionList($user_id){
        //返回数据
        //['back/brand/list','back/brand/add']
        $model = M('RoleAdmin');
        $rows = $model
            ->field('a.node action, c.node controller, m.node module')
            ->alias('ra')
            ->join('join __ROLE_ACTION__ rac On ra.role_id=rac.role_id')
            ->join('left join __ACTION__ a ON rac.action_id=a.id')
            ->join('left join __ACTION__ c ON a.parent_id=c.id')
            ->join('left join __ACTION__ m ON c.parent_id=m.id')
            ->where(['ra.admin_id'=>$user_id])
            ->select();
        return array_map(function($row){
            return $row['module'].'/'.$row['controller'].'/'.$row['action'];
        },$rows);
    }

    /**
     * 检测当前用户是否有权限
     */
    public function checkAccess(){
        //获取当期的路由
        $route = MODULE_NAME .'/'. CONTROLLER_NAME .'/'.ACTION_NAME;
        $route = strtolower($route);

        //判断是否需要认证
        if(in_array($route,C('NON_AUTH_ACTION'))){
            //不需要认证 ,可以直接执行
            return true;
        }

        //判断是否登录
        if(!$admin = session('admin')){
            //没有登录
            redirect(U('Back/Admin/login'));
        }

        //登录成功  看是否为超级管理员
        $count = M('RoleAdmin')
            ->alias('ra')
            ->join('left join __ROLE__ r On ra.role_id=r.id')
            ->where(['r.is_super'=>'1','ra.admin_id'=>$admin['id']])
            ->count();
        if ($count>0){
            //是超级管理员
            return true;
        }

        //判断动作是否需要授权
        if (in_array($route,C('ALLOW_ACTION'))){
            //无需要授权
            return true;
        }

        //判断是否有当前权限
        $action_list = $this->getActionList($admin['id']);
        if(in_array($route,$action_list)){
            return true;
        }

        //没有授权 重定向到主页
        redirect(U('Back/Manage/dashboard'));
    }

}



