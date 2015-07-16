<?php

namespace SilverWpAddons\Sidebar;

use SilverWp\Sidebar\SidebarAbstract;
use SilverWp\Translate;

if ( ! class_exists( 'SilverWpAddons\Sidebar\Footer' ) ) {
    /**
     * Footer sidebar for widgets
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @version $Id:$
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage Sidebar
     * @copyright (c) 2015, dynamite-studio.pl
     */
    class Footer extends SidebarAbstract {
        protected $id = 'footer';

        protected function setName() {
            $this->name = Translate::translate( 'Footer' );

            return $this;
        }

        protected function setDescription() {
            $this->description = '';

            return $this;
        }

        public function beforeWidget() {
            $widget_count = $this->getWidgetCount();
            switch ( $widget_count ) {
                case 1:
                    $class = 'col-xs-12';
                    break;
                case 2:
                    $class = 'col-sm-6';
                    break;
                case 3:
                    $class = 'col-md-4 col-sm-6';
                    break;
                default: // 4+
                    $class = 'col-md-3 col-sm-6';
            }
            $html = '<div class="' . $class . ' item"><section class="widget %1$s %2$s">';

            return $html;
        }

        public function afterWidget() {
            return '</section></div>';
        }
    }
}