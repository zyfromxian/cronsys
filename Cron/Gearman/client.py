#-*- coding:utf-8 -*-

import gearman
import json
import MySQLdb
import socket
import os
import sys
import datetime
import multiprocessing
import CronFilter
import MyLog

"""
获取当前日期
"""
date = datetime.datetime.now().strftime("%Y-%m-%d %H:%M:%S")

"""
方法:检测IP PORT 是否畅通
"""
def check_ip_port(address) :
	(ip, port) = address.split(":")
	s = socket.socket(socket.AF_INET,socket.SOCK_STREAM)
	s.settimeout(1)
	try :
		s.connect((ip, int(port)))
		return True
	except Exception, e:
		"""
		记录不通的IP:PORT日志
		"""
		MyLog.run_log('[CLIENT][IP:PORT]['+ date +'] ' + ip + ':' + port + ' Unavailable')
		return False

"""
方法:检测命令是否可以执行
"""
def check_cmd_can_run(data) :
	ret = []
	for value in data :
		cmd = value[2]
		status = CronFilter.isdo(cmd)
		if status :
			ret.append(value)
	return ret

def run_work(address, data) :

	pid = os.getpid()
	print '子进程ID:' + str(pid)
	
	"""
	检测IP:PORT 是否正常
	"""
	result = check_ip_port(address)
	if result :

		"""
		更新马上要运行的cron的状态
		"""
		conn, cursor = connMysql()
		for value in data :
			taskId = value[0]
			sql = 'UPDATE task SET is_running = %s WHERE id = %s'
			cursor.execute(sql, (1, taskId))

		conn.commit()
		cursor.close()
		conn.close()

		"""将数据json化"""
		str_data 	= json.dumps(data)
		gm_client 	= gearman.GearmanClient([address])
		gm_request 	= gm_client.submit_job('cron', str_data, background=False)
		result_data = gm_request.result


def connMysql() :
	conn = MySQLdb.connect(host = '127.0.0.1', user = 'root', passwd = '', db = 'cron', port = 3306)
	cursor = conn.cursor()
	return conn, cursor

try:
	"""
	从数据库中获取执行列表
	"""
	conn, cursor = connMysql()

	sql = 'SELECT id,address,cmd FROM task WHERE is_open = 1'
	cursor.execute(sql)
	data = cursor.fetchall()

	"""
	检测cron命令是否可以执行
	"""
	data = check_cmd_can_run(data)
	if len(data) == 0:
		sys.exit(0)

	"""
	格式化数据，转化为以IP为键值的字典
	"""
	format_ret = dict()
	for value in data :
	    number 	= value[0]
	    address = value[1]
	    cmd 	= value[2]
	    if address not in format_ret :
	        format_ret[address] = []
	    format_ret[address].append([number, address, cmd])

	fpid = os.getpid()
	print '父进程ID:' + str(fpid)

	pool = multiprocessing.Pool()
	ret = []
	for k in format_ret :
		address = k

		"""
		防止大量的不通的IP导致进程卡死，所以改为并发执行
		"""
		pool.apply_async(run_work, args=(address, format_ret[address],))
	
	pool.close()
	pool.join()

	print 'All subprocesses done.'

except Exception, e:
	conn.rollback()
	"""
	记录ERR日志
	"""
	MyLog.run_log('[[CLIENT]][ERR]['+ date +'] ' + str(e) + "\n")

cursor.close()
conn.close()
