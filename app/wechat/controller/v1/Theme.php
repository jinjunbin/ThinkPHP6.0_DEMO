<?php

namespace app\wechat\controller\v1;

use app\common\lib\Show;
use app\wechat\controller\Base;
use app\wechat\exception\SuccessMessage;
use app\wechat\exception\ThemeException;
use app\wechat\model\Theme as ThemeModel;
use app\wechat\validate\IDCollection;
use app\wechat\validate\IDMustBePositiveInt;
use app\wechat\validate\ThemeProduct;

/**
 * 主题推荐,主题指首页里多个聚合在一起的商品
 * 注意同专题区分
 * 常规的REST服务在创建成功后，需要在Response的
 * header里附加成功创建资源的URL，但这通常在内部开发中
 * 并不常用，所以本项目不采用这种方式
 */
class Theme extends Base
{
    /**
     * @url     /theme?ids=:id1,id2,id3...
     * @return  array of theme 一组theme模型
     * @throws  ThemeException
     * @note 实体查询分单一和列表查询，可以只设计一个接收列表接口，
     *       单一查询也需要传入一个元素的数组
     *       对于传递多个数组的id可以选用post传递、
     *       多个id+分隔符或者将多个id序列化成json并在query中传递
     */
    public function getSimpleList($ids = '')
    {
        (new IDCollection())->goCheck();
        $ids = explode(',', $ids);
        $result = ThemeModel::getThemes($ids);
        if ($result->isEmpty()) {
            throw new ThemeException();
        }

        // 框架会自动序列化数据为JSON，所以这里不要toJSON！
//        $result = $result->hidden(['products.imgs'])
//            ->toArray();
//        $result = $result->hidden([
//            'products.category_id','products.stock','products.summary']);
        return Show::success($result);
    }

    /**
     * @url     /theme:id
     * @param $id
     * @return array
     * @throws ThemeException
     * @throws \app\wechat\exception\ParameterException
     */
    public function getComplexOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        if ($theme->isEmpty()) {
            throw new ThemeException();
        }
        return Show::success($theme);
        return $theme->hidden(['products.summary'])->toArray();
    }

//    public function getThemeSummary()

    /**
     * @url /theme/:t_id/product/:p_id
     * @Http POST
     * @return SuccessMessage or Exception
     */
    public function addThemeProduct($t_id, $p_id)
    {
        $validate = new ThemeProduct();
        $validate->goCheck();
        ThemeModel::addThemeProduct($t_id, $p_id);
        return new SuccessMessage();
    }

    /**
     * @url /theme/:t_id/product/:p_id
     * @Http DELETE
     * @return SuccessMessage or Exception
     */
    public function deleteThemeProduct($t_id, $p_id)
    {
        $validate = new ThemeProduct();
        $validate->goCheck();
        $themeID = (int)$t_id;
        $productID = (int)$p_id;
        ThemeModel::deleteThemeProduct($themeID, $productID);
        return new SuccessMessage([
            'code' => 204
        ]);
    }

    // 去除部分属性，尽量对客户端保持精简
//    private function cutThemes($themes)
//    {
//        foreach ($themes as &$theme) {
//            foreach ($theme['products'] as &$product) {
//                unset($product['stock']);
//                unset($product['summary']);
//            }
//        }
//        return $themes;
//    }
}
