#/bin/sh

yum install boost boost-devel boost-doc
yum install gperf
yum install libevent-devel
yum install libuuid-devel

wget https://launchpad.net/gearmand/1.2/1.1.12/+download/gearmand-1.1.12.tar.gz

tar -zxvf gearmand-1.1.12.tar.gz
cd gearmand-1.1.12

./configure --prefix=/usr/local/gearmand
make
make install

/usr/local/gearmand/sbin/gearmand -p 4730 -L 127.0.0.1 --log-file=/tmp/gearmand-4730.log --pid-file=/tmp/gearmand-4730.pid -d

####安装python-gearman######
easy_install gearman 

