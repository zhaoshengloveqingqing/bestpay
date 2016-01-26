<?php namespace Pinet\BestPay\Commands; in_array(__FILE__, get_included_files()) or exit("No direct script access allowed");

use Clips\Command;

/**
 * Class FakeDataCommand
 * @package Pinet\BestPay\Commands
 *
 * @Clips\Library("FakeProjectData")
 */
class FakeDataCommand extends Command {
    public function execute($args) {
        $this->fakeprojectdata->do_fake();
    }
} 
