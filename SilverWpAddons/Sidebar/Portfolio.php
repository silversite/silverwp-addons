<?php
namespace SilverWpAddons\Sidebar;

use SilverWp\Sidebar\SidebarAbstract;
use SilverWp\Translate;

if ( ! class_exists( 'SilverWpAddons\Sidebar\Portfolio' ) ) {
    /**
     * Portfolio sidebar
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @version $Id: Portfolio.php 2184 2015-01-21 12:20:08Z padalec $
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage Sidebar
     * @copyright (c) 2015, silversite.pl
     */
    class Portfolio extends SidebarAbstract {
        protected $id = 'portfolio';

        protected function setName() {
            $this->name = Translate::translate( 'Portfolio' );

            return $this;
        }

        protected function setDescription() {
            $this->description = Translate::translate( 'Place for right site in Portfolio view' );

            return $this;
        }
    }
}