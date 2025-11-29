<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActionManager {
    private static $actions = [];

    public static function add_action($hook, $function, $priority = 10) {
        self::$actions[$hook][] = [
            'function' => $function,
            'priority' => $priority
        ];
        usort(self::$actions[$hook], function($a, $b) {
            return $a['priority'] <=> $b['priority'];
        });
    }

    public static function do_action($hook, ...$args) {
        $result = null;

        if (isset(self::$actions[$hook])) {
            foreach (self::$actions[$hook] as $action) {
                $result = call_user_func_array($action['function'], $args);
            }
        }

        return $result;
    }
}

function add_action($hook, $function, $priority = 10) {
    ActionManager::add_action($hook, $function, $priority);
}

function do_action($hook, ...$args) {
    return ActionManager::do_action($hook, ...$args);
}


//Automation Hooking Points
add_action('automation_generate_keyword', function($name) {
    return [$name];
});

add_action('automation_generate_description', function($name) {
    return $name;
});


add_action('module_register', function($module) {
    // return $module->name . " registered";

    //Register Menu (easy use pages)
    //Register Widget (control items)
    //Register Settings (needed area)
    //Register to DB
});

add_action('module_active_before', function($module) {});
add_action('module_active', function($module) {
    do_action('module_active_before', $module);
    do_action('module_active_after', $module);
});
add_action('module_active_after', function($module) {});

add_action('module_deactivate_before', function($module) {});
add_action('module_deactivate', function($module) {
    do_action('module_deactivate_before', $module);
    do_action('module_deactivate_after', $module);
});
add_action('module_deactivate_after', function($module) {});

add_action('module_update_before', function($module) {});
add_action('module_update', function($module) {
    do_action('module_update_before', $module);
    do_action('module_update_after', $module);
});
add_action('module_update_after', function($module) {});

add_action('module_delete_before', function($module) {});
add_action('module_delete', function($module) {
    do_action('module_delete_before', $module);
    do_action('module_delete_after', $module);
});
add_action('module_delete_after', function($module) {});

add_action('module_error', function($module) {});
add_action('module_log', function($module) {});

add_action('module_lists', function() {
    return [0, 1, 2];
});