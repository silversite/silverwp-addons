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
		protected $exclude_columns = array( 'category', 'tag' );

		protected function setUp() {

			$this->setEnterTitleHearLabel( Translate::translate( 'Name' ) );

			$lead = new Textarea( 'lead' );
			$lead->setLabel( Translate::translate( 'Lead' ) );
			$this->addControl( $lead );

			$keywords = new Text( 'keywords' );
			$keywords->setLabel( Translate::translate( 'Keywords' ) );
			$this->addControl( $keywords );

			$abstract = new Textarea( 'abstract' );
			$abstract->setLabel( Translate::translate( 'Abstract' ) );
			$this->addControl( $abstract );

			$text_area = new Textarea( 'additional_information' );
			$text_area->setLabel( Translate::translate( 'Additional information' ) );
			$this->addControl( $text_area );

			$select = new Select( 'publication_year' );
			$select->setLabel( Translate::translate( 'Publication year' ) );
			$select->setStart( 2005 );
			$select->setEnd( date( 'Y' ) );
			$this->addFilterControl( $select );

			$checkbox = new Checkbox( 'language' );
			$checkbox->setLabel( Translate::translate( 'Publication language' ) );
			$checkbox->setOptions(
				array(
					array(
						'label' => Translate::translate('polish'),
						'value' => 'pl',
					),
					array(
						'label' => Translate::translate('english'),
						'value' => 'en',
					)
				)
			);
			$this->addFilterControl( $checkbox );

			$attachment = new Upload( 'attachment' );
			$attachment->setLabel( Translate::translate( 'Main file' ) );
			$this->addControl( $attachment );

			$attachments = new Attachments( 'attachments' );
			$this->addControl( $attachments );

			$cover = new Upload( 'cover' );
			$cover->setLabel( Translate::translate( 'Cover' ) );
			$this->addControl( $cover );
		}
	}
}
