<?php
namespace SilverWpAddons\Sidebar;

use SilverWp\Sidebar\SidebarAbstract;
use SilverWp\Translate;

if ( ! class_exists('SilverWpAddons\Sidebar\Blog')) {
    /**
     * Blog sidebar
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @version $Id: Blog.php 2184 2015-01-21 12:20:08Z padalec $
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage Sidebar
     * @copyright (c) 2009 - 2014, SilverSite.pl
     */
    class Blog extends SidebarAbstract {
        protected $id = 'blog';

        protected function setName() {
            $this->name = Translate::translate( 'Blog' );

            return $this;
        }

        protected function setDescription() {
            $this->description = Translate::translate( 'Place for right site in Blog view' );

            return $this;
        }
    }
}