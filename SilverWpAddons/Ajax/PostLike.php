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
namespace SilverWpAddons\Ajax;

use SilverWp\Ajax\AjaxAbstract;
use SilverWp\Helper\Filter;
use SilverWp\Helper\UtlArray;
use SilverWp\Translate;

/**
 * Post Like rating system
 *
 * @author        Michal Kalkowski <michal at silversite.pl>
 * @version       0.5
 * @category      WordPress
 * @package       SilverWp
 * @subpackage    Ajax
 * @link          https://github.com/JonMasterson/WordPress-Post-Like-System based on JonMasterson script
 * @copyright     2009 - 2015 (c) SilverSite.pl
 */
class PostLike extends AjaxAbstract {
	/**
	 *
	 * post id
	 *
	 * @var int
	 */
	private $post_id;

	/**
	 *
	 * user id
	 *
	 * @var int
	 */
	private $user_id;

	protected $name = 'post_like';
	protected $ajax_js_file = 'main.js';
	protected $ajax_handler = 'sage_js';


	/**
	 * Get post like count
	 *
	 * @param int $post_id
	 *
	 * @access public
	 * @return array
	 * @static
	 */
	public static function getLikeCount( $post_id ) {
		$like_count = get_post_meta( $post_id, '_post_like_count', true );

		return $like_count;
	}

	/**
	 *
	 * Save like data
	 *
	 * @global  $current_user
	 */
	public function save() {
		$this->checkAjaxReferer();

		$post_like = $this->getRequestData( 'post_like', FILTER_SANITIZE_NUMBER_INT );
		$this->post_id = $this->getRequestData( 'post_id', FILTER_SANITIZE_NUMBER_INT );

		if ( $post_like ) {
			// post like count
			$post_like_count = $this->getPostMeta( '_post_like_count', true );
			if ( \is_user_logged_in() ) { // user is logged in
				$this->userLoggedLike( $post_like_count );
			} else { // user is not logged in (anonymous)
				// user IP address
				if ( ( $ip = $this->getUserIp() ) !== false ) {
					// stored IP addresses
					$liked_ips = $this->getPostMeta( '_user_IP' );
					if ( array_search( $ip, $liked_ips ) === false
					     || array_search( $ip, $liked_ips ) === null
					) {
						// if IP not in array
						$liked_ips[] = $ip;// add IP to array
					}
					if ( self::isAlreadyLiked() ) {// unlike the post
						$ip_key = \array_search( $ip,
							$liked_ips ); // find the key
						unset( $liked_ips[ $ip_key ] ); // remove from array
						// Remove user IP from post meta
						// -1 count post meta
						$post_like_count
							= $this->subtractionLikeCount( $post_like_count );
						$this->updatePostLikeMeta( $liked_ips, $post_like_count );
						// generate response
						$this->response( 0, $post_like_count );
					} else {//like the post
						// Add user IP to post meta
						// +1 count post meta
						$this->updatePostLikeMeta( $liked_ips,
							++ $post_like_count );
						// generate response
						// update count on frontend
						$this->response( 1, $post_like_count );
					}
				} else {
					$this->response( 'ip', 'error' );
				}
			}
		} else {
			$this->response( 'param post_like', 'error' );
		}
	}

	/**
	 * Ajax response
	 *
	 * @access public
	 * @return string
	 */
	public function ajaxResponse() {
		$post_like = $this->postLike();

		return $post_like;
	}
	/**
	 *
	 * if user logged in change user meta data
	 *
	 * @access protected
	 *
	 * @param int               $post_like_count post like count
	 *
	 * @global WP_User $current_user
	 */
	protected function userLoggedLike( $post_like_count ) {
		global $current_user;
		$this->user_id = $current_user->ID; // current user id

		$liked_posts = $this->getUserLikeMeta(); // post ids from user meta
		// user ids from post meta
		$liked_users = $this->getPostMeta( '_user_liked' );
		$liked_posts[] = $this->post_id; // Add post id to user meta array
		$liked_users[] = $this->user_id; // add user id to post meta array

		$liked_posts = UtlArray::array_remove_empty( array_unique( $liked_posts ) );

		$user_likes = count( $liked_posts ); // count user likes
		//if user like the post and click like - unlike the post
		if ( $this->alreadyLiked( $this->post_id ) ) {
			// find the key
			$liked_posts = array_diff( array( $this->post_id ), $liked_posts );
			// find the key
			$liked_users = array_diff( array( $this->user_id ),$liked_users );
			//unset($liked_posts[ $pid_key ]); // remove from array
			//unset($liked_users[ $uid_key ]); // remove from array
			$user_likes = count( $liked_posts ); // recount user likes

			// Add user ID to post meta
			// +1 count post meta
			$post_like_count = $this->subtractionLikeCount( $post_like_count );
			$this->updatePostLikeMeta( $liked_users, $post_like_count );

			if ( \is_multisite() ) { // if multisite support
				// Add post ID to user meta
				// +1 count user meta
				$this->updateUserLikeOption( $liked_posts, $user_likes );

			} else {
				// Add post ID to user meta
				// +1 count user meta
				$this->updateUserLikeMeta( $liked_posts, $user_likes );
			}
			// update count on front end
			$this->response( 0, $post_like_count );
		} else { // like the post
			// Add user ID to post meta
			// +1 count post meta
			$this->updatePostLikeMeta( $liked_users, ++ $post_like_count );

			if ( \is_multisite() ) { // if multisite support
				// Add post ID to user meta
				// +1 count user meta
				$this->updateUserLikeOption( $liked_posts, $user_likes );

			} else {
				// Add post ID to user meta
				// +1 count user meta
				$this->updateUserLikeMeta( $liked_posts, $user_likes );
			}
			// update count on front end
			$this->response( 1, $post_like_count );
		}
	}

	/**
	 * subtraction like count
	 *
	 * @param integer $post_like_count post like count
	 *
	 * @return integer
	 * @access private
	 */
	private function subtractionLikeCount( $post_like_count ) {
		$like = (int) ( $post_like_count > 0 ? -- $post_like_count : 0 );

		return $like;
	}

	/**
	 *
	 * get user like meta
	 *
	 * @access private
	 * @return array
	 */
	private function getUserLikeMeta() {
		//check is multi site
		if ( \is_multisite() ) {
			$user_meta = \get_user_option( '_liked_posts', $this->user_id );
		} else {
			// post ids from user meta
			$user_meta = \get_user_meta( $this->user_id, '_liked_posts' );
		}

		if ( \count( $user_meta ) != 0 ) { // meta exists, set up values
			return $user_meta[0];
		}

		return $user_meta;
	}

	/**
	 * update user option data
	 *
	 * @param array $post_ids
	 * @param type  $user_likes_count
	 */
	private function updateUserLikeOption( array $post_ids, $user_likes_count ) {
		$data = array(
			'_liked_posts'     => $post_ids,
			'_user_like_count' => $user_likes_count,
		);
		foreach ( $data as $key => $value ) {
			if ( $value != '' ) {
				\update_user_option( $this->user_id, $key, $value );
			}
		}
	}

	/**
	 *
	 * update user meta data
	 *
	 * @param array $post_ids        array with post id
	 * @param array $user_like_count array with user like count
	 *
	 * @access private
	 */
	private function updateUserLikeMeta( array $post_ids, $user_like_count ) {
		$data = array(
			'_liked_posts'     => $post_ids,// Add post ID to user meta
			'_user_like_count' => $user_like_count,// +1 count user meta
		);
		foreach ( $data as $key => $value ) {
			\update_user_meta( $this->user_id, $key, $value );
		}
	}

	/**
	 *
	 * update post like meta box
	 *
	 * @param mixed $user_data       array with user ips or user ids array
	 * @param int   $post_like_count post like count
	 *
	 * @access private
	 */
	private function updatePostLikeMeta( $user_data, $post_like_count ) {
		if ( \is_user_logged_in() ) {
			$data = array(
				'_user_liked'      => $user_data,
				// Remove user ID from post meta
				'_post_like_count' => $post_like_count,
				// -1 count post meta
			);
		} else {
			$data = array(
				'_user_IP'         => $user_data,
				'_post_like_count' => $post_like_count
			);// Remove user IP from post meta
		}
		foreach ( $data as $key => $value ) {
			\update_post_meta( $this->post_id, $key, $value );
		}
	}

	/**
	 *
	 * Generate JSON response
	 *
	 * @param $already
	 * @param $post_like_count
	 *
	 * @return string
	 * @access   protected
	 */
	protected function response( $already, $post_like_count ) {
		$data = array(
			'already' => $already,
			'count'   => $post_like_count,
		);
		parent::responseJson( $data );
	}

	/**
	 *
	 * Test if current user already liked post
	 *
	 * @param int $post_id
	 *
	 * @access public
	 * @return bool
	 * @static
	 */
	public function isAlreadyLiked( $post_id ) {
		if ( is_user_logged_in() ) { // user is logged in
			$user_id     = get_current_user_id(); // current user
			// user ids from post meta
			$liked_users = get_post_meta( $post_id, '_user_liked', true );
			if ( \is_array( $liked_users )
			     && \array_search( $user_id, $liked_users ) !== false
			) {
				return true;
			}

		} else { // user is anonymous, use IP address for voting
			// get previously voted IP address
			$liked_ips = get_post_meta( $post_id, '_user_IP', true );
			// Retrieve current user IP
			if ( ( $ip = Filter::ip() ) !== false ) {
				if ( is_array( $liked_ips )
				     && array_search( $ip, $liked_ips ) !== false
				) { // True is IP in array
					return true;
				}
			}
		}

		return false;
	}

	/**
	 *
	 * get meta box data
	 *
	 * @param string  $key    meta box key name
	 * @param boolean $single if true data return only single array else multi array
	 *
	 * @return array
	 */
	private function getPostMeta( $key, $single = false ) {
		$post_meta = get_post_meta( $this->post_id, $key, $single );

		return $post_meta;
	}
}
