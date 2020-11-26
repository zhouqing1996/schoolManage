<?php
namespace backend\module\admin\controllers;
use yii\db\Query;
use yii\web\Controller;

class ClassinfoController extends Controller
{
    public function actionIndex()
    {
        return array('data'=>[],'msg'=>'管理员班级管理');
    }
    public function actionClassinfo()
    {
        $query = (new Query())
            ->select('*')
            ->from('class')
            ->all();
        return array('data'=>$query,'msg'=>'全部的班级信息');
    }
    public function classNum()
    {
        return (new Query())
            ->select('*')
            ->from('class')
            ->max('id');
    }
//    添加班级
    public function actionAddclass()
    {
        $request = \Yii::$app->request;
        $classid = $request->post('id');
        $classname = $request->post('name');
        $query = (new Query())
            ->select('*')
            ->from('class')
            ->where(['classid'=>$classid])
            ->one();
        if($query)
        {
            return array('data'=>$query,'msg'=>'该班级已存在！');
        }
        else
        {
            $id = $this->classNum()+1;
            $add = \Yii::$app->db->createCommand()->insert('class',array('id'=>$id,'classid'=>$classid,
                'classname'=>$classname,'status'=>1))->execute();
            if($add)
            {
                return array('data'=>1,'msg'=>'添加班级成功');
            }
            else
            {
                return array('data'=>1,'msg'=>'已添加班级成功');
            }
        }
    }
//    删除班级信息
    public function actionDelclass()
    {
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $del = \Yii::$app->db->createCommand()->update('class',['status'=>0],['id'=>$id])->execute();
        if($del)
        {
            return array('data'=>$del,'msg'=>'删除班级成功');
        }
        else
        {
            return array('data'=>$del,'msg'=>'已删除班级成功');
        }
    }
    //    删除班级信息
    public function actionChangeclass()
    {
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $del = \Yii::$app->db->createCommand()->update('class',['status'=>1],['id'=>$id])->execute();
        if($del)
        {
            return array('data'=>$del,'msg'=>'恢复班级成功');
        }
        else
        {
            return array('data'=>$del,'msg'=>'已恢复班级成功');
        }
    }
    //    删除班级信息
    public function actionDel()
    {
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $del = \Yii::$app->db->createCommand()->delete('class',['id'=>$id])->execute();
        if($del)
        {
            return array('data'=>$del,'msg'=>'删除班级成功');
        }
        else
        {
            return array('data'=>$del,'msg'=>'已删除班级成功');
        }
    }
}
