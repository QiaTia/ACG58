<?PHP
include_once '../public/data.php';
date_default_timezone_set('PRC');
SESSION_start();
$user_id = $_SESSION['userId'];
$userInfo = sqlSelect('user','id',$user_id);
if (isset($_FILES['file'])) {
    $filename=explode('.',$_FILES['file']['name']);
	$name = $filename[0];
    $type = $filename[1];
    if($type <> 'jpg' || $type <> 'gif' || $type <> 'png'|| $type <> 'jpeg') $coer =null;
    $img = $_FILES['file']['tmp_name'];
    $wh = getimagesize($img);
    $wh_w = $wh[0];
    $wh_h = $wh[1];
    $dst_w = 268;
    $dst_h = 268;
    $dst = imagecreatetruecolor($dst_w, $dst_h);
    $source = imagecreatefromjpeg($img);
    imagecopyresized($dst, $source, 0, 0, 0, 0, $dst_w, $dst_h, $wh_w, $wh_h);
    $un_name = uniqid("ACG58_").'.'.$type;
    $coer = '../images/user/'.$un_name;
    $info = array();
    $info['isSuccess'] = imagejpeg($dst, $coer, 100);
    $info['filepath'] = $coer;
    $info['filename'] = $un_name;
    $info['w'] = $dst_w;
    $info['h'] = $dst_h;
    sqlUpdate('user','coer',$un_name,$user_id);
    echo json_encode($info);
}
if (isset($_POST['oldPw'])) {
    $oldPw = md5($_POST['oldPw']);
    if($userInfo['pw'] != $oldPw)
        die('密码不正确');
    else {
        $newPw = isset($_POST['newPw'])?md5($_POST['newPw']):'';
        if($newPw !=''){
            if(sqlUpdate('user','pw',$newPw,$user_id)){
                session_unset();
                session_destroy();
                die('修改成功！请重新登陆');
            }
            else die('修改失败！原因未知');
        }
        else 
            return false;
    }
}
if (isset($_POST['emailCode'])) {
    $email = $_POST['email'];
    $_SESSION['code'] = 'ACG'.rand(1000,99999);
    $emailContent = "";
    sendMail($email,'',$emailContent);
}
if(isset($_POST['updataEmail'])){
    $code = $_POST['code'];
    if($code != $_SESSION['code']) die('验证码不正确，请检查后重试！');
    $email = $_POST['updataEmail'];
    if(!sqlUpdate('user','email',$email,$user_id))
        die('修改失败！原因未知');
    die('修改成功！');
}
//邮件推送服务
function sendMail($smtpemailto,$mailtitle,$mailcontent){
    //使用方法  
    $post_data = array(  
      'smtpemailto' => $smtpemailto,  
      'mailtitle' => $mailtitle,
      'mailcontent' => $mailcontent
    );  
    send_post('https://qiatia.top/public/PushService/QiaTiaPushMail.php', $post_data);  
  //echo "成功！";
}
?>