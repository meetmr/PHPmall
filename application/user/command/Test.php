<?php
namespace app\user\command;

use think\console\Command;
use think\console\Input;
use think\console\Output;
use app\admin\model\CE;
class Test extends Command
{
    protected function configure(){
        $this->setName('Test')->setDescription("计划任务 Asa");
    }

    protected function execute(Input $input, Output $output){
        $output->writeln('Date Crontab job start...');
        /*** 这里写计划任务列表集 START ***/
        $this->test();

        /*** 这里写计划任务列表集 END ***/
        $output->writeln('Date Crontab job end...');
    }

    private function test(){
        while (true){
            CE::create(['name'=>125]);
            sleep(1);
        }
    }
}