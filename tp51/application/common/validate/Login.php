<?php

namespace app\common\validate;

use think\Validate;

class Login extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    '__token__|令牌'=>'require|token',
        'username|用户名' => 'require|min:3|max:10|regex:^\w{3,10}$|unique:member',
        'password|密码' => 'require|min:3|max:10',
        'repwd|确认密码' => 'require|confirm:password',
        'email|邮箱' => 'require|email',
        'mobile|手机号' => 'require|mobile',
        'captcha|验证码' =>'require|captcha'
     ];
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];

    protected $scene =[
        'login'=>['__token__','username','password','captcha']
    ];
    public function sceneLogin(){
        return $this->only(['__token__','username','password','mobile'])
            ->remove('mobile','require|mobile')
            ->append('username|用户名','alphaNum');
    }
}
