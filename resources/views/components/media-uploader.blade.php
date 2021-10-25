<div class="filepond-container">
    <input type="file"
        class="filepond"
        name="filepond_{!! esc_js($name) !!}"
        data-files="{!! esc_js(json_encode($files)) !!}"
        data-allow-reorder="true"
        data-max-file-size="{!! esc_js($max_file_size) !!}"
        data-labelIdle="{!! esc_js($label_idle) !!}"
        data-max-files="{!! esc_js($max_file_count) !!}"
        {{ $attributes }}
    >
</div>