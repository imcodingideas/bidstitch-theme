<?php
    // Populate "Sellers of the Week" select on Homepage Settings page
    add_filter('acf/load_field/name=sellers_of_the_week', function($field) {
        global $wpdb;

        $choices = [];
        $term = get_term_by('slug', 'simple', 'product_type');

        $sql = <<<SQL
            SELECT
                p.post_author,
                COUNT(p.id) AS active_products
            FROM
                $wpdb->posts AS p
            INNER JOIN
                $wpdb->term_relationships AS r
            ON
                p.ID = r.object_id
            INNER JOIN
                $wpdb->postmeta AS m
            ON
                p.ID = m.post_id
            WHERE
                r.term_taxonomy_id = $term->term_id
            AND
                m.meta_key = '_stock_status'
            AND
                m.meta_value = 'instock'
            AND
                p.post_type = 'product'
            AND
                p.post_status = 'publish'
            GROUP BY
                p.post_author
            HAVING
                active_products > 2
            ORDER BY
                active_products DESC
SQL;

        $results = $wpdb->get_results($sql);

        foreach ($results as $result) {
            $store_info = dokan_get_store_info($result->post_author);
            $store_name = $store_info['store_name'];
            $choices[$result->post_author] = "$store_name ($result->active_products products)";
        }

        $field['choices'] = $choices;

        return $field;
    });
