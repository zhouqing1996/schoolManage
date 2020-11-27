<?php
namespace backend\module\admin\controllers;
use yii\db\Query;
use yii\web\Controller;
use TCPDF;
class InfoController extends Controller
{
    public function actionIndex()
    {
        return array('data'=>[],'msg'=>'通知管理');
    }

    // 文件上传
    public function actionUploadfile()
    {
        $path = \Yii::$app->basePath;
        $filePath = $path.'/files/uploads/';
        if(!is_dir($filePath))
        {
            mkdir(iconv('utf-8','GBK',$filePath),0777,true);
        }
        $filename=$_FILES["file"]["name"];
        $fileName1 =explode('\\',$filename);
        $fileName1 = $fileName1[count($fileName1)-1];
        $fileName1 =explode('.',$fileName1);
        $fileName1 =$fileName1[0];
        $fileArr = explode('.',$filename);
        $tempName=$fileName1.date("YmdHis").".".$fileArr[1];
        move_uploaded_file($_FILES["file"]["tmp_name"], $filePath.$tempName);
        $file = array('filename' => 'filename','dir'=>'filedir' );
        $file['filename'] = $filename;
        $url=explode('schoolManage',$filePath.$tempName);
        $url='http://127.0.0.1/schoolManage'.$url[1];
        $file['dir'] = $url;
        return array("data"=>[$tempName,$file['filename'],$file['dir']],"msg"=>"上传成功");
    }
//    公告编号
    public function InfoNum()
    {
        return (new Query())
            ->select('*')
            ->from('info')
            ->max('id')+1;
    }
//    添加公告
    public function actionAddinfo()
    {
        $request = \Yii::$app->request;
        $name =$request->post('title');
        $content = $request->post('content');
        $file = $request->post('file');
        $ctime = date('Y-m-d H:i:s',time());
        $uid = $request->post('uid');
        $id = $this->InfoNum();
        if($file)
        {
            $insertinfo = \Yii::$app->db->createCommand()->insert('info',
                array('id'=>$id,'userid'=>$uid,'name'=>$name,'content'=>$content,'type'=>1,'ctime'=>$ctime,'status'=>1))->execute();
            for($i=0;$i<count($file);$i++)
            {
                $fname = $file[$i]['filename'];
                $fdir = $file[$i]['filedir'];
                $insertfile = \Yii::$app->db->createCommand()->insert('info_file',
                array('id'=>$id,'name'=>$fname,'dir'=>$fdir,'status'=>1))->execute();
            }
        }
        else
        {
            $insertinfo = \Yii::$app->db->createCommand()->insert('info',
                array('id'=>$id,'name'=>$name,'userid'=>$uid,'content'=>$content,'type'=>0,'ctime'=>$ctime,'status'=>1))->execute();
        }
        if($insertinfo)
        {
            return array('data'=>$id,'msg'=>'添加通知公告成功');
        }
    }
//    获取用户姓名
    public function UserName($id)
    {
        return (new Query())
            ->select('*')
            ->from('user')
            ->where(['userid'=>$id])
            ->one();
    }

//    查看通知
    public function actionLookinfo()
    {
        $request = \Yii::$app->request;
        $infoId = $request->post('infoId');
        $query = (new Query())
            ->select('*')
            ->from('info')
            ->where(['id'=>$infoId])
            ->one();
        $queryFile = (new Query())
            ->select('*')
            ->from('info_file')
            ->where(['id'=>$infoId])
            ->all();
        $list['id']=$query['id'];
        $list['name']=$query['name'];
        $list['content']=$query['content'];
        $list['ctime'] = $query['ctime'];
        $list['auth'] = $this->UserName($query['userid'])['username'];
        $list['type'] = $query['type'];
        if($query['type']==1)
        {
            for($i=0;$i<count($queryFile);$i++)
            {
                $list['file'][$i]['filename'] = $queryFile[$i]['name'];
                $list['file'][$i]['filedir'] = $queryFile[$i]['dir'];
            }
        }
        $list['status']=$query['status'];
        return array('data'=>$list,'msg'=>$infoId.'的详细内容');
    }
    public function Info($id)
    {
        $query = (new Query())
            ->select('*')
            ->from('info')
            ->where(['id'=>$id])
            ->one();
        $queryFile = (new Query())
            ->select('*')
            ->from('info_file')
            ->where(['id'=>$id])
            ->all();
        $list['id']=$query['id'];
        $list['name']=$query['name'];
        $list['content']=$query['content'];
        $list['ctime'] = $query['ctime'];
        $list['auth'] = $this->UserName($query['userid'])['username'];
        $list['type'] = $query['type'];
        if($query['type']==1)
        {
            for($i=0;$i<count($queryFile);$i++)
            {
                $list['file'][$i]['filename'] = $queryFile[$i]['name'];
                $list['file'][$i]['filedir'] = $queryFile[$i]['dir'];
            }
        }
        $list['status']=$query['status'];
        return $list;
    }
//    下载公告信息
    public function actionDownloadinfo()
    {
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $list = $this->Info($id);
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('Helloweba');
        $pdf->SetAuthor('zhouqing');
        $pdf->SetTitle($list['name']);
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, PHP');
        // 设置字体
        $pdf->setFont('stsongstdlight', '', 14);
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // 设置页眉和页脚信息
        $pdf->setPrintFooter(true);
        $pdf->setPrintHeader(true);
        // 设置默认等宽字体
        $pdf->SetDefaultMonospacedFont('courier');
        // 设置间距
        $pdf->SetMargins(15, 27, 15);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        // 设置分页
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);
        $pdf->AddPage();
        $pdf->SetFont('stsongstdlight', '', 20);
        $pdf->setTextColor(64, 64, 64);


        $pdf->Write(0, $list['name'], '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Ln(10);
        $pdf->SetFont('stsongstdlight', '', 14);
        $pdf->Write(0, $list['auth'], '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Write(0, $list['ctime'], '', 0, 'C', 1, 0, false, false, 0);
        $pdf->Ln(10);
//        $pdf->Write(0, $list['content'], '', 0, 'J', 1, 0, false, false, 0);
        $pdf->writeHTML($list['content']);
        $pdf->Ln(20);
        if($list['type']==1)
        {
            $pdf->SetFont('stsongstdlight', '', 14);
            $pdf->SetTextColor(238, 121, 66);
            $pdf->Write(0, '附件列表', '', 0, 'J', 1, 0, false, false, 0);
            $pdf->Ln(5);
            $pdf->setTextColor(64, 64, 64);
            for($i=0;$i<count($list['file']);$i++)
            {
                $pdf->Write(0, $list['file'][$i]['filename'], '', 0, 'J', 1, 0, false, false, 0);
                $pdf->Ln(3);
            }
        }
        $title = $list['id'];
        $path = \Yii::$app->basePath;
        $filePath = $path.'/files/downloads/';
        if(!is_dir($filePath))
        {
            mkdir(iconv('utf-8','GBK',$filePath),0777,true);
        }
        $path=$filePath.$title.'.pdf';
        ob_clean();
        $pdf->Output($path,'F');
        $url=explode('schoolManage',$path);
        $url='http://127.0.0.1/schoolManage'.$url[1];
        return array('data'=>[$url,$list['name']],'msg'=>'下载通知');
    }
//    获取全部的通知公告
    public function actionGetinfo()
    {
        $query = (new Query())
            ->select('*')
            ->from('info')
            ->all();
        $list = [];
        for($i=0;$i<count($query);$i++)
        {
            $list[$i]['id'] = $query[$i]['id'];
            $list[$i]['name'] = $query[$i]['name'];
            $list[$i]['content'] = $query[$i]['content'];
            $ctime = explode(' ',$query[$i]['ctime']);
            $list[$i]['ctime'] = $ctime[0];
            $list[$i]['userid'] = $query[$i]['userid'];
            $list[$i]['status'] = $query[$i]['status'];

        }
        return array('data'=>$list,'msg'=>'全部通知公告');
    }
//    删除公告
    public function actionDelinfo()
    {
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $del1 = \Yii::$app->db->createCommand()->update('info',['status'=>0],['id'=>$id])->execute();
        $del2 = \Yii::$app->db->createCommand()->update('info_file',['status'=>0],['id'=>$id])->execute();
        if($del1&&$del2)
        {
            return array('data'=>[$del1,$del2],'msg'=>'删除公告成功');
        }
        else
        {
            return array('data'=>[$del1,$del2],'msg'=>'已删除公告成功');
        }
    }
    //    删除班级信息
    public function actionChangeinfo()
    {
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $del1 = \Yii::$app->db->createCommand()->update('info',['status'=>1],['id'=>$id])->execute();
        $del2 = \Yii::$app->db->createCommand()->update('info_file',['status'=>1],['id'=>$id])->execute();
        if($del1&&$del2)
        {
            return array('data'=>[$del1,$del2],'msg'=>'恢复公告成功');
        }
        else
        {
            return array('data'=>[$del1,$del2],'msg'=>'已恢复公告成功');
        }
    }
    //    删除班级信息
    public function actionDel()
    {
        $request = \Yii::$app->request;
        $id = $request->post('id');
        $del1 = \Yii::$app->db->createCommand()->delete('info',['id'=>$id])->execute();
        $del2 = \Yii::$app->db->createCommand()->delete('info_file',['id'=>$id])->execute();
        if($del1&&$del2)
        {
            return array('data'=>[$del1,$del2],'msg'=>'删除公告成功');
        }
        else
        {
            return array('data'=>[$del1,$del2],'msg'=>'已删除公告成功');
        }
    }
//    附件信息
    public function actionGetfile()
    {
        $query = (new Query())
            ->select('*')
            ->from('info_file')
            ->where(['status'=>1])
            ->all();
        return array('data'=>$query,'msg'=>'全部的文件');
    }
}
