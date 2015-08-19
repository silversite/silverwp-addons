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
namespace SilverWpAddons\MetaBox;

use SilverWp\Helper\Control\Attachments;
use SilverWp\Helper\Control\Checkbox;
use SilverWp\Helper\Control\Select;
use SilverWp\Helper\Control\Text;
use SilverWp\Helper\Control\Textarea;
use SilverWp\Helper\Control\Upload;
use SilverWp\Translate;
use SilverWp\MetaBox\MetaBoxAbstract;

if ( ! class_exists( '\SilverWpAddons\Publications' ) ) {
	/**
	 * Publications Meta box for Publications Post Type
	 *
	 * @author        Michal Kalkowski <michal at silversite.pl>
	 * @version       $Id:$
	 * @category      WordPress
	 * @package       SilverWpAddons
	 * @subpackage    MetaBox
	 * @copyright (c) SilverSite.pl 2015
	 */
	class Publications extends MetaBoxAbstract {
		protected $priority = 'low';

		protected function createMetaBox() {

			$this->setEnterTitleHearLabel( Translate::translate( 'Name' ) );

			$text = new Text( 'keywords' );
			$text->setLabel( Translate::translate( 'Keywords' ) );
			$this->addMetaBox( $text );

			$text = new Text( 'abstract' );
			$text->setLabel( Translate::translate( 'Abstract' ) );
			$this->addMetaBox( $text );

			$text_area = new Textarea( 'additional_information' );
			$text_area->setLabel( Translate::translate( 'Additional information' ) );
			$this->addMetaBox( $text_area );

			$select = new Select( 'publication_year' );
			$select->setLabel( Translate::translate( 'Publication year' ) );

			$options = array();
			for ( $i = 2005; $i <= date( 'Y' ); $i ++ ) {
				$options[] = array(
					'label' => $i,
					'value' => $i,
				);
			}
			$select->setOptions( $options );
			$this->addMetaBox( $select );

			$checkbox = new Checkbox( 'language' );
			$checkbox->setLabel( Translate::translate( 'Publication language' ) );
			$checkbox->setOptions(
				array(
					array(
						'label' => Translate::translate('Polish'),
						'value' => 'pl',
					),
					array(
						'label' => Translate::translate('English'),
						'value' => 'en',
					)
				)
			);
			$this->addMetaBox( $checkbox );

			$attachments = new Attachments( 'attachments' );
			$this->addMetaBox( $attachments );

			$upload = new Upload( 'cover' );
			$upload->setLabel( Translate::translate( 'Cover' ) );
			$this->addMetaBox( $upload );
		}
	}
}
