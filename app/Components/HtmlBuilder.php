<?php

namespace AccountHon\Components;
/**
 * Created by PhpStorm.
 * User: Anwar Sarmiento
 * Date: 05/07/2015
 * Time: 02:49 PM
 */

use Collective\Html\HtmlBuilder As CollectiveHtmlBuilder;


class HtmlBuilder extends CollectiveHtmlBuilder  {


    public function menu(){

        $temp = null;
        $Menu = array();
        foreach (\Auth::user()->menus as $menu) {
            if ($temp != $menu->id) {
                $temp = $menu->id;
                if(count($menu->tasksActive($menu->pivot->user_id)->select('name', 'id')->get()) > 0){
                    $Menu[] = [ 'id' => $menu->id,
                        'url' => $menu->url,
                        'name' => $menu->name,
                        'icon_font' => $menu->icon_font,
                        'tasks' => $menu->tasksActive($menu->pivot->user_id)->select('name', 'id')->get(),
                        'currentRoute' => $this->currentRoute()
                    ];
                }
            }
        }
        return $Menu;
    }

    private function currentRoute(){
        $currentRouteName = explode("-", \Route::currentRouteName());
        if( count($currentRouteName) > 1){
            $route = $currentRouteName[1];
            if( count($currentRouteName) > 2){
                $route = null;
                foreach ($currentRouteName as $key => $value) {
                    if($key != 0){
                        $route .= $value.'-';
                    }
                }
                $route = substr($route, 0, -1);
            }
            return $route;
        }
        return 'inicio';
    }
}