
create database TRSSP;

create table sp_user(
    uid int unsigned auto_increment primary key,
    username varchar(45) not null default '',
    password varchar(32) not null default '',
    realname varchar(45) not null default '',
    subcom_id tinyint not null default 0,
    department varchar(100) not null default '',
    job varchar(45) not null default '',
    email varchar(100) not null default '',
    phone varchar(20) not null default '',
    level tinyint not null default '3' comment '1 管理员 2 高级用户 3普通用户'
);


create table sp_product(
    pdt_id int unsigned auto_increment primary key,
    pdt_name varchar(30) not null default '',
    pdt_version varchar(20) not null default ''
);


create table sp_pub(
    pub_id int unsigned auto_increment primary key,
    pub_title varchar(100) not null default '',
    pub_content text not null default '',

)

create table sp_subcompany(
    subcom_id int unsigned auto_increment primary key,
    subcom_name varchar(30) not null default '',
    subcom_pid int unsigned not null default '0'
);


create table sp_article(
    arc_id int unsigned auto_increment primary key,
    arc_title varchar(50) not null default '',
    arc_author varchar(20) not null default '',
    arc_type int not null default 0,
    arc_content text not null,
    arc_sort int unsigned not null default 10,
    update_time int unsigned not null default 0,
    create_time int unsigned not null default 0
);

create table sp_vultype(
    tid int unsigned auto_increment primary key,
    t_first varchar(30) not null default '',
    t_second varchar(30) not null default ''
);

create table sp_arc_vtype(
    arc_id int unsigned,
    tid int unsigned 
);