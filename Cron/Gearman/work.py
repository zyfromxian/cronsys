#-*- coding:utf-8 -*-

import gearman
import time
import json
import multiprocessing
import random
import os
import commands
import MySQLdb
import datetime
import MyLog

"""
解析crontab中的命令
"""
def parse_crontab_cmd(cmd) :
	str_cmd = ''
	conf_length = 5
	tmp_list = cmd.split(' ')
	counter = 1
	for val in tmp_list:
		if counter > 5 :
			str_cmd += val + str(' ')
		counter += 1
	return str_cmd

"""
方法:执行
"""
def run_work(item) :

	print 'Run task %s (%s)...' % (item[0], os.getpid())

	task_id = item[0]
	cmd     = parse_crontab_cmd(item[2])

	"""
	获取当前日期
	"""
	date = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")

	"""
	记录程序执行开始时间
	"""
	start = time.time()

	"""
	执行cron命令
	"""
	run_status, output = commands.getstatusoutput(cmd)
	time.sleep(60)
	
	if run_status == 0 :
		run_status = 1
	else :
		run_status = 0

	"""
	记录程序执行完成时间
	"""
	end = time.time()

	"""计算执行时间"""
	use_time = end - start

	current_time = int(time.time())
	try:
		conn = MySQLdb.connect(host = '127.0.0.1', user = 'root', passwd = '', db = 'cron', port = 3306)
		cursor = conn.cursor()

		"""
		更新主表
		"""
		sql = 'UPDATE task SET is_running = %s , last_runtime = %s WHERE id = %s'
		ret = cursor.execute(sql, (0, current_time, task_id))

		"""
		添加执行日志
		"""
		sql = 'INSERT INTO run_record (task_id, runtime, run_status, use_time, err_msg) VALUES (%s, %s, %s, %s, %s)'
		ret = cursor.execute(sql, (task_id, current_time, run_status, use_time, output))
		
		conn.commit()
		cursor.close()
		conn.close()
		
	except Exception, e:
		conn.rollback()
		"""
		记录ERR日志
		"""
		MyLog.run_log('[[WORK]][ERR]['+ date +'] ' + str(e) + "\n")
		
"""
方法:任务
"""
def task_callback(gearman_work, gearman_job) :
	
	print 'Parent process %s.' % os.getpid()

	data = json.loads(gearman_job.data)
	"""
	建立进程
	"""
	for item in data :
		p = multiprocessing.Process(target=run_work, args=(item,))
		p.start()

	pool.close()
	return gearman_job.data


gm_work = gearman.GearmanWorker(['127.0.0.1:4730'])
gm_work.register_task('cron', task_callback)
gm_work.work()
