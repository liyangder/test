<?php


/**
 * @param $route
 * @param array $param
 * @param $field
 * @param array $order_param, ['order_field’=>’title’, ‘order_type’=>’desc’]
 */
function UOrder($route, $param=[], $field, $order_param=[])
{
    // 判断要为当前字段生成何种链接地址
    // 增加了排序字段参数
    $param['order_field']  = $field;
    // 需要确定排序方式
//    当前的排序没有按照该字段: 升序
//    当前按照该字段降序排序: 升序
//    当前按照该字段升序排序: 降序
    $param['order_type'] = ($order_param['order_field']==$field && $order_param['order_type']=='asc') ? 'desc' : 'asc';

    return U($route, $param);
}

/**
 * @param $field
 * @param array $order_param
 * @return string
 */
function ClassOrder($field, $order_param=[])
{
//    '', 'asc', 'desc'
//        如果按照该字段排序, 再去排序方式, 选择返回asc或desd. 否则直接返回空字符串
        return $order_param['order_field'] == $field ? ($order_param['order_type']=='asc'? 'asc':'desc') : '';
}