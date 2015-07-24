<?php
namespace SilverWpAddons\ShortCode;

use SilverWpAddons\ShortCode\Vc\Button;
use SilverWpAddons\ShortCode\Vc\CallToActionButton;
use SilverWpAddons\ShortCode\Vc\Counter;
use SilverWpAddons\ShortCode\Vc\IconBox;
use SilverWpAddons\ShortCode\Vc\MessageBox;
use SilverWpAddons\ShortCode\Vc\PieCharts;
use SilverWpAddons\ShortCode\Vc\Portfolio;
use SilverWpAddons\ShortCode\Vc\ProgressBar;
use SilverWpAddons\ShortCode\Vc\RecentBlogPostsGrid;
use SilverWpAddons\ShortCode\Vc\Row;
use SilverWpAddons\ShortCode\Vc\Separator;
use SilverWpAddons\ShortCode\Vc\SocialAccount;
use SilverWpAddons\ShortCode\Vc\TeamMember;
use SilverWpAddons\ShortCode\Vc\Testimonial;
use SilverWp\ShortCode\Vc\SetupAbstract;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Setup' ) ) {
    /**
     *
     * Main Short Code class add, remove, change settings
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage SilverWpAddons
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright (c) SilverSite.pl 2015
     * @version $Revision:$
     */
    class Setup extends SetupAbstract {

        public static $un_register = array( 'gravityform' );

        /**
         * Register short codes
         *
         * @access protected
         */
        protected function register() {
            /*
            new MessageBox();
            new Button();
            new CallToActionButton();
            new Counter();
            new IconBox();
            new PieCharts();
            new Portfolio();
            new ProgressBar();
            new RecentBlogPostsGrid();
            new Separator();
            new SocialAccount();
            new TeamMember();
            new Testimonial();
            new Row();
            */
        }
    }
}