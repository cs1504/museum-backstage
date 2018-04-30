<?php

namespace app\museum\controller;


use app\api\model\Admin;
use think\Controller;
use app\api\controller\AdminControlApi;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use think\Db;

class Login extends Controller
{
    public function login()
    {
        if(request()->isPost()){
            $res = (new Admin())->login(input('post.'));
            if($res['valid'])
            {
                //说明登录成功
                $this->success($res['msg'],'/index');exit;
            }else{
                //说明登录失败
                $this->error($res['msg']);exit;
            }
        }
        //加载我们登录页面
        return $this->fetch('login');
    }

    public function logout() {
        $res = AdminControlApi::logout();
        $res = json_decode($res->getContent(), true);
        if($res['valid'])
            $this->redirect('/login');
        else
            $this->error($res['msg']);exit;
    }

    public function index() {
        return $this->fetch('index');
    }

    public function forgotpasswd() {
        if($this->request->isPost()) {
            $data = input('post.');
            $res = Db::table('admin')->where('email', $data['email'])->find();

            if(!$res) {
                return json(['valid' => 0, 'msg' => '没有此邮箱的注册记录']);
            }
            $address = 'http://39.106.168.133:8080/resetpasswd?key=';
            $key = base64_encode(http_build_query(array(['email' => $res['email'],
                'time' => time(), 'k' => md5('museum'.$res['nickname'])])));

            $address .= $key;
            $mail = new PHPMailer(true); // Passing `true` enables exceptions
            $mail->Charset='UTF-8';
            try {
                //Server settings
//                $mail->SMTPDebug = 2;               // Enable verbose debug output
                $mail->isSMTP();                    // Set mailer to use SMTP
                $mail->Host = 'smtpdm.aliyun.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;             // Enable SMTP authentication
                $mail->Username = 'admin@mail.0xl2oot.cn';    // SMTP username
                $mail->Password = 'WANGyonghong123';          // SMTP password
                $mail->SMTPSecure = 'tls';                    // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 25;                             // TCP port to connect to

                //Recipients
                $mail->setFrom('admin@mail.0xl2oot.cn', '博物馆系统管理员');
                $mail->addAddress($res['email'], $res['nickname']);     // Add a recipient
                $mail->addReplyTo('18811080655@163.com', '系统人工管理员');

                //Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = '重置密码通知';
                $mail->Body    = '亲爱的 <b>'.$res['nickname'].'</b>，您好<br><br>'.
                                    '您收到了这封邮件是因为您（也有可能是某人冒充您的名义）申请了一个重置密码的请求，<br>'.
                                    '假如这不是您本人所申请，或者您曾持续收到这类邮件的骚扰，<br>'.
                                    '请您尽快联系系统管理员 18811080655@163.com<br>'.
                                    '您可以点击如下链接重新设置您的密码，如果点击无效，请把下面的代码拷贝到浏览器的地址栏中：<br>'.
                                    '<a href="'.$address.'">'.$address.'</a><br>'.
                                    '在访问链接之后，您可以重新设置密码。<br><br>博物馆系统管理员<br><br>'.date('Y-m-d');
//                $mail->AltBody = '不支持回复哈哈哈哈This is the body in plain text for non-HTML mail clients';

                $mail->send();
                return json(['valid' => 1, 'msg' => '已成功发送邮件，请登录邮箱重置密码，邮件有效期为1小时']);
            } catch (Exception $e) {
                return json(['valid' => 1, 'msg' => '发送邮件失败，'.$mail->ErrorInfo]);
            }
        }
    }

    public function resetpasswd() {
        if($this->request->isPost()) {
            $data = input('post.');
            if($data['time']+3600 < time())
                $this->error('当前会话已失效，请重新申请重置', '/');
            $res = Db::table('admin')
                ->where('email', $data['email'])
                ->find();
            if(!$data['k'] == md5('museum'.$res['nickname'])) {
                $this->error('非法请求');
            }
            $res = Db::table('admin')
                ->where('email', $res['email'])
                ->update(['password' => md5('museum'.$data['password'])]);
            if(!$res) {
                $this->error('与之前密码相同', '/');
            }
            $this->success('修改成功，请重新登录', '/');
        }

        if($this->request->isGet()) {
            $data = input('get.');
            if(!isset($data['key']))
                $this->error('未知请求', '/');
            parse_str(base64_decode($data['key']), $decode);
            if($decode[0]['time']+3600 < time())
                $this->error('链接已失效，请重新申请重置', '/');
            $this->assign('decode', $decode[0]);
            return $this->fetch('resetpasswd');
        }
    }

}