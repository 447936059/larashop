<?php

namespace App\Admin\Controllers;

use App\Models\CrowdfundingProduct;
use App\Models\Product;
use Encore\Admin\Form;
use Encore\Admin\Grid;

class CrowdfundingProductsController extends CommonProductsController
{
    //声明商品类型
    public function getProductType()
    {
        return Product::TYPE_CROWDFUNDING;
    }

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '众筹商品';

    /**实现公用商品类customGrid
     * @param Grid $grid
     * Author: sai
     * DateTime: 2020/1/27 11:48 下午
     */
    protected function customGrid(Grid $grid)
    {
        $grid->id('ID')->sortable();
        $grid->title('商品名称');
        $grid->on_sale('已上架')->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->price('价格');
        $grid->column('crowdfunding.target_amount', '目标金额');
        $grid->column('crowdfunding.end_at', '结束时间');
        $grid->column('crowdfunding.total_amount', '目前金额');
        $grid->column('crowdfunding.status', ' 状态')->display(function ($value) {
            return CrowdfundingProduct::$statusMap[$value];
        });
    }

    /**实现公用商品类customForm
     * @param Form $form
     * Author: sai
     * DateTime: 2020/1/27 11:49 下午
     */
    protected function customForm(Form $form)
    {
        // 众筹相关字段
        $form->text('crowdfunding.target_amount', '众筹目标金额')->rules('required|numeric|min:0.01');
        $form->datetime('crowdfunding.end_at', '众筹结束时间')->rules('required|date');
    }

}
