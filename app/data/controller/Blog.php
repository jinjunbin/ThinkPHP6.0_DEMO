<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Blog;
use app\validate\Check;
use think\exception\ValidateException;

class Blog
{
    protected $middleware = ['auth'];   //控制器中间件,已经定义别名

    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //halt('输出测试');
        $list = Blog::where('create_time','<',time())->limit(3)->select();
        echo $list->toJson() . "<br>";
        foreach ($list as $k => $v) {
            echo $v->title . "<br>";
        }
        return "--Blog in2";
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
        $blog = Blog::create([
            'title'  =>  'thinkphp',
            'txt' =>  'thinkphp@qq.com'
        ]);
        echo $blog->title . "<br>";
        echo $blog->txt . "<br>";
        echo $blog->id; // 获取自增ID
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
        $title = $request->param('title');
        $txt = $request->param('txt','','htmlspecialchars');
        try {
            validate(Check::class)->check([
                'title'  => $title,
                'txt' => $txt,
            ]);

            $blog = Blog::create([
                'title'  =>  $title,
                'txt' =>  $txt,
            ]);
            echo $blog->title . "<br>";
            echo $blog->txt . "<br>";
            echo $blog->id; // 获取自增ID

        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            dump($e->getError());
        }

    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
        $blog = Blog::findOrEmpty($id);
        if (!$blog->isEmpty()) {
            echo $blog->title . "<br>";
        } else {
            echo "没有数据";
        }
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
        $blog = Blog::find($id);
        $blog->title     = 'sdf';
        $blog->txt    = '111';
        $rst = $blog->save();
        echo $rst;
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
        $rst = Blog::update($request->param(), ['id' => $id], ['title','txt']);
        echo $rst;
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
        $blog = Blog::find($id);
        $blog->delete();
    }
}
