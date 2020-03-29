<?php
/**
 * Created by PhpStorm.
 * User: jinjunbin <13585687317@163.com>
 * Date: 2020/2/25
 * Time: 23:53
 */
namespace app\admin\controller;

use app\common\lib\Show;

class ImageController extends AdminBaseController
{
    /**
     * 商品的图片上传
     * @return \think\response\Json
     */
    public function upload()
    {
        if (!$this->request->isPost()) {
            return Show::error('请求不合法');
        }
        $file = $this->request->file('file');
        // 注意事项
        // 1.上传图片类型需要判断png gif jpg 2.文件大小限制 600kb  tp的validate验证机制
        try {
            validate(['file' => 'fileSize:600000|fileExt:png,gif,jpg,jpeg'])//fileSize后面单位是b
                ->check(['file'=>$file]);
        } catch (\think\exception\ValidateException $e) {
            return Show::error($e->getMessage());
        }
        //$filename = \think\facade\Filesystem::putFile('upload', $file);//默认上传runtime/storage/upload目录
        $filename = \think\facade\Filesystem::disk('public')->putFile('image', $file);
        if (!$filename) {
            return Show::error('上传图片失败');
        }

        // 这个地方的路径一定要注意
        $imageUrl = [
            'image' => '/upload/'.$filename,
        ];
        return Show::success($imageUrl, '图片上传成功');
    }

    /**
     * 富文本编辑器的图片上传
     * @return \think\response\Json
     */
    public function layUpload()
    {
        if (!$this->request->isPost()) {
            return Show::error('请求不合法');
        }

        $file = $this->request->file('file');
        $filename = \think\facade\Filesystem::disk('public')->putFile('image', $file);
        if (!$filename) {
            return json(['code' => 1,'data' => []], 200);
        }

        $result = [
            'code' => 0,
            'data' => [
                'src' => '/upload/'.$filename,
            ],
        ];
        return json($result, 200);
    }
}
