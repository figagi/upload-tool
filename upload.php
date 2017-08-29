<?php
/**
 * Created by PhpStorm.
 * User: waitinghc
 * Date: 2016/12/31
 * Time: 11:34
 */
header('content-type:text/html;charset=utf-8');//解决浏览器非utf8编码时，出现中文乱码问题
$file = $_FILES['upload_file'];
$allowExt = array('jpeg', 'jpg', 'png', 'gif','doc','docx','pdf');//允许上传文件扩展名
$max_size = 2 * 1024 * 1024;//允许上传文件最大值2M
$upload_dir = 'jianli/';//文件上传目录'




// $file_name = $file['name'];//上传文件名称
// $tmp_name = $_FILES["upload_file"]["tmp_name"];
$file_name =iconv("utf-8","gb2312",$file["name"]);
// move_uploaded_file($tmp_name,"upload/".$name);
$tmp_name = $file['tmp_name'];//服务器保存的临时文件名
$file_size = $file['size'];//上传文件大小
$error = $file['error'];//错误码

//上传成功
if ($error == UPLOAD_ERR_OK) {

    //判断文件上传是否合法
    if (!is_uploaded_file($tmp_name)) {
        exit('文件上传非法');
    }

    //判断上传文件大小
    if ($file_size > $max_size) {
        exit ('上传文件超过限制大小');
    }

    //获取上传文件扩展名
    $ext = pathinfo($file_name, PATHINFO_EXTENSION);

    //判断上传文件扩展名是否合法
    if (@!in_array($ext, $allowExt)) {
        exit('非法文件类型');
    }

    //判断文件上传目录是否存在
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777);
    }

    //利用纳秒时间生成文件名再md5加密确保文件名唯一，防止重名
    // $uniName = md5(uniqid(microtime(true), true)) . '.' . $ext;
    // $uniName = date('Ymds',time()).'-'.$file_name . '.' . $ext;
    $uniName = date('Ymds',time()).'-'.$file_name;

    //完整文件信息
    $destination = $upload_dir . $uniName;

    //移动文件到指定目录
    if (@move_uploaded_file($tmp_name, $destination)) {
        // header('content-type:text/html;charset=gb2312');
        echo '文件上传成功';
    } else {
        echo '文件上传失败';
    }

} else {


    //根据错误码提示上传错误信息
    switch ($error) {
        case UPLOAD_ERR_INI_SIZE:
            echo '文件大小超过PHP配置文件的upload_max_filesize的限制大小';
            break;
        case UPLOAD_ERR_FORM_SIZE:
            echo '文件大小超过表单MAX_FILE_SIZE限制大小';
            break;
        case UPLOAD_ERR_PARTIAL:
            echo '文件部分被上传';
            break;
        case UPLOAD_ERR_NO_FILE:
            echo "未选择上传文件";
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            echo '文件临时目录不存在';
            break;
        case UPLOAD_ERR_CANT_WRITE:
        case UPLOAD_ERR_EXTENSION:
        case U_PRIMARY_TOO_LONG_ERROR:
            echo '上传失败';
            break;
    }
}
