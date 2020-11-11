<?php
namespace backend\module\admin\controllers;
use yii\db\Query;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionIndex()
    {
        return array('data'=>'111','msg'=>'管理员用户管理');
    }
    public function PasswordDecry($password,$encryptedData="zhouqing")
    {
        $de = \Yii::$app->getSecurity()->decryptByPassword(base64_decode($password),$encryptedData);
        return $de;
    }
    public function PasswordEncry($password,$encryptedData="zhouqing")
    {
        $en = \Yii::$app->getSecurity()->encryptByPassword($password,$encryptedData);
        return base64_encode($en);
    }
    //    计算userid
    public function Num()
    {
        $num =(new Query())
            ->select('*')
            ->from('user')
            ->max('userid');
        return $num;
    }
//    自定义密码
    public function Defaultpass($flag)
    {
        switch ($flag){
            case 1:$pass = 'root@123';break;
            case 2:$pass = 'master@123';break;
            case 3:$pass = 'teacher@123';break;
            case 4:$pass = 'student@123';break;
            case 5:$pass = 'parents@123';break;
            default:break;
        }
        $pass =$this->PasswordEncry($pass);
        return $pass;
    }
//    查看用户：
//参数:flag: 1：管理员 :2:校长 3：教师 4：学生 5：家长
    public function actionQueryuser()
    {
        $request =\Yii::$app->request;
        $flag = $request->post('flag');
        $query = (new Query())
            ->select('*')
            ->from('user')
            ->where(['role'=>$flag])
            ->all();
        $list =[];
        for($i=0;$i<count($query);$i++)
        {
            $list[$i]['userid']=$query[$i]['userid'];
            $list[$i]['no']=$query[$i]['no'];
            $list[$i]['username']=$query[$i]['username'];
            $list[$i]['role']=$query[$i]['role'];
            $list[$i]['password']=$this->PasswordDecry($query[$i]['password']);
            $list[$i]['token']=$query[$i]['token'];
            $list[$i]['ip']=$query[$i]['ip'];
            $list[$i]['status']=$query[$i]['status'];
        }
        return array('data'=>$list,'msg'=>'查找结果');
    }
//    重置密码:按照身份初始化密码
//    初始密码为role@123,
//校长：master@123；教师teacher@123;学生：student@123;管理员：root@123,家长：parents@123
    public function actionResetpassword()
    {
        $request = \Yii::$app->request;
        $flag = $request->post('flag');
        $pass = $this->Defaultpass($flag);
        $id = $request->post('userid');
        $newpass = $this->PasswordEncry($pass);
        $updateU = \Yii::$app->db->createCommand()->update('user', ['password' => $newpass], ['userid'=>$id])->execute();
        if($updateU)
        {
            return array('data'=>$newpass,'msg'=>'重置密码！');
        }
    }
//    删除用户
    public function actionDeleteperson()
    {
        $request = \Yii::$app->request;
        $flag = $request->post('flag');
        $id = $request->post('userid');
        $num = (new Query())
            ->select('*')
            ->from('user')
            ->where(['userid'=>$id])
            ->one();
        if($num['status']==0)
        {
            $updateU = \Yii::$app->db->createCommand()->delete('user', ['userid'=>$id,'role'=>$flag])->execute();
        }
        else if($num['status']==1)
        {
            $updateU = \Yii::$app->db->createCommand()->update('user', ['status' => 0], ['userid'=>$id,'role'=>$flag])->execute();
        }
        if($updateU)
        {
            return array('data'=>$updateU,'msg'=>'删除用户！');
        }
    }

//    添加用户
//参数：flag；身份选择
    public function actionAddperson()
    {
        $request = \Yii::$app->request;
        $flag = $request->post('flag');
        $no = $request->post('no');
        $username = $request->post('username');
        $query =(new Query())
            ->select('*')
            ->from('user')
            ->where(['no'=>$no])
            ->andWhere(['role'=>$flag])
            ->one();
        if($query)
        {
            return array('data'=>$query,'msg'=>"此工号已存在");
        }
        else
        {
            $id = $this->Num()+1;
            $pass = $this->Defaultpass($flag);
            $newpass = $this->PasswordEncry($pass);
            $insertU = \Yii::$app->db->createCommand()->insert('user',
                array('userid'=>$id,'no'=>$no,'username'=>$username,'role'=>$flag,'password'=>$newpass,'token'=>"",'ip'=>'','status'=>1))->execute();
            if($insertU)
            {
                return array('data'=>$insertU,'msg'=>"添加成功！");
            }
            else
            {
                return array('data'=>$insertU,'msg'=>"添加失败！");
            }
        }
    }
//    批量导入
    public function actionImportexcel()
    {
        $request = \Yii::$app->request;
        $data = $request->post('sdata');
        $data = json_decode($data,true);
        $flag = $request->post('flag');
        for($i=0;$i<count($data);$i++)
        {
            $no = isset($data[$i]['no'])?$data[$i]['no']:"";
            $name = isset($data[$i]['name'])?$data[$i]['name']:"";
            $password = $this->Defaultpass($flag);
            $query = (new Query())
                ->select("*")
                ->from('user')
                ->where(['no'=>$no])
                ->andWhere(['role'=>$flag])
                ->one();
            $id = $this->Num()+1;
            if($query == null)
            {
                $insertU = \Yii::$app->db->createCommand()->insert('user',array('userid'=>$id,'username'=>$name,
                    'password'=>$password,'role'=>$flag,'status'=>1,'no'=>$no))->execute();
                if ($insertU)
                {

                }
                else
                {
                    return array("data"=>$i,"msg"=>$data[$i]."导入失败！");
                }
            }
        }
        return array("data"=>$data,"msg"=>"导入成功");
    }

}