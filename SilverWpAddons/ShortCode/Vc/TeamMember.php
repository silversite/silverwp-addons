<?php

namespace SilverWpAddons\ShortCode\Vc;

use SilverWp\ShortCode\Vc\Control\ExtraCss;
use SilverWp\ShortCode\Vc\Control\Text;
use SilverWp\ShortCode\Vc\Control\Image;
use SilverWp\ShortCode\Vc\Control\WpEditor;
use SilverWp\ShortCode\Vc\ShortCodeAbstract;
use SilverWp\Translate;

if ( ! class_exists( '\SilverWpAddons\ShortCode\Vc\TeamMember' ) ) {
    /**
     * Short Code Team Member
     *
     * @category WordPress
     * @package SilverWpAddons
     * @subpackage ShortCode
     * @author Michal Kalkowski <michal at silversite.pl>
     * @copyright SilverSite.pl 2015
     * @version $Revision:$
     */
    class TeamMember extends ShortCodeAbstract {
        protected $tag_base = 'ds_team_member';

        /**
         * Render Short Code content
         *
         * @param array  $args short code attributes
         * @param string $content content string added between short code tags
         *
         * @return mixed
         * @access public
         */
        public function content( $args, $content ) {
            if ( isset($args[ 'image' ]) ) {
                $args[ 'image' ] = $this->imageId2Url( $args[ 'image' ] );
            }

            $default = $this->prepareAttributes();

            $accounts = silverwp_get_name_icon();
            foreach ( $accounts as $account ) {
                $slug = $account[ 'slug' ];
                if ( isset( $args[ $slug ] ) ) {
                    $args[ $slug ] = array(
                        'name' => $account[ 'name' ],
                        'slug' => $slug,
                        'url'  => $args[ $slug ],
                        'icon' => $account[ 'icon' ],
                    );
                }
            }
            $short_code_attributes = $this->setDefaultAttributeValue( $default, $args );

            $view = $this->render( $short_code_attributes, $content );

            return $view;
        }

        /**
         * This method is used to build setting form element
         *
         * @return void
         * @access protected
         */
        protected function create() {
            $this->setLabel(Translate::translate( 'Team member' ));
            $this->setCategory( Translate::translate( 'Add by SilverSite.pl' ) );

            $name = new Text( 'name' );
            $name->setLabel( Translate::translate( 'Name' ) );
            $this->addControl( $name );

            $image = new Image( 'image' );
            $image->setLabel( Translate::translate( 'Image' ) );
            $this->addControl( $image );

            $workplace = new Text( 'workplace' );
            $workplace->setLabel( Translate::translate( 'Workplace' ) );
            $this->addControl( $workplace );

            $account = silverwp_get_social_accounts();
            foreach ( $account as $slug => $name ) {
                $url = new Text( $slug );
                $url->setLabel( Translate::params( '%s URL', ucfirst( $name ) ) . ':' );
                $url->setGroup( Translate::translate( 'Social accounts' ) );
                $this->addControl( $url );
            }

            $content = new WpEditor( 'content' );
            $content->setLabel( Translate::translate( 'Description' ) );
            $this->addControl( $content );
            //field Extra class name (input text)
            $el_css = new ExtraCss();
            $this->addControl( $el_css );
        }
    }
}