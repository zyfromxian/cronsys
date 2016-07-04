<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {

    public function listTask()
    {
    	$taskModel = new \Home\Model\TaskModel();
    	$taskList = $taskModel->order('create_time desc')->select();
        
        foreach($taskList as $key => $value)
        {
            $taskList[$key]['last_runtime'] = $value['last_runtime'] ? $value['last_runtime'] : '还未执行过';
            $taskList[$key]['is_running']   = $value['is_running'] ? '执行中' : '空闲中';
            $taskList[$key]['is_open']      = $value['is_open'] ? '开启中' : '关闭中';
        }

        $this->assign('taskList', $taskList);
        $this->display();
    }

    public function addTask()
    {
        if($_POST)
        {
            $desc       = I('post.desc');
            $address    = I('post.address');
            $cmd        = $_POST['cmd'];
            $isOpen     = I('post.is_open');

            if(empty($desc))
            {
                exit('desc err');
            }

            if(empty($address))
            {
                exit('address err');
            }

            if(empty($cmd))
            {
                exit('cmd err');
            }

            if(!in_array($isOpen, array(0, 1)))
            {
                exit('is_open err');
            }

            $insert = array();
            $insert['desc']         = $desc;
            $insert['address']      = $address;
            $insert['cmd']          = $cmd;
            $insert['create_user']  = 'admin';
            $insert['create_time']  = time();
            $insert['is_running']   = 0;
            $insert['is_open']      = $isOpen;

            $taskModel = new \Home\Model\TaskModel();
            $taskModel->add($insert);
            $this->success('添加成功', '?m=home&a=listTask');
        }
        else
        {
            $this->display();
        }
    }

    public function deleteTask()
    {
        $taskId = I('get.task_id');
        if(empty($taskId))
        {
            exit('task_id err');
        }

        $taskModel = new \Home\Model\TaskModel();
        $ret = $taskModel->where("id=$taskId")->delete();
        $this->success('删除成功', '?m=home&a=listTask');
    }

    public function modifyTask()
    {
        $taskId = I('get.task_id');
        if(empty($taskId))
        {
            exit('task_id err');
        }
        
        $taskModel = new \Home\Model\TaskModel();

        if($_POST)
        {
            $desc = I('post.desc');
            $address = I('post.address');
            $cmd = $_POST['cmd'];
            $isOpen = I('post.is_open');

            if(empty($desc))
            {
                exit('desc err');
            }

            if(empty($address))
            {
                exit('address err');
            }

            if(empty($cmd))
            {
                exit('cmd err');
            }

            if(!in_array($isOpen, array(0, 1)))
            {
                exit('is_open err');
            }

            $update = array();
            $update['desc']     = $desc;
            $update['address']  = $address;
            $update['cmd']      = $cmd;
            $update['is_open']  = $isOpen;
            $ret = $taskModel->where("id=$taskId")->save($update);
            $this->success('修改成功', '?m=home&a=listTask');
        }
        else
        {
            $task = $taskModel->where("id=$taskId")->limit(1)->select();
            $this->assign('task', $task[0]);
            $this->display();
        }
    }

    public function runRecord()
    {
        $taskId = I('get.task_id');
        if(empty($taskId))
        {
            exit('task_id err');
        }

        $recordModel = new \Home\Model\RunRecordModel();
        $recordList = $recordModel->where("task_id=$taskId")->order('runtime desc')->select();

        foreach ($recordList as $key => $value)
        {
            $recordList[$key]['runtime']    = date('Y-m-d H:i:i', $value['runtime']);
            $recordList[$key]['run_status'] = $value['run_status'] ? '成功' : '失败';
        }

        $this->assign('recordList', $recordList);
        $this->display();
    }
}