create database shop6 charset=utf8;

use shop6;

-- 品牌
create table kang_brand
(
  id int unsigned auto_increment,
  title varchar(32) not null default '' comment '名称',
  logo varchar(255) not null default '' comment 'LOGO',
  site varchar(255) not null default '' comment '官网',
  sort_number int not null default 0 comment '排序',

  created_at int not null default 0 comment '创建时间',
  updated_at int not null default 0 comment '修改时间',
  primary key (id),
  key (title),
  key (sort_number)
) charset=utf8 comment = '品牌';


-- 管理员
create table kang_admin
(
  id int unsigned auto_increment,
  username varchar(32) not null default '' comment '管理员',
  password varchar(64) not null default '' comment '密码',
  salt varchar(12) not null default '' comment '盐',

  created_at int not null default 0 comment '创建时间',
  updated_at int not null default 0 comment '修改时间',

  primary key (id),
  index (username),
  index (password)
) charset=utf8 comment='管理员';

insert into kang_admin values (null, 'han', md5(concat('hellokang', '9a82')), '9a82', unix_timestamp(), unix_timestamp());
insert into kang_admin values (null, 'zhong', md5(concat('hellokang', '18e6')), '18e6', unix_timestamp(), unix_timestamp());
insert into kang_admin values (null, 'kang', md5(concat('hellokang', '9a82')), '9a82', unix_timestamp(), unix_timestamp());

-- 角色表
create table kang_role
(
  id int unsigned auto_increment,
  title varchar(32) not null default '' comment '角色名称',
  remark varchar(255) not null default '' comment '备注',

  created_at int not null default 0 comment '创建时间',
  updated_at int not null default 0 comment '修改时间',
  primary key (id)
  ) charset=utf8 comment='角色';
alter table kang_role add column is_super boolean not null default 0 comment '是否为超级管理员' after remark; -- boolean eq tinyint(1)


-- 角色管理员关联
create table kang_role_admin
(
  id int UNsigned auto_increment,

  role_id int unsigned not null default 0 comment '角色',
  admin_id int unsigned not null default 0 comment '管理员',

  created_at int not null default 0 comment '创建时间',
  updated_at int not null default 0 comment '修改时间',

  primary key (id),
  unique key (role_id, admin_id)
) charset=utf8 comment '角色管理员关联';

-- 动作表
create table kang_action
(
  id int unsigned auto_increment,
--   action varchar(32) not null default '' comment '动作',
--   controller varchar(32) not null default '' comment '控制器',
--   module varchar(32) not null default '' comment '模块',
  node varchar(32) not null default '' comment '节点', -- 模块, 控制器, 动作
  parent_id int unsigned not null default 0 comment '上级节点',
  level tinyint unsigned not null default 0 comment '节点级别', -- 模块1, 控制器2, 动作3
  title varchar(32) not null default '' comment '描述',

  created_at int not null default 0 comment '创建时间',
  updated_at int not null default 0 comment '修改时间',

  primary key (id),
  key (parent_id)
  ) charset=utf8 comment='动作';

-- 角色与动作关联
create table kang_role_action
(
  id int unsigned auto_increment,
  role_id int unsigned not null default 0 comment '角色',
  action_id int unsigned not null default 0 comment '动作',
  created_at int not null default 0 comment '创建时间',
  updated_at int not null default 0 comment '修改时间',

  primary key (id),
  unique key (role_id, action_id)
) charset=utf8 comment='角色与动作关联';