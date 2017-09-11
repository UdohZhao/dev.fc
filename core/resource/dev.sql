# 后台用户表
CREATE TABLE `admin_user`(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '后台用户主键id',
  `username` varchar(25) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `ctime` int(10) UNSIGNED NOT NULL COMMENT '时间',
  `type` tinyint(1) UNSIGNED NOT NULL COMMENT '类型？0>超级管理员，1>普通管理员',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '状态？0>正常，1>冻结',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
# 用户表
CREATE TABLE `user`(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户表主键id',
  `pid` int(11) UNSIGNED NOT NULL COMMENT '父id',
  `openid` varchar(50) NOT NULL COMMENT '微信openid',
  `nickname` varchar(50) NOT NULL COMMENT '昵称',
  `city` varchar(255) NOT NULL COMMENT '城市',
  `province` varchar(255) NOT NULL COMMENT '省份',
  `country` varchar(255) NOT NULL COMMENT '国家',
  `headimgurl` varchar(255) NOT NULL COMMENT '头像',
  `residue` int(10) UNSIGNED NOT NULL COMMENT '剩余金币',
  `push_money` decimal(14,2) UNSIGNED NOT NULL COMMENT '提成金额',
  `type` tinyint(1) UNSIGNED NOT NULL COMMENT '类型？0>普通用户，1>职员用户',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '状态？0>未申请提现，1>已申请提现',
  `code_status` tinyint(1) UNSIGNED NOT NULL COMMENT '编码状态？0>未使用，1>已使用',
  `pay_status` tinyint(1) UNSIGNED NOT NULL COMMENT '充值状态？0>未使用，1>已使用',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
# 职员信息表
CREATE TABLE `staffs`(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '职员信息表主键id',
  `uid` int(11) UNSIGNED NOT NULL COMMENT '关联用户表主键id',
  `cname` varchar(25) NOT NULL COMMENT '姓名',
  `phone` char(11) NOT NULL COMMENT '手机号码',
  PRIMARY KEY (`id`),
  KEY (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
# 文章付费表
CREATE TABLE `article_pay`(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章付费表主键id',
  `cover_path` varchar(255) NOT NULL COMMENT '封面',
  `title` varchar(255) NOT NULL COMMENT '标题',
  `content` varchar(50000) NOT NULL COMMENT '内容',
  `ctime` int(10) UNSIGNED NOT NULL COMMENT '发布时间',
  `reads` int(10) UNSIGNED NOT NULL COMMENT '阅读数',
  `likes` int(10) UNSIGNED NOT NULL COMMENT '点赞数',
  `comments` int(10) UNSIGNED NOT NULL COMMENT '评论数',
  `gold` int(10) UNSIGNED NOT NULL COMMENT '阅读金币',
  `type` tinyint(1) UNSIGNED NOT NULL COMMENT '类型？0>编码不支持，1>编码支持',
  `atype` tinyint(1) UNSIGNED NOT NULL COMMENT '文章类型？0>免费，1>付费',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '状态？0>隐藏，1>展示',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
# 文章付费关系表
CREATE TABLE `article_pay_relation`(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章付费关系表主键id',
  `apid` int(11) UNSIGNED NOT NULL COMMENT '关联文章付费表主键id',
  `uid` int(11) UNSIGNED NOT NULL COMMENT '关联用户表主键id',
  `ctime` int(10) UNSIGNED NOT NULL COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY (`apid`),
  KEY (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
# 文章评论表
CREATE TABLE `article_comment`(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '文章评论表主键id',
  `apid` int(11) UNSIGNED NOT NULL COMMENT '关联文章付费表主键id',
  `uid` int(11) UNSIGNED NOT NULL COMMENT '关联用户表主键id',
  `content` varchar(500) NOT NULL COMMENT '评价内容',
  `reply` varchar(500) NOT NULL COMMENT '作者回复',
  `ctime` int(10) UNSIGNED NOT NULL COMMENT '时间',
  `likes` int(10) UNSIGNED NOT NULL COMMENT '点赞数',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '状态？0>隐藏，1>展示',
  PRIMARY KEY (`id`),
  KEY (`apid`),
  KEY (`uid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
# 休闲娱乐表
CREATE TABLE `recreation`(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '休闲娱乐表主键id',
  `pid` int(11) UNSIGNED NOT NULL COMMENT '父id',
  `cname` varchar(50) NOT NULL COMMENT '名称',
  `sort` tinyint(3) UNSIGNED NOT NULL COMMENT '排序',
  `status` tinyint(1) UNSIGNED NOT NULL COMMENT '状态？0>隐藏，1>展示',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
# 娱乐图片视频表
CREATE TABLE `recreation_iv`(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '娱乐图片表主键id',
  `rid` int(11) UNSIGNED NOT NULL COMMENT '关联休闲娱乐表主键id',
  `path` varchar(255) NOT NULL COMMENT '路径',
  `ctime` int(10) UNSIGNED NOT NULL COMMENT '时间',
  `type` tinyint(1) UNSIGNED NOT NULL COMMENT '类型？0>图片，1>视频',
  PRIMARY KEY (`id`),
  KEY (`rid`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
# banner
CREATE TABLE `banner`(
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'banner主键id',
  `path` varchar(255) NOT NULL COMMENT '路径',
  `sort` tinyint(3) UNSIGNED NOT NULL COMMENT '排序',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;