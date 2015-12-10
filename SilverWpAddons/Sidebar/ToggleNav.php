<?php
namespace SilverWpAddons\Sidebar;

use SilverWp\Sidebar\SidebarAbstract;
use SilverWp\Translate;

if ( ! class_exists('\SilverWpAddons\Sidebar\ToggleNav')) {
    /**
     * ToggleNav sidebar
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @version $Id: ToggleNav.php 2184 2015-01-21 12:20:08Z padalec $
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage Sidebar
     * @copyright (c) 2009 - 2014, SilverSite.pl
     */
    class ToggleNav extends SidebarAbstract {
        protected $id = 'toggle';

        protected function setName() {
            $this->name = Translate::translate( 'Toggle Navigation' );

            return $this;
        }

        protected function setDescription() {
            //$this->description = Translate::translate( 'Place for right site in ToggleNav view' );

            return $this;
        }

	    /**
	     * Replace default widgets html title tage
	     *
	     * @return string
	     * @access public
	     */
	    public function beforeTitle() {
		    return '<h3 class="widget-heading"><span>';
	    }

        /**
         * Replace default widgets html title tage
         *
         * @return string
         * @access public
         */
        public function afterTitle() {
            return '</span></h3>';
        }
    }
}