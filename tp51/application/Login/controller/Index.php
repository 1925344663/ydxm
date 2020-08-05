<?php
namespace app\Login\controller;
use app\common\validate\Login as Loginvalidate;
use app\common\validate\Login;
use app\Login\model\Member;
use Monolog\Handler\ElasticSearchHandler;
use think\captcha\Captcha;
use think\facade\Validate;
use think\response\Redirect;

class Index
{
    /*
     * 登录
     */
    public function index()
    {
        if (request()->isPOST())
        {
            $validate = new Loginvalidate();
            if ($validate->batch()->scene('login')->check(input('param.')))
            {
                return json(['status'=>'ok']);
            }else
            {
//                $token = token();
//                dd($token);

                return json(['status'=>'error','errors'=>$validate->getError(),'old'=>input('param.'),'token'=>request()->token()]);
            }

        }else
        {
            return view();
        }

    }
    /*
     * 注册
     */
    public function register()
    {
        if (request()->isPOST())
        {
            $vaildate  = new Loginvalidate();
            if ($vaildate->batch()->check(input('param.')))
            {
                $data['username']  = input('param.username');
                $data['password']  = md5(input('param.password'));
                $data['mobile']  = input('param.mobile');
                $data['email']  = input('param.email');

                if (Member::insert($data))
                {
                    return redirect(url('Login/index/index',['username'=>$data['username']]));
                }
                return '验证通过';
            }else
            {
                dd($errors = $vaildate->getError());

                return redirect('')->with(['status'=>'error','old'=>input('param.'),'errors'=>$errors]);
            }
        }else
        {
            return view();
        }
    }
    /*
     * 验证码方法
     */
    public function captcha()
    {
        $config = [
          'imageW' =>  120,
          'imageH' =>  45,
            'fontSize'=> 20,
            'useCurve' => false,
            'codeSet' => '0123456789',
            'useNoise' => false,
            'length' => 3,
            'bg' => [mt_rand(180,255),mt_rand(180,255),mt_rand(180,255)],
            'reset' => true
        ];
        $captcha = new Captcha($config);
        return $captcha->entry();
    }
}
