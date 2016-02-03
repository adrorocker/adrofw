<?php

namespace Adroframework\View\ThemeManager;

use Adroframework\Config\Config as Config;
use Adroframework\Mobile\Mobile as Mobile;

/**
* 
*/
class ThemeManager
{
    protected $appConfigs;
    protected $mca;
    protected $theme;

    public function __construct($configs, $mca)
    {
        $this->appConfigs = $configs;
        $this->mca = $mca;
        $this->setTheme();
    }

    public function setTheme()
    {
        if (!empty($this->appConfigs['application']['modules']) && $this->mca['module']) {
            $themeConfigs = $this->appConfigs['application']['modules'][$this->mca['module']]['view_manager'];
            $defaultTheme = $themeConfigs['default_theme'];
            $theme = isset($themeConfigs['themes'][$defaultTheme]) ? $themeConfigs['themes'][$defaultTheme] : null;
            $device = new Mobile();
            if ($themeConfigs['mobile'] === true && $device->isMobile() && $theme !== null) {
                $theme['views'] = $theme['views'].'/mobile';
            }
        } else {
            $themeConfigs = $this->appConfigs['application']['configs']['view_manager'];
            $defaultTheme = $themeConfigs['default_theme'];
            $theme = isset($themeConfigs['themes'][$defaultTheme]) ? $themeConfigs['themes'][$defaultTheme] : null;
            $device = new Mobile();
            if ($themeConfigs['mobile'] === true && $device->isMobile() && $theme !== null) {
                $theme['views'] = $theme['views'].'/mobile';
            }
        }
        $this->theme = $theme;
    }

    public function getTheme()
    {
        return $this->theme;
    }
}