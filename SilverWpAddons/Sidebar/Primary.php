<?php
namespace SilverWpAddons\Sidebar;

use SilverWp\Translate;
use SilverWp\Sidebar\SidebarAbstract;

if ( ! class_exists( 'SilverWpAddons\Sidebar\Primary' ) ) {
    /**
     * Primary sidebar
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @version $Id: Primary.php 2184 2015-01-21 12:20:08Z padalec $
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage Sidebar
     * @copyright (c) 2015, silversite.pl
     */
    class Primary extends SidebarAbstract {
        protected $id = 'primary';

        protected function setName() {
            $this->name = Translate::translate( 'Primary' );

            return $this;
        }

        protected function setDescription() {
            $this->description = Translate::translate( 'Place for right site in Page view' );

            return $this;
        }
    }
}