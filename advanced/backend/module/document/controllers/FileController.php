<?php
namespace backend\module\document\controllers;

// require_once __DIR__.'/../../../vendor/autoload.php';
use Yii;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Style;
// use PhpOffice\PhpWord\TemplateProcessor;


use yii\web\Controller;
use yii\web\Response;
use yii\web\Request;
use yii\data\Pagination;
use yii\db\Query;
use common\models\OaFlowInfo;
use common\models\OaList10;
use common\models\OaList;
use common\models\OaList1;
use common\models\OaList2;
use common\models\OaList3;
use common\models\OaTest;
use common\models\Upload;
use yii\web\UploadedFile;
use common\models\OaContactInfo;
header('Access-Control-Allow-Origin:*');
header("Access-Control-Allow-Headers:Origin,X-Requested-With,Content-type,Accept");

// <!-- 文件相关操作 -->
class FileController extends Controller
{
	public function actionIndex()
	{
        $request = \Yii::$app->request;
        $s = $request->post('doc');
        $dir = \Yii::$app->basePath;//物理路径E:\Net\xampp\htdocs\OA\advanced\backend
        $dirr = \Yii::$app->request->hostInfo;//域名地址http://127.0.0.1
        $d = dirname(Yii::$app->BasePath);//项目路径E:\Net\xampp\htdocs\OA\advanced
        $url = \Yii::$app->request->url;// /OA/advanced/backend/web/index.php/document/file/index
		// $mmm=dirname(__DIR__).'/../..';
        $pwd = getcwd();
        $time = getdate();
        return array("data"=>[$s,$dir,$dirr,$d,$url,$pwd,$time],"msg"=>"文件相关操作");
	}
    // 文件上传
    public function actionUploadfile()
    {
        $menu = str_replace('\\','/',dirname(Yii::$app->BasePath));
        $upload_path =$menu.'/'.@backend."/Uploads/";
        $filename=$_FILES["file"]["name"];
        $fileArr = explode('.',$filename);
        // $tempName=date("YmdHis").rand(1,100).".".$fileArr[1];
        $tempName=date("YmdHis").".".$fileArr[1];
        move_uploaded_file($_FILES["file"]["tmp_name"], $upload_path.$tempName);
        // $file = array('filename' => 'filename','dir'=>'filedir' );
        $file = array('filename' => 'filename','dir'=>'filedir' );
        $file['filename'] = $filename;
        $file['dir'] = $upload_path.$tempName;
        // return array("data"=>[$menu,$upload_path,$filename,$fileArr,$tempName,$file],"msg"=>"上传成功");
        return array("data"=>[$tempName,$file['filename'],$file['dir']],"msg"=>"上传成功");
    }
    // 上传的文件下载
    public function actionDownloadlist()
    {
        $request = \Yii::$app->request;
        $procname = $request->post('procname');
        $userid = $request->post('userid');
        $procid = $request->post('procid');
        $list = (new Query())->select('listid')->from('oa_list')->andWhere(['listname' => $procname])->one();
        if($list['listid'] == 1 )
        {
            $query1 = (new Query())
                    ->select('*')
                    ->from('oa_list1')
                    ->andWhere(['userid' => $userid])
                    ->andWhere(['procid' => $procid])
                    ->andWhere(['isvaild' => 1])
                    ->one();
            $filedir = $query1['filedir'];
            $fileArr = explode('Uploads/',$filedir);
            $filedir1 = $fileArr[1];
            $filename = $query1['filename'];
            $fileName = explode('.', $filename);
            $filename1 = $fileName[0];
            $filename2 = $fileName[1];
            if(!file_exists($filedir))
            {
                return array("data" => "11","msg" => "找不到该文件");
            }
            else{
                return array("data"=>["/Uploads/{$filedir1}","{$filename1}.{$filename2}"],"msg" =>"下载文件");
            }
        }
        else if($list['listid'] == 3)
        {
            $query1 = (new Query())
                    ->select('*')
                    ->from('oa_list3')
                    ->andWhere(['userid' => $userid])
                    ->andWhere(['procid' => $procid])
                    ->andWhere(['isvaild' => 1])
                    ->one();
            $filedir = $query1['filedir'];
            $fileArr = explode('Uploads/',$filedir);
            $filedir1 = $fileArr[1];
            $filename = $query1['filename'];
            $fileName = explode('.', $filename);
            $filename1 = $fileName[0];
            $filename2 = $fileName[1];
            if(!file_exists($filedir))
            {
                return array("data" => "11","msg" => "找不到该文件");
            }
            else{
                return array("data"=>["/Uploads/{$filedir1}","{$filename1}.{$filename2}"],"msg" =>"下载文件");
            }
        }
        else
        {
            return array("data"=>'111',"msg" =>"下载文件失败");
        }
        // $query1 = (new Query())
        //             ->select('*')
        //             ->from('oa_list10')
        //             ->andWhere(['userid' => $userid])
        //             ->andWhere(['procid' => $procid])
        //             ->andWhere(['isvaild' => 1])
        //             ->one();
        // $filedir = $query1['text'];
        // $fileArr = explode('Uploads/',$filedir);
        // $filedir1 = $fileArr[1];
        // $filename = $query1['content'];

        // if(!file_exists($filedir))
        // {
        //     return array("data" => "11","msg" => "找不到该文件");
        // }
        // else{
        //     return array("data"=>["/Uploads/{$filedir1}",$filename],"msg" =>"下载文件");
            // 文件不宜用流的形式传输
            // header("Content-type:application/octet-stream");
            // header("Accept-Ranges:bytes");
            // header("Accept-Length:".filesize($filedir));
            // header("Content-Disposition:attchment;filename=".$filename);
            // $file = fopen($filedir, "r");
            // $str = fread($file,filesize($filedir));
            // $str = str_replace("\r\n", "<br />", $str);
            // $str =mb_convert_encoding($str, 'utf-8','utf-8,GBK,GB2312,BIG5');
            // fclose($file);
            // $str = file_get_contents($filedir);
            // $file = fopen($filedir, "rb");
            // header("Content-type:application/octet-stream");
            // header("Accept-Ranges:bytes");
            // header("Accept-Length:".filesize($filedir));
            // header("Content-Disposition:attchment;filename=".$filename);
            // readfile($filedir);
            // $filesize = filesize($filedir);
            // $fileopen = fopen($filedir, "r");
            // $file = fread($fileopen, $filesize);
            // fread($file, filesize($filedir));
            // fclose($file);
            // return array("data" => [$filename,$filedir,$str],"msg" => "查看成功");
        // }
        // return array("data" => [$filename,$filedir],"msg" => "查看成功");
    }
    public function actionDownload()
    {
        $request = \Yii::$app->request;
        $userid = $request->post('userid');
        // $procname = $request->post('procname');
        $procid = $request->post('procid');
        $query = (new Query())
                ->select('*')
                ->from('oa_list2')
                ->andWhere(['userid' => $userid])
                ->andWhere(['procid' => $procid])
                ->andWhere(['isvaild' => 1])
                ->one();
        $user =(new Query())
            ->select('*')
            ->from('oa_contact')
            ->andWhere(['id' => $userid])
            ->andWhere(['status' => 1])
            ->one();
        $word_title = $query['procname'];
        $word_userid = $query['userid'];
        $word_username = $user['name'];
        $word_procid = $query['procid'];
        $word_procname = $query['procname'];
        $word_content = $query['content'];
        $word_time = $query['createtime'];
        $word_spid1 = $query['stepid1'];
        $word_step1name = (new Query())
            ->select('*')
            ->from('oa_contact')
            ->andWhere(['id' => $word_spid1])
            ->andWhere(['status' => 1])
            ->one();
            // $step1 审核意见 0未审批，1已审批，2已拒绝
        if($query['step1'] == '0')
        {
            $word_sp1 = '未审批';
        }else if($query['step1'] == '1')
        {
            $word_sp1 = '已审批';
        }else if($query['step1'] == '2')
        {
            $word_sp1 = '已拒绝';
        }
        // $word_sp1 = $query['step1'];
        $word_spid2 = $query['stepid2'];
        $word_step2name = (new Query())
            ->select('*')
            ->from('oa_contact')
            ->andWhere(['id' => $word_spid2])
            ->andWhere(['status' => 1])
            ->one();
        if($query['step2'] == '0')
        {
            $word_sp2 = '未审批';
        }else if($query['step2'] == '1')
        {
            $word_sp2 = '已审批';
        }else if($query['step2'] == '2')
        {
            $word_sp2 = '已拒绝';
        }
        // $word_sp2 = $query['step2'];
        // $word_flags = $query['procflag'];
        // $proc_ok  流程完成标志 0 未完成，1 成功，2 被拒
        if($query['procflag'] == '0')
        {
            $word_flags = '未完成';
        }else if($query['procflag'] == '1')
        {
            $word_flags = '成功';
        }else if($query['procflag'] == '2')
        {
            $word_flags = '被拒';
        }
        
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // // $phpWord->setDefaultFontName('Tahoma');
        $section = $phpWord->addSection();
        $phpWord->addTitleStyle(2,array('bold'=>true,'size'=>14,'name'=>'Arial','Color' =>'333'),array('align' =>'center'));
        
        // $section->addTitle("$word_title",2);
        $titleStyle = array('bold'=>true,'size'=> 28 ,'name'=>'Arial','Color' =>'333','align' =>'center');
        $section->addText("$word_title",$titleStyle);
        $section->addTextBreak(2);
        
        $word_tablestyle = array(
            'borderSize'=>6,
            'borderColor' => '000000');
        $table = $section->addTable($word_tablestyle);
        $fancyTableCellStyle = array('valign' => 'center');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
        $cellRowContinue = array('vMerge' => 'continue');
        $fontStyle['name'] = 'Arial';
        $fontStyle['size'] = 14;
        $thStyle['name'] = 'Arial';
        $thStyle['size'] = 12;
        $thStyle['bold'] = true;
        $paraStyle['align'] = 'center';

        $styleCell2 = array('gridSpan'=>2,'valign' => 'center');
        $styleCell3 = array('gridSpan'=>3,'valign' => 'center');
        $styleCell4 = array('gridSpan'=>4,'valign' => 'center');
        $table->addRow();
        $table->addCell(2000,$fancyTableCellStyle)->addText("姓名： ",$thStyle,$paraStyle);
        $table->addCell(2000,$fancyTableCellStyle)->addText(" {$word_username}",$thStyle,$paraStyle);
        $table->addCell(2000,$fancyTableCellStyle)->addText("编号： ",$thStyle,$paraStyle);
        $table->addCell(2000,$fancyTableCellStyle)->addText("{$word_userid}",$thStyle,$paraStyle);
        $table->addCell(2000,$fancyTableCellStyle)->addText("所在学院： ",$thStyle,$paraStyle);
        $table->addCell(2000,$fancyTableCellStyle)->addText(" {$user['department']}",$thStyle,$paraStyle);
        $table->addRow();
        $table->addCell(2000,$fancyTableCellStyle)->addText("行政职位：",$thStyle,$paraStyle);
        $table->addCell(4000,$styleCell2)->addText(" {$user['zhiwei']}",$thStyle,$paraStyle);
        $table->addCell(2000,$fancyTableCellStyle)->addText("职位： ",$thStyle,$paraStyle);
        $table->addCell(4000,$styleCell2)->addText(" {$user['position']} ",$thStyle,$paraStyle);
        $table->addRow();
        $table->addCell(2000,$fancyTableCellStyle)->addText("联系电话： ",$thStyle,$paraStyle);
        $table->addCell(4000,$styleCell2)->addText(" {$user['phone']}",$thStyle,$paraStyle);
        $table->addCell(2000,$fancyTableCellStyle)->addText("联系邮箱： ",$thStyle,$paraStyle);
        $table->addCell(4000,$styleCell2)->addText(" {$user['email']}",$thStyle,$paraStyle);
        $table->addRow();
        $table->addCell(2000,$fancyTableCellStyle)->addText("审批内容： ",$thStyle,$paraStyle);
        $table->addCell(6000,$styleCell3)->addText(" {$word_content}",$thStyle,$paraStyle);
        $table->addCell(2000,$fancyTableCellStyle)->addText("申请时间： ",$thStyle,$paraStyle);
        $table->addCell(2000,$fancyTableCellStyle)->addText(" {$word_time}",$thStyle,$paraStyle);
        $table->addRow();
        $table->addCell(3000,$fancyTableCellStyle)->addText("审批人一： ",$thStyle,$paraStyle);
        $table->addCell(4000,$styleCell2)->addText(" {$word_step1name['name']}",$thStyle,$paraStyle);
        $table->addCell(2000,$fancyTableCellStyle)->addText("审批意见： ",$thStyle,$paraStyle);
        $table->addCell(4000,$styleCell2)->addText(" {$word_sp1}",$thStyle,$paraStyle);
        $table->addRow();
        $table->addCell(2000,$fancyTableCellStyle)->addText("审批人二： ",$thStyle,$paraStyle);
        $table->addCell(4000,$styleCell2)->addText(" {$word_step2name['name']}",$thStyle,$paraStyle);
        $table->addCell(2000,$fancyTableCellStyle)->addText("审批意见： ",$thStyle,$paraStyle);
        $table->addCell(4000,$styleCell2)->addText(" {$word_sp2}",$thStyle,$paraStyle);
        $table->addRow();
        $table->addCell(4000,$styleCell2)->addText("申请结果： ",$thStyle,$paraStyle);
        $table->addCell(8000,$styleCell4)->addText(" {$word_flags}",$thStyle,$paraStyle);
        $objWriter =  \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save(iconv("utf-8","gb2312","../downloads/{$user['name']}{$word_title}.docx"));
        // return array("data"=>[$userid,$procid,$query,$user,$word_title],"msg"=>"ss");
        // return array("data"=>[$userid,$procid,$query,$user,$word_title],"msg"=>"ss");
        return array("msg"=>"导出","data"=>["/downloads/{$user['name']}{$word_title}.docx","{$user['name']}{$word_title}.docx"]);
    }
    
    // 下载申请表，填写的模板类的申请表
    //没有用到
    public function actionUpload()
    {
        $request = \Yii::$app->request;
        $s = $request->post('fileList');
        return array("data"=>$s,"msg"=>"111");
        $filename = $_FILES["upfile"]["name"];
        $uploadDir = getcwd()."\\files\\";
        if(!is_dir($uploadDir))
        {
            mkdir($uploadDir);
        }
        $dir = $uploadDir."/".$filename;
        $m=move_uploaded_file($_FILES["upfile"]["tmp_name"], iconv("utf-8", "GB2312", $dir."/".$_FILES["upfile"]["name"]));
        return array("data"=>[$filename,$m],"msg"=>"11");
    }
    //没有用到
    public function actionFileupload()
    {

        $request = \Yii::$app->request;
        $s = $request->post('data');
        return array("data"=>$s,"msg"=>"111");
        $uploadDir = getcwd()."\\files\\";
        if(!is_dir($uploadDir))
        {
            mkdir($uploadDir);
        }
        $filename = $uploadDir;
        $m=move_uploaded_file($s, $filename);
        return array("data"=>[$s,$uploadDir,$filename,$m],"msg"=>"11");
    }
    // public function actionUpload()
    // {
    //     // $model = new Upload();
    //     if(\Yii::$app->request->isPost)
    //     {
    //         // $mfile = \Yii::$app->request->post('doc');
    //         $mfile = UploadedFile::getInstanceByName('file');
    //         $dir = 'uploads/';
    //         if(!is_dir($dir))
    //         {
    //             mkdir($dir);
    //         }

    // }
}
    // public $enableCsrfValidation =false;
    // public function actionUpload()
    // {
    //     $request = \Yii::$app->request;
    //     $_FILES = $request->post("file");
    //     move_uploaded_file($_FILES["file"],["tmp_name"],"uploads/".$_FILES["file"]["name"]);
    //     echo $_FILES["file"]["name"];
    //     $id = rand(,time());
    //     $url = 'http://phpitm.grouptong.top:8081/Upload/'.$_FILES["file"]["name"];
    //     $connent = \Yii::$app->db->createCommand()->insert('oa_test',array(
    //         'content'=>$url)
    //     )->execute();
    //     return array("data"=>$connent,"msg"=>"文件上传");
    // }
	// public function actionDemo()
	// {
	// 	$PHPWord = new PHPWord();
	// 	$document = $PHPWord->loadTemplate('./word/Examples/Template.docx');
	// 	$document->setValue('Value1',iconv('utf-8', 'GB2312//IGNORE','1'));
	// 	$document->setValue('Value2',iconv('utf-8', 'GB2312//IGNORE','2'));
	// 	$filename = './word/Examples/m-i-'.time().'.docx';
	// 	$document->save($filename);
	// }
	// public function actionDownloaddemo()
	// {
	// 	$phpWord = new \PhpOffice\PhpWord\PhpWord();
	// 	$section = $phpWord->addSection();
	// 	$section->addText("Learn from yesterday, live for today, hope for tomorrow.");
 //    	$section->addText(
 //    		"Great achievement is usually born of great sacrifice.",array('name' => 'Tahoma', 'size' => 10));
 //    	$fontStyleName = 'oneUserDefinedStyle';
 //    	$phpWord->addFontStyle($fontStyleName,array('name' => 'Tahoma', 'size' => 10, 'color' => '1B2232', 'bold' => true));
 //    	$section->addText("The greatest accomplishment is not in never falling.",$fontStyleName);
 //    	$fontStyle = new \PhpOffice\PhpWord\Style\Font();
 //    	$fontStyle->setBold(true);
 //    	$fontStyle->setName('Tahoma');
 //    	$fontStyle->setSize(13);
 //    	$myTextElement = $section->addText('"Believe you can and you halfway there." (Theodor Roosevelt)');
 //    	$myTextElement->setFontStyle($fontStyle);
 //    	Header("Content-type:application/octet-stream");
 //    	Header("Accept-Ranges:bytes");
 //    	Header("Content-Disposition:attchment; filename=".'测试文件.docx')
 //    	ob_clean();//关键
 //    	flush();//关键
 //    	$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
 //    	$objWriter->save("php://output");
 //    	exit();
	// }
	// public function actionDownloadtoword()
	// {
	// 	//下载为word
	// 	$request = \Yii::$app->request;
 //        $procname = $request->post('procname');
 //        $userid = $request->post('userid');
 //        $procid = $request->post('procid');
 //        $list = (new Query())->select('listid')->from('oa_list')->andWhere(['listname' => $procname])->one();
 //        if($list['listid'] == 3)
 //        {
 //            $query1 = (new Query())
 //                    ->select('*')
 //                    ->from('oa_list10')
 //                    ->andWhere(['userid' => $userid])
 //                    ->andWhere(['procid' => $procid])
 //                    ->andWhere(['isvaild' => 1])
 //                    ->one();
 //            return array("data" => [$query1],"msg" => "查看成功");
 //        }

	// }

