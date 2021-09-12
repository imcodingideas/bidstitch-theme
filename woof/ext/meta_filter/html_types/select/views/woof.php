<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<?php
global $WOOF;
$request = $WOOF->get_request_data();

$bidstitch_meta_key = apply_filters('bidstitch_products_filter_meta_key', $meta_key);

if ($bidstitch_meta_key) {
    $input_options = explode(',', $options['options']);

    $selected = isset($request[$meta_key]) ? $request[$meta_key] : '';

    $output_options = [];

    foreach ($input_options as $key => $option) {
        $parts = explode('^', $option);

        if (count($parts) > 1) {
            $output_options[] = (object) [
                'value' => $parts[1],
                'label' => $parts[0],
                'selected' => $selected && $selected === $parts[1],
            ];
        } else {
            $output_options[] = (object) [
                'value' => $key + 1,
                'label' => $option,
                'selected' => $selected && intval($selected) === $key + 1,
            ];
        }
    }

    $view_args = [
        'name' => $options['title'],
        'options' => $output_options,
        'key' => $meta_key,
    ];
    echo \Roots\view('woof.meta-select', $view_args)->render();
}

WOOF_META_FILTER_SELECT::render_html(WOOF_META_FILTER_SELECT::get_meta_filter_path() . '/views/woof.php', $data);