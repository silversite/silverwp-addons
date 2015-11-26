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

namespace SilverWpAddons;


use SilverWp\Db\Query;
use SilverWp\Debug;
use SilverWp\Helper\Message;
use SilverWp\Helper\Thumbnail;
use SilverWp\Translate;
use SilverWpAddons\PostType\Events;

if ( ! class_exists( '\SilverWpAddons\Import' ) ) {
	// Include WPML API
	include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );
	/**
	 *
	 *
	 *
	 * @category  WordPress
	 * @package   SilverWp
	 * @subpackage
	 * @author    Michal Kalkowski <michal at silversite.pl>
	 * @copyright SilverSite.pl (c) 2015
	 * @version   0.1
	 */
	class Import {
		private $pod = null;

		public function __construct() {
			ini_set( 'max_execution_time', '200' );
			add_action( 'admin_menu', array( $this, 'register_submenu_page' ) );
			$dsn       = 'mysql:host=sql.ibs.nazwa.pl;dbname=ibs_3';
			$this->pdo = new \PDO( $dsn, 'ibs_3', 'ibs_2013_F6xPNJfAXH' );
			//$dsn       = 'mysql:host=skuter.autentika.pl;dbname=ibs-wp';
			//$this->pdo = new \PDO( $dsn, 'ibs-wp', 'Wu!%^1u$%z3' );
			$this->pdo->query( 'SET NAMES UTF8' );
		}

		public function register_submenu_page() {
			add_submenu_page(
				'tools.php',
				Translate::translate( 'CSV' ),
				Translate::translate( 'CSV' ),
				'edit_posts',
				'import_csv',
				array( $this, 'import_csv' )
			);
//			add_submenu_page(
//				'tools.php',
//				Translate::translate( 'Import old content (news)' ),
//				Translate::translate( 'Import old content (news)' ),
//				'edit_posts',
//				'import_news',
//				array( $this, 'import_news' )
//			);
//			add_submenu_page(
//				'tools.php',
//				Translate::translate( 'Import old content (publications)' ),
//				Translate::translate( 'Import old content (publications)' ),
//				'edit_posts',
//				'import_publications',
//				array( $this, 'import_publications' )
//			);
//			//wpml_add_translatable_content($content_type, $content_id, $language_code = false, $trid = false)
		}
		public function import_csv() {
			global $wpdb;

//			$results = $this->pdo->query('SELECT ID, post_title, post_content FROM `wpibs__posts` WHERE `post_type` = \'events\'');
//			$rows = $results->fetchAll(\PDO::FETCH_ASSOC);
			$path = str_replace( 'wp/', '', ABSPATH );
			if (($handle = fopen($path. 'newsy2.csv', 'r')) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
					switch ($data[5]){
						case 'wydarzenie':
							$post_type = 'events';
							break;
						case 'publikacja':
							$post_type = 'publications';
							break;
						case 'wiadomosc':
							$post_type = 'news';
							break;
					}
					if (isset($post_type) && $post_type == 'events' && $data[3] != '-1') {
//						Debug::dumpPrint($data);
						$sql = 'SELECT
						  news.id,
						  news.object_id,
						  news.name AS post_title,
						  url AS post_slug,
						  lead,
						  content AS post_content,
						  date AS post_date,
						  image,
						  lead_image,
						  file,
						  category.name AS cat_name,
						  news.additional_cat_ids
						FROM
						  `pl_news` AS news,
						  `pl_category` AS category
						WHERE
						  news.id_category = category.id AND
						  object_id = 5206 AND
						  news.id = ' . (int) $data[3] . '
						ORDER BY post_date ASC
					  ';
						$results = $this->pdo->query($sql);
						$rows = $results->fetchAll(\PDO::FETCH_ASSOC);
						foreach($rows as $row) {
							if ( ! empty( $data[6] ) ) {
								$row['cat_name'] = $data[6];
							}

//							if ($row['id'] == 5077) {
								//$this->import_en( $file_pl, $row, 'events', 'events_category' );
//							}
						}
//						$post_title = trim($data[1]);

//						$post = $wpdb->get_results( "SELECT ID,guid,post_type FROM $wpdb->posts WHERE post_title = '" . $post_title . "' AND post_type = 'publications'" );
//						Debug::dumpPrint($post);
					}
//					if (isset($post_type) && $post_type == 'publications') {
//						$post_title = trim($data[1]);
//						$post = $wpdb->get_results( "SELECT ID,guid,post_type FROM $wpdb->posts WHERE post_title = '" . $post_title . "' AND post_type = 'news'" );
////						Debug::dumpPrint($post);
////
//						echo '<br />';
////						echo "<br />SELECT ID FROM $wpdb->posts WHERE post_title = '" . $post_title . "'";
//						if (isset($post[0]->ID)) {
//							$url = str_replace( 'news', 'publications', $post[0]->guid );
//							$wpdb->get_var(
//								"UPDATE wpibs__posts SET guid = REPLACE(guid, '{$post[0]->guid}', '$url') WHERE ID = {$post[0]->ID}"
//							);
//							set_post_type( $post[0]->ID, 'publications' );
//							$test = $wpdb->get_var(
//								"UPDATE wpibs__icl_translations SET element_type = REPLACE(element_type, 'post_news', 'post_publications') WHERE element_id = {$post[0]->ID}"
//							);
//							$post_data = array(
//								'ID'          => $post[0]->ID,
//								'post_status' => 'draft',
//							);
//							if ( ! empty( $data[6] ) ) {
//								$terms = get_term_by(
//									'name',
//									$data[6],
//									'publications_category'
//								);
//								if ( ! is_wp_error( $terms ) && isset($terms->term_id) ) {
//									Debug::dump($terms);
//									$term_taxonomy_ids = wp_set_object_terms(
//										$post[0]->ID,
//										$terms->term_id,
//										'publications_category'
//									);
//									Debug::dump($term_taxonomy_ids);
//								}
//							}
//							wp_update_post( $post_data );
//						}
//					}
//					if (isset($post_type) && $post_type == 'events') {
//						$post_title = trim($data[1]);
//						$post = $wpdb->get_results( "SELECT ID,guid,post_type FROM $wpdb->posts WHERE post_title = '" . $post_title . "' AND post_type = 'news'" );
//						if (isset($post[0]->ID)) {
//							$url = str_replace( 'news', 'events', $post[0]->guid );
//							$wpdb->get_var(
//								"UPDATE wpibs__posts SET guid = REPLACE(guid, '{$post[0]->guid}', '$url') WHERE ID = {$post[0]->ID}"
//							);
//							set_post_type( $post[0]->ID, 'events' );
//							$wpdb->get_var(
//								"UPDATE wpibs__icl_translations SET element_type = REPLACE(element_type, 'post_news', 'post_events') WHERE element_id = {$post[0]->ID}"
//							);
//							if ( ! empty( $data[6] ) ) {
//								$terms = get_term_by(
//									'name',
//									$data[6],
//									'events_category'
//								);
//
//								if ( ! is_wp_error( $terms )
//								     && isset( $terms->term_id )
//								) {
//									$term_taxonomy_ids = wp_set_post_terms(
//										$post[0]->ID,
//										array( $terms->term_id ),
//										'events_category'
//									);
//								}
//							}
//							$post_data = array(
//								'ID'            => $post[0]->ID,
//								'post_status'   => 'draft',
//								'post_category' => array( $term_taxonomy_ids ),
//							);
//							$test = wp_update_post( $post_data );
//							Debug::dump($test);
//						}
//					}
				}
				fclose($handle);
			}else {
				echo 'file not found';
			}
		}

		public function import_events() {

		}

		public function import_news() {
			?>
			<h1><?php echo Translate::translate('Import news from old site') ?></h1>
			<?php
			//$file_pl = fopen( 'E:\xampp\htdocs\ibs\web\news_pl.csv', 'a+' );
			$file_pl = fopen( WP_PLUGIN_DIR . '/silverwp-addons/export/news_pl.csv', 'a+' );
			//$file_en = fopen( WP_PLUGIN_DIR . '/silverwp-addons/export/news_en.csv', 'a+' );
			if ( $file_pl ) {
				$sql
					= 'SELECT
					  news.id,
					  news.object_id,
					  news.name AS post_title,
					  url AS post_slug,
					  lead,
					  content AS post_content,
					  date AS post_date,
					  image,
					  lead_image,
					  file,
					  category.name AS cat_name,
					  news.additional_cat_ids
					FROM
					  `pl_news` AS news,
					  `pl_category` AS category
					WHERE
					  news.id_category = category.id
					ORDER BY post_date ASC
					  ';

				$results = $this->pdo->query( $sql );
				if ( $results ) {
					$rows = $results->fetchAll(\PDO::FETCH_ASSOC);
					foreach ( $rows as $key => $value ) {
						$sql_cat
							= 'SELECT name FROM `pl_category` WHERE id IN ('
							  . $value['additional_cat_ids'] . ')';
						$results = $this->pdo->query( $sql_cat );
						$cats = array();
						if ( $results ) {
							$cats = array_column( $results->fetchAll(),
								'name' );
						}

						if ( $value['object_id'] == 206 ) {
							$this->import_pl( $file_pl, $value, 'news', 'news_type', $cats );
						}

						if ( $value['object_id'] == 5206 ) {
							//$this->import_en( $file_en, $value );
						}
					}
					echo Message::display( 'Import successful' );
				}
//				fclose( $file_pl );
				//fclose( $file_en );
			}
		}

		private function import_pl( $file_handler, array $data, $post_type, $tax_name, array $cats = array()) {
			$post_meta = array();
			$content = preg_replace( "/<img[^>]+\>/i", "", $data['post_content'] );
			$post = array(
				'post_content'  => $content,
				'post_name'     => $data['post_slug'],
				'post_title'    => $data['post_title'],
				'post_author'   => 2,
				'post_type'     => $post_type,
				'post_excerpt'  => $data['lead'],
				'post_date'     => $data['post_date'],
				'post_date_gmt' => $data['post_date'],
				'post_status'   => 'publish',
				'tax_input'     => array(
					$tax_name => array_merge(
						array( $data['cat_name'] ),
						$cats
					)
				)
			);
			$post_id = wp_insert_post( $post );
			if ( $post_type == 'publicatiosn' ) {
				$post_meta['lead'] = $data['lead'];
			}
			//insert to cvs file
			fputcsv( $file_handler, array( $post_id, $data['post_title'] ), ';' );
			if ( ! empty( $data['lead_image'] ) ) {
				$domain        = 'http://ibs.org.pl';
				$file_name     = basename( $data['lead_image'] );
				$file_content  = file_get_contents($domain . $data['lead_image']);
				$wp_upload_dir = wp_upload_dir();
				$file          = $wp_upload_dir['path'] . '/' . $file_name;

				if ( file_put_contents( $file, $file_content ) ) {
					$test = Thumbnail::addImage(
						$post_id,
						$file,
						true
					);
				}
				if ($post_type == 'publicatiosn') {
					$post_meta['cover'] = $wp_upload_dir['url'] . '/'
					                      . $file_name;
				}
			}

			if ( ( isset( $data['document'] ) && ! empty( $data['document'] ) )
			     || ( isset( $data['file'] ) ) && ! empty( $data['file'] )
			) {
				$file = isset( $data['document'] ) ? $data['document'] : $data['file'];
				$post_meta['attachments'][0] = $this->import_file($post_id, $data, $file);
				echo 'ok';
			}

			add_post_meta( $post_id, '_silverwp_option_' . $post_type, $post_meta);

		}

		private function import_file($post_id, $data) {
			if( !class_exists( 'WP_Http' ) ) {
				include_once( ABSPATH . WPINC. '/class-http.php' );
			}

			$file = new \WP_Http();
			$file_request = $file->request( 'http://ibs.org.pl' . $data['document'] );
			$attachment = wp_upload_bits(
				basename( $data['document'] ),
				null, $file_request['body'],
				date( "Y-m", strtotime( $file_request['headers']['last-modified'] ) )
			);
			if( !empty( $attachment['error'] ) )
				return false;

			$filetype = wp_check_filetype( basename( $attachment['file'] ), null );

			$postinfo = array(
				'post_mime_type'	=> $filetype['type'],
				'post_title'		=> $data['post_title'] . ' employee photograph',
				'post_content'		=> '',
				'post_status'		=> 'inherit',
			);
			$filename = $attachment['file'];
			$attach_id = wp_insert_attachment( $postinfo, $filename, $post_id );

			if( !function_exists( 'wp_generate_attachment_data' ) )
				require_once(ABSPATH . "wp-admin" . '/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
			wp_update_attachment_metadata( $attach_id,  $attach_data );

			return $attachment['url'];

		}
		private function import_en( $file_handler, array $data, $post_type, $tax_name, array $cats = array() ) {
			$content = preg_replace( "/<img[^>]+\>/i", "", $data['post_content'] );
			$post = array(
				'post_content'  => $content,
				'post_name'     => $data['post_slug'],
				'post_title'    => $data['post_title'],
				'post_type'     => $post_type,
				'post_author'   => 2,
				'post_excerpt'  => $data['lead'],
				'post_date'     => $data['post_date'],
				'post_date_gmt' => $data['post_date'],
				'post_status'   => 'draft',
				'tax_input'     => array(
					$tax_name => array_merge(
						array( $data['cat_name'] ), $cats
					)
				)
			);
			$post_meta = array('lead' => $data['lead']);

			$post_id = wp_insert_post( $post );
			$_POST['icl_post_language'] = $language_code = 'en';
			$test = wpml_add_translatable_content( $post_type, $post_id, $language_code );
			wpml_update_translatable_content( $post_type, $post_id, $language_code );

			if ($test == 0) {
//				fputcsv( $file_handler, array( $post_id, $data['post_title'] ), ';' );
				if ( ! empty( $data['lead_image'] ) ) {
					$domain        = 'http://ibs.org.pl';
					$file_name     = basename( $data['lead_image'] );
					$file_content  = file_get_contents( $domain
					                                    . $data['lead_image'] );
					$wp_upload_dir = wp_upload_dir();
					$file          = $wp_upload_dir['path'] . '/' . $file_name;
					if ( file_put_contents( $file, $file_content ) ) {
						Thumbnail::addImage(
							$post_id,
							$file,
							true
						);
						if ( $post_type == 'publications' ) {
							$post_meta['cover'] = $wp_upload_dir['url'] . '/'
							                      . $file_name;
						}
					}
				}
				if ( ( isset( $data['document'] ) && ! empty( $data['document'] ) )
				     || ( isset( $data['file'] ) ) && ! empty( $data['file'] )
				) {
					$file = isset( $data['document'] ) ? $data['document'] : $data['file'];
					$post_meta['attachments'][0] = $this->import_file($post_id, $data, $file);
					echo 'ok';
				}
				add_post_meta(
					$post_id,
					'_silverwp_option_' . $post_type,
					$post_meta
				);
				echo 'ok EN<br />';
			} else {
				echo 'false EN<br />';
			}
		}

		public function import_publications() {
			?>
			<h1><?php echo Translate::translate('Import publications from old site') ?></h1>
			<?php
			$file_pl = fopen( WP_PLUGIN_DIR . '/silverwp-addons/export/publications_pl.csv', 'a+' );
			$file_en = fopen( WP_PLUGIN_DIR . '/silverwp-addons/export/publications_en.csv', 'a+' );
			if ( $file_pl && $file_en ) {
				$sql
					= 'SELECT
					  publications.id,
					  publications.object_id,
					  publications.name AS post_title,
					  publications.document,
					  url AS post_slug,
					  lead,
					  content AS post_content,
					  date AS post_date,
					  image,
					  lead_image,
					  category.name AS cat_name,
					  publications.additional_cat_ids
					FROM
					  `pl_publications` AS publications,
					  `pl_category` AS category
					WHERE
					  publications.id_category = category.id AND
					  object_id = 5202
					ORDER BY post_date ASC';

				$results = $this->pdo->query( $sql );

				if ( $results ) {
					$rows = $results->fetchAll();
					foreach ( $rows as $key => $value ) {

						$sql_cat
							= 'SELECT name FROM `pl_category` WHERE id IN ('
							  . $value['additional_cat_ids'] . ')';
						$results = $this->pdo->query( $sql_cat );
						$cats = array();
						if ( $results ) {
							$cats = array_column( $results->fetchAll(),
								'name' );
						}

						if ( $value['object_id'] == 202 ) {
//							$this->import_pl( $file_pl, $value, 'publications', 'publications_category', $cats );
						}

						if ( $value['object_id'] == 5202 ) {
							$this->import_en( $file_en, $value, 'publications', 'publications_category', $cats );
						}
					}
					echo Message::display( 'Import successful' );
				}
				fclose( $file_pl );
				fclose( $file_en );
			} else {
				echo 'file false';
			}
		}

		public function change_post_type() {
			if (($handle = fopen('E:\xampp\htdocs\ibs\web\newsy.csv', 'r')) !== FALSE) {
				while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
					switch ($data[5]){
						case 'wydarzenie':
							$post_type = 'events';
							break;
						case 'publikacja':
							$post_type = 'publications';
							break;

					}
					if (isset($post_type) && $post_type == 'publications') {
						echo $sql = trim($data[1]) . '<br />';

					}
					if (isset($post_type) && $post_type == 'events') {

					}

				}
				fclose($handle);
			}

		}
	}
}