<?php
namespace backend\module\admin\controllers;
use yii\db\Query;
use yii\debug\panels\EventPanel;
use yii\web\Controller;

class UseranController extends Controller
{
    public function actionIndex()
    {
        return array('data'=>'user','msg'=>'数据分析');
    }
//    查看用户角色的分类
    public function actionUserrole()
    {
        $query = (new Query())
            ->select('*')
            ->from('user')
            ->where(['status'=>1])
            ->all();
        $root=[];
        $master=[];
        $teacher=[];
        $student=[];
        $parents=[];
        $list=[];
        for($i=0;$i<count($query);$i++)
        {
            switch ($query[$i]['role'])
            {
                case 1:{
                    array_push($root,$query[$i]['userid']);
                    $list[0]['name']='管理员';
                    $list[0]['num']=count($root);
                    break;
                }
                case 2:{
                    array_push($master,$query[$i]['userid']);
                    $list[1]['name']='校长';
                    $list[1]['num']=count($master);
                    break;
                }
                case 3:{
                    array_push($teacher,$query[$i]['userid']);
                    $list[2]['name']='教师';
                    $list[2]['num']=count($teacher);
                    break;
                }
                case 4:{
                    array_push($student,$query[$i]['userid']);
                    $list[3]['name']='学生';
                    $list[3]['num']=count($student);
                    break;
                }
                case 5:{
                    array_push($parents,$query[$i]['userid']);
                    $list[4]['name']='家长';
                    $list[4]['num']=count($parents);
                    break;
                }
                default:break;
            }
        }
        return array('data'=>$list,'msg'=>'角色数据');
    }
    public function actionUsersex()
    {
        $query = (new Query())
            ->select('*')
            ->from('user')
            ->where(['role'=>2])
            ->orWhere(['role'=>3])
            ->orWhere(['role'=>4])
            ->all();
        $master=[];
        $teacher=[];
        $student = [];
        $numM = [0,0,0];
        $numT= [0,0,0];
        $numS= [0,0,0];
//        计算性别的数量
        for($i=0;$i<count($query);$i++)
        {
            switch ($query[$i]['role'])
            {
                case 2:{
//                    校长用户
                    if($query[$i]['sex']==1)
                    {
                        $m['sex']='男';
                        $m['num']=$numM[0]+1;
                        $numM[0]++;
                    }
                    else if($query[$i]['sex']==2)
                    {
                        $m['sex']='女';
                        $m['num']=$numM[1]+1;
                        $numM[1]++;
                    }
                    else
                    {
                        $m['sex']='未知';
                        $m['num']=$numM[2]+1;
                        $numM[2]++;
                    }
                    array_push($master,$m);
                    break;
                }
                case 3:{
                    if($query[$i]['sex']==1)
                    {
                        $t['sex']='男';
                        $t['num']=$numT[0]+1;
                        $numT[0]++;
                    }
                    else if($query[$i]['sex']==2)
                    {
                        $t['sex']='女';
                        $t['num']=$numT[1]+1;
                        $numT[1]++;
                    }
                    else
                    {
                        $t['sex']='未知';
                        $t['num']=$numT[2]+1;
                        $numT[2]++;
                    }
                    array_push($teacher,$t);
                    break;
                }
                case 4:{
                    if($query[$i]['sex']==1)
                    {
                        $s['sex']='男';
                        $s['num']=$numS[0]+1;
                        $numS[0]++;
                    }
                    else if($query[$i]['sex']===2)
                    {
                        $s['sex']='女';
                        $s['num']=$numS[1]+1;
                        $numS[1]++;
                    }
                    else
                    {
                        $s['sex']='未知';
                        $s['num']=$numS[2]+1;
                        $numS[2]++;
                    }
                    array_push($student,$s);
                    break;
                }
                default:break;
            }
        }
//        return array('data'=>$master,'msg'=>'性别数据');
        return array('data'=>[$master,$teacher,$student],'msg'=>'性别数据');

    }
}