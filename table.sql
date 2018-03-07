
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
    create_time int unsigned not null default 0,
    user_id int unsigned not null default 0,
    attach_name varchar(40) not null default '',
    attach_path varchar(100) not null default ''
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

create table sp_attachment(
    arc_id int unsigned not null default 0,
    attachment_path varchar(50) not null default ''
);

create table sp_project(
    pro_id int unsigned auto_increment primary key,
    pro_subcom_id tinyint not null default 0,
    pro_name varchar(50) default '',
    pro_locate_province varchar(10) not null  default '',
    pro_locate_city varchar(20) not null default '',
    pro_locate_district varchar(20) not null default '',
    pro_product_id int,
    pro_level varchar(20) not null default '',
    pro_net_type varchar(5) not null default '',
    pro_url varchar(200) not null default '',
    pro_remark varchar(80) not null default ''
);


create table sp_arc_pdt(
    arc_id int unsigned not null default 0,
    pdt_id int unsigned not null default 0
);

create table sp_vul(
    vul_id int unsigned auto_increment primary key,
    pro_name varchar(100) not null default '',
    vul_title varchar(30) not null default '',
    pdt_id int unsigned not null default 0,
    vultype_id int unsigned not null default 0,
    vul_level varchar(10) not null default '',
    vul_desc varchar(80) not null default '',
    vul_url varchar(200) not null default '',
    vul_detail text,
    vul_state varchar(10) not null default '',
    vul_userid int unsigned not null default 0,
    attach_name varchar(40) not null default '',
    attach_path varchar(100) not null default '',
    update_time int unsigned not null default 0,
    create_time int unsigned not null default 0
);


