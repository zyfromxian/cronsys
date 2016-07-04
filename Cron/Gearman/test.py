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
