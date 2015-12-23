<?php
namespace SilverWpAddons\Sidebar;

use SilverWp\Sidebar\SidebarAbstract;
use SilverWp\Translate;

if ( ! class_exists('\SilverWpAddons\Sidebar\FooterCol2')) {
    /**
     * FooterCol2 sidebar
     *
     * @author Marcin Dobroszek <marcin at silversite.pl>
     * @version $Id: FooterCol2.php 2184 2015-01-21 12:20:08Z cichy $
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage Sidebar
     * @copyright (c) 2009 - 2015, SilverSite.pl
     */
    class FooterCol2 extends SidebarAbstract {
        protected $id = 'footercol2';

        protected function setName() {
            $this->name = Translate::translate( 'Footer (column #2)' );

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