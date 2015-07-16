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
  Repository path: $HeadURL: https://svn.nq.pl/wordpress/branches/dynamite/igniter/wp-content/themes/igniter/lib/SilverWpAddons/Sidebar/Widget/RecentPosts.php $
  Last committed: $Revision: 2421 $
  Last changed by: $Author: padalec $
  Last changed date: $Date: 2015-02-11 16:40:28 +0100 (Śr, 11 lut 2015) $
  ID: $Id: RecentPosts.php 2421 2015-02-11 15:40:28Z padalec $
 */

namespace SilverWpAddons\Sidebar\Widget;

use SilverWpAddons\Db\Query;
use SilverWpAddons\Helper\Option;
use SilverWpAddons\MetaBox\Blog;
use SilverWpAddons\Sidebar\Widget\WidgetAbstract;
use SilverWpAddons\Translate;

/**
 * Recent Posts Wiget
 *
 * @author Michal Kalkowski <michal at silversite.pl>
 * @version $Id: RecentPosts.php 2421 2015-02-11 15:40:28Z padalec $
 * @category WordPress
 * @package SilverWpAddons
 * @subpackage Sidebar\Widget
 * @copyright (c) 2009 - 2014, SilverSite.pl
 */

class RecentPosts extends WidgetAbstract
{
    public function __construct()
    {
        // Configure widget array
        $args = array(
            'name'          => 'custom-recent-posts',
            // Widget Backend label
            'label'         => Translate::translate('Recent Posts with Image'),
            // Widget Backend Description
            'description'   => Translate::translate('Blog posts with images from selected categories.'),
            'options' => array(
                'classname' => 'widget_recent_posts_with_image',
            )
        );
        // Configure the widget fields
        // Example for: Title ( text ) and Amount of posts to show ( select box )
        // fields array
        $args['fields'] = array(
            // Title field
            array(
                'name'      => Translate::translate('Title'),
                'id'        => 'title',
                'type'      => 'text',
                'class'     => 'widefat',
                'validate'  => 'alpha_numeric',
                'filter'    => 'strip_tags|esc_attr',
                'std'       => Translate::translate('Recent Posts With Image'),
            ),
            array(
                'name'      => Translate::translate('Number of posts to show'),
                'id'        => 'number',
                'type'      => 'number',
                'class'     => 'widefat',
                'std'       => 5,
                'validate'  => 'numeric',
            ),

            array(
                'name'      => Translate::translate('Display post date'),
                'id'        => 'show_date',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info' ),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Display post author'),
                'id'        => 'show_author',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info' ),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Display post category'),
                'id'        => 'show_category',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info' ),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Display post image'),
                'id'        => 'show_image',
                'type'      => 'checkbox',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info' ),
                //'validate'  => 'boolean',
            ),
            array(
                'name'      => Translate::translate('Categories'),
                'id'        => 'cats',
                'type'      => 'category_cb',
                'class'     => 'widefat',
                //'std' => Translate::translate('Company Info' ),
                //'validate'  => 'boolean',
            ),

            // add more fields
        ); // fields array
        // create widget
        $this->createWidget($args);
    }
    public function widget($args, $instance)
    {
        $title = empty($instance['title'])
                ? Translate::translate('Recent Posts with Image')
                : $instance['title'];
        \apply_filters('widget_title', $title, $instance, $this->id_base);

        $show_date = isset($instance['show_date']) ? $instance['show_date'] : false;
        $show_author = isset($instance['show_author']) ? $instance['show_author'] : false;
        $show_category = isset($instance['show_category']) ? $instance['show_category'] : false;
        $show_image = isset($instance['show_image']) ? $instance['show_image'] : false;

        $BlogMB = Blog::getInstance();

        // array to call recent posts.
        $query_args = array(
            'showposts'     => $instance['number'] ? absint($instance['number']) : 5,
            'category__in'  => $instance['cats'] ? $instance['cats'] : '',
            'ignore_sticky_posts' => true,
        );

        $wp_query = new Query($query_args);

        echo $args['before_widget'];
        // Widget title
        echo $args['before_title'];
        echo $instance['title'];
        echo $args['after_title'];

        // Post list in widget
        echo '<ul class="wrapper-list">';

        while ($wp_query->have_posts()) {
            $wp_query->the_post();
            $href_title  = Translate::translate('Permanent link to ');
            $href_title .= \the_title_attribute(array( 'echo' => false ));

            $type = $BlogMB->setPostId($wp_query->post->ID)->getPostFormat();

            if ($type === 'link') {
                $link = $BlogMB->getSingle('link', $wp_query->post->ID);
                $url = \esc_url($link['post_format_link']);
            } else {
                $url = get_permalink();
            }
            ?>
            <li><a href="<?php echo $url ?>" rel="bookmark" title="<?php echo $href_title  ?>" class="fade-hover-effect">
                <div class="row">
            <?php
            if ($show_image) :
                    ?>
                    <div class="col-xs-4 col-img">
                        <div class="circle-border circle-border-img">
                        <?php
                        if (($image_html = \get_the_post_thumbnail($wp_query->post->ID, 'post-thumbnail'))):
                            echo $image_html;
                        elseif ($type === 'video'):
                            $video = $BlogMB->getVideo();
                        ?>
                            <img class="wp-post-image" src="<?php echo esc_attr($video['video_thumbnail_url']) ?>" alt="" />
                        <?php
                        endif;
                        ?>
                        </div>
                        <?php
                        switch ($type) {
                            case 'link':
                                $fa_icon = 'share-square-o';
                                break;
                            case 'quote':
                                $fa_icon = 'quote-right';
                                break;
                            case 'gallery':
                                $fa_icon = 'picture-o';
                                break;
                            case 'video':
                                $fa_icon = 'video-camera';
                                break; // fa-play
                            default:
                                $fa_icon = 'link';
                                break; // 'post'
                        }
                        ?>
                    </div>
                    <?php endif; ?>
                    <div class="col-xs-<?php if ($show_image): ?>8<?php else: ?>12<?php endif; ?>">
                        <strong><?php \the_title() ?></strong>
                        <?php
                        if ($show_date) :
                            $timeClassCss = Option::get_theme_option('friendly_date_format') === '1' ? 'cutetime published' : 'published';
                            ?><time class="<?php echo $timeClassCss ?>" datetime="<?php echo get_the_time('c') ?>"><?php echo get_the_date() ?></time><?php
                        endif;

                        if ($show_category) {
                            $categories = get_the_category();
                            $separator = ', ';
                            $output = '';
                            if ($categories) {
                                foreach ($categories as $category) {
                                    //$output .= '<a href="'.get_category_link( $category->term_id ).'" ';
                                    //$output .= 'title="' . esc_attr( _params( 'View all posts in %s', $category->name ) ) . '">';
                                    //$output .= $category->cat_name.'</a>';
                                    if ($category->term_taxonomy_id !== 1) { // term_taxonomy_id === 1 (no category)
                                        $output .= $category->cat_name;
                                        $output .= $separator;
                                    }
                                }
                                echo $output ? sprintf(Translate::translate('in %s '), trim($output, $separator)) : '';
                            }
                        }

                        if ($show_author) :?>
                                        <div class="author"><?php echo get_the_author(); ?></div>
                            <?php
                        endif;
                        ?>
                    </div>
                </div>
            </a></li>
            <?php
        }

        \wp_reset_query();

        echo '</ul>';
        echo $args['after_widget'];
    }
}
