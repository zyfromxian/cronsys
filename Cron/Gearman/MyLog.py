#-*- coding:utf-8 -*-

"""
记录运行日志
"""
def run_log(message):
	f = open('run.log', 'ab')
	f.write(message + "\n")
	f.close()

"""
记录错误日志
"""
def err_log(message):
	f = open('err.log', 'ab')
	f.write(message + "\n")
	f.close()
