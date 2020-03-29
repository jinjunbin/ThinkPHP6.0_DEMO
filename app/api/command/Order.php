<?php
declare (strict_types = 1);

namespace app\api\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use app\common\business\Order as OrderBis;

class Order extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('order')
            ->setDescription('the order command');
    }

    /**
     * php think order
     * 无间断挂起 nohup php think order > /log/a.log &
     * 进程挂了=>添加监控机制
     */
    protected function execute(Input $input, Output $output)
    {
        $obj = new OrderBis();
        while (true) {
            $obj->checkOrderStatus();
            sleep(1);
        }
        // 指令输出
        $output->writeln('order1111');
    }
}
