# cronsys

###介绍[brief]

cronsys项目是一个关于crontab任务分发工具。
不用在Linux下配置crontab命令，也解决了多任务分布在多服务器上时配置过多，管理不宜的问题。
此系统目的是将分布在各个服务器上的crontab收集起来，统一部署到一台服务器上，这样便于管理。

###特点[character]

*日志记录，记录每个crontab每次执行的时间，消耗时常，debug日志，执行状态
*执行前轮询探测各个work端（也就是各个接受crontab命令端服务器）的IP是否畅通，剔除僵尸IP服务器
*支持高并发，所以crontab命令高数量级的应用也不用担心（系统中应用了python的多进程的特性）


###技术应用[Application Technology]

php python gearman mysql

###安装[Install]

1.目录copy到你的web目录下
2.运行Install/gearman/install.sh 脚本（运行前看看install有没有执行权限，没有执行chmod +x install.sh）
3.将Install/database.sql 导入mysql中 （如果没有安装mysql，请自行安装）
4.看看服务器是否安装php python mysl,没有安装，请自行安装，这里单独介绍

###部署[Deploy]

Cron目录是整个项目核心
逐一介绍一下

client.py -- 为客户端代码，主要是负责从数据库中获取所有要crontab命令，并过滤出目前可以执行的crontab命令发送给work端
work.py -- 为work端代码，主要服务接受来自client端的命令，并且执行，还有行为日志逻辑也在这里完成。
CronFilter.py -- 过滤出目前可以执行的crontab命令，主要为client.py 调用
MyLog.py -- 为系统记录日志代码（文本日志，主要是一些僵尸IP日录和一切异常监控）
run.log -- 系统日志

###如何部署呢？

(1)在linux的crontab中添加 */1 * * * * python xxx/cronsys/Gron/Gearman/client.py   
(2)单机部署的话，直接执行  nohup python xxx/cronsys/Gron/Gearman/woker.py &  
如果worker端多机器部署时，将woker.py copy到你的目标服务上，修改这行代码gm_work = gearman.GearmanWorker(['127.0.0.1:4730'])
中的IP与PORT为gearman部署的服务器IP与端口

注释：xxx为你的web目录

