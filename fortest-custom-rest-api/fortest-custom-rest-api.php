<?php
/**
 * Plugin Name: Fortest Custom Rest Api
 * Description: plugin will add a new REST API endpoint. This endpoint should return a list of all published posts in JSON format
 * Author:      ме & Copilot
 *
 * Version:     1.0
 */

 add_action('rest_api_init', function () {
    register_rest_route('custom/v1', '/posts', array(
        'methods' => 'GET',
        'callback' => 'fortest_get_custom_posts',
        'args' => array(
            'category' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                },
            ),
            'tag' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_string($param);
                },
            ),
            'author' => array(
                'validate_callback' => function($param, $request, $key) {
                    return is_numeric($param);
                },
            ),
            'after' => array(
                'validate_callback' => function($param, $request, $key) {
                    return preg_match('/^\d{4}-\d{2}-\d{2}$/', $param);
                },
            ),
            'before' => array(
                'validate_callback' => function($param, $request, $key) {
                    return preg_match('/^\d{4}-\d{2}-\d{2}$/', $param);
                },
            ),
        ),
    ));
});

function fortest_get_custom_posts($data) {
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    if (!empty($data['category'])) {
        $args['category_name'] = sanitize_text_field($data['category']);
    }

    if (!empty($data['tag'])) {
        $args['tag'] = sanitize_text_field($data['tag']);
    }

    if (!empty($data['author'])) {
        $args['author'] = intval($data['author']);
    }

    if (!empty($data['after'])) {
        $args['date_query'][] = array(
            'after' => sanitize_text_field($data['after']),
            'inclusive' => true,
        );
    }

    if (!empty($data['before'])) {
        $args['date_query'][] = array(
            'before' => sanitize_text_field($data['before']),
            'inclusive' => true,
        );
    }

    $query = new WP_Query($args);
    $posts = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $posts[] = array(
                'title' => get_the_title(),
                'link' => get_permalink(),
                'date' => get_the_date(),
                'author' => get_the_author(),
                'categories' => get_the_category(),
                'tags' => get_the_tags(),
            );
        }
        wp_reset_postdata();
    } else {
        return new WP_Error('no_posts', 'No posts found', array('status' => 404));
    }

    return rest_ensure_response($posts);
}
