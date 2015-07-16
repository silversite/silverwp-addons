<?php
/*
 * Copyright (C) 2014 Michal Kalkowski <michal at silversite.pl>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */
/*
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/Sidebar/Widget/CompanyInfo.php $
  Last committed: $Revision: 2184 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-01-21 13:20:08 +0100 (Śr, 21 sty 2015) $
  ID: $Id: CompanyInfo.php 2184 2015-01-21 12:20:08Z padalec $
 */

namespace SilverWpAddons\Sidebar\Widget;

use SilverWpAddons\Helper\Option;
use SilverWpAddons\Translate;

/**
 * Company Info Widget
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: CompanyInfo.php 2184 2015-01-21 12:20:08Z padalec $
 * @category WordPress
 * @package SilverWP
 * @subpackage Sidebar\Widget
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */

class CompanyInfo extends WidgetAbstract
{
    public function __construct()
    {
        // Configure widget array
        $args = array(
            // Widget Backend label
            'label'         => Translate::translate('Company Info'),
            'name'          => 'company-info',
            // Widget Backend Description
            'description'   => Translate::translate('Company information contact details.'),
        );
        // Configure the widget fields
        // Example for: Title (text ) and Amount of posts to show (select box )
        // fields array
        $args['fields'] = array(
            // Title field
            array(
                // field name/label
                'name'  => Translate::translate('Title'),
                // field description
                //'desc' => Translate::translate('Enter the widget title.', 'mv-my-recente-posts'),
                // field id
                'id'    => 'title',
                // field type (text, checkbox, textarea, select, select-group )
                'type'  => 'text',
                // class, rows, cols
                'class' => 'widefat',
                // default value
                //'std'   => Translate::translate('Company Info'),
                /*
                Set the field validation type/s
                ///////////////////////////////

                'alpha_dash'
                Returns FALSE if the value contains anything other than alpha-numeric characters, underscores or dashes.

                'alpha'
                Returns FALSE if the value contains anything other than alphabetical characters.

                'alpha_numeric'
                Returns FALSE if the value contains anything other than alpha-numeric characters.

                'numeric'
                Returns FALSE if the value contains anything other than numeric characters.

                'boolean'
                Returns FALSE if the value contains anything other than a boolean value (true or false ).

                ----------

                You can define custom validation methods. Make sure to return a boolean (TRUE/FALSE ).
                Example:

                'validate' => 'my_custom_validation',

                Will call for: $this->my_custom_validation($value_to_validate );

                */
                'validate' => 'alpha_numeric',
                /*
                Filter data before entering the DB
                //////////////////////////////////
                strip_tags (default )
                wp_strip_all_tags
                esc_attr
                esc_url
                esc_textarea
                */
                'filter' => 'strip_tags|esc_attr'
            ),
            array(
                'name'      => Translate::translate('Show Company Name'),
                'id'        => 'show_company_name',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),

            array(
                'name'      => Translate::translate('Show Company Street'),
                'id'        => 'show_company_street',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Show Postcode'),
                'id'        => 'show_company_postcode',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Show City'),
                'id'        => 'show_company_city',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Show State / Region'),
                'id'        => 'show_company_state',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Show Country'),
                'id'        => 'show_company_country',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),
            /*array(
                'name'      => Translate::translate('Show Country Flag'),
                'id'        => 'show_company_country_flag',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),*/
            array(
                'name'      => Translate::params('Show Phone number %s', '#1'),
                'id'        => 'show_company_phone1',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::params('Show Phone number %s', '#2'),
                'id'        => 'show_company_phone2',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::params('Show Mobile phone number %s', '#1'),
                'id'        => 'show_company_mobile_phone1',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::params('Show Mobile phone number %s', '#2'),
                'id'        => 'show_company_mobile_phone2',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Show Fax number'),
                'id'        => 'show_company_fax',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Show Email address'),
                'id'        => 'show_company_email',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info'),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Show Business hours'),
                'id'        => 'show_company_business_hours',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                'std'       => 1,
                //'validate'  => 'boolean',
            ),
            // add more fields
        ); // fields array
        // create widget
        $this->createWidget($args);
    }

    // Output function

    public function widget($args, $instance)
    {
        //widget <section>
        $out = $args['before_widget'];

        // widget title
        $out .= $args['before_title'];
        $out .= isset($instance['title']) && $instance['title'] ? $instance['title'] : Translate::translate('Company Information');
        $out .= $args['after_title'] . "\n";

        $company['name'] = $instance['show_company_name'] === '1' ? Option::get_theme_option('company_name') : '';

        $company['address']  = $instance['show_company_street'] === '1' ? Option::get_theme_option('company_street').'<br />' : '';
        $company['address'] .= $instance['show_company_postcode'] === '1' ? Option::get_theme_option('company_postcode').' ' : '';
        $company['address'] .= $instance['show_company_city'] === '1' ? Option::get_theme_option('company_city') : '';
        $company['address'] .= $instance['show_company_state'] === '1' ? '<br />'.Option::get_theme_option('company_region') : '';
        $company['address'] .= $instance['show_company_country'] === '1' ? '<br />'.Option::get_theme_option('company_country') : '';

        if ( $instance['show_company_email'] === '1' ) {
            $email_ASCII = '';
            $email = Option::get_theme_option( 'company_email' );
            $email_len = strlen($email);
            for( $i=0; $i<$email_len; $i+=1 ) {
                $email_ASCII .= ord( substr($email, $i, 1) ) . ',';
            }
            $email_ASCII = trim($email_ASCII, ',');
        }

        $company['contact']  = $instance['show_company_phone1'] === '1' ? '<span class="phone">'.__('Phone', 'silverwp').': '.Option::get_theme_option('company_phone1').'</span><br />' : '';
        $company['contact'] .= $instance['show_company_phone2'] === '1' ? '<span class="phone">'.__('Phone', 'silverwp').' #2: '. Option::get_theme_option('company_phone2').'</span><br />' : '';
        $company['contact'] .= $instance['show_company_email'] === '1' ? '<span class="email">'.__('Email', 'silverwp').': <a href="javascript:location.href=\'mailto:\'+String.fromCharCode('.$email_ASCII.')+\'?\'">'. $email .'</a></span>' : '';
        $company['contact'] .= $instance['show_company_mobile_phone1'] === '1' ? '<span class="mobile">'.__('Mobile', 'silverwp').': '. Option::get_theme_option('company_mobile1').'</span><br />' : '';
        $company['contact'] .= $instance['show_company_mobile_phone2'] === '1' ? '<span class="mobile">'.__('Mobile', 'silverwp').' #2: '. Option::get_theme_option('company_mobile2').'</span><br />' : '';
        $company['contact'] .= $instance['show_company_fax'] === '1' ? '<span class="fax">'.__('Fax', 'silverwp').': '. Option::get_theme_option('company_fax').'</span><br />' : '';

        $company['hours'] = $instance['show_company_business_hours'] === '1' ? nl2br(Option::get_theme_option('company_business_hour')) : '';

        $out .= $company['contact'] ? '<p class="contact">'. $company['contact'] .'</p>' : '';
        $out .= $company['name']    ? '<p class="companyname"><strong>'. $company['name'] .'</strong></p>' : '';
        $out .= $company['address'] ? '<p class="address">'. $company['address'] .'</p>' : '';
        $out .= $company['hours']   ? '<p class="hours">'. $company['hours'] .'</p>' : '';
        //SilverWpAddons_debug_array($instance);

        //widget end </section>
        $out .= $args['after_widget'];

        echo $out;
    }
}
