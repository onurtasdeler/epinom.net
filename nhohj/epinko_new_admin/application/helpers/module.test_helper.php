<?php

class TestModule
{

    public $title = "Test Module";
    public $version = "1.0.0";
    public $author = "Epinko";
    public $server = "https://google.com";
    public $settings;

    public function __construct()
    {
        $this->register_module();
    }

    private function register_module(){
        $module = [
            'name'  =>  $this->title
        ];
        do_action('module_register', (object) $module);
    }
}

$TestModule = new TestModule();