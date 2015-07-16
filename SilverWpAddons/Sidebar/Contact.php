<?php
namespace SilverWpAddons\Sidebar;

use SilverWp\Translate;
use SilverWp\Sidebar\SidebarAbstract;

if ( ! class_exists( 'SilverWpAddons\Sidebar\Contact' ) ) {
    /**
     * Contact Page sidebar
     *
     * @author Michal Kalkowski <michal at silversite.pl>
     * @version $Id:$
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage Sidebar
     * @copyright (c) 2015, dynamite-studio.pl
     */
    class Contact extends SidebarAbstract {
        protected $id = 'contact';

        protected function setName() {
            $this->name = Translate::translate( 'Contact Page' );

            return $this;
        }

        protected function setDescription() {
            $this->description = Translate::translate( 'Place for right site in Contact Page view' );

            return $this;
        }
    }
}