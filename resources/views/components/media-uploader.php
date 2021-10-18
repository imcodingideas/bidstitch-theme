<?php
/**
 * @var $args array{
 * 'name' => string //Required,
 * 'args' => int[],
 * 'multiply' => boolean,
 * 'labelIdle' => string,
 * 'max_file_size' => string
 * };
 */

$files = (!empty($args['files'])) ? $args['files'] : [];
$multiple = (isset($args['multiple'])) ? $args['multiple'] : 'false';
$labelIdle = (!empty($args['labelIdle'])) ? $args['labelIdle'] : esc_html__('Please, upload file.');
$max_file_size = (!empty($args['max_file_size'])) ? $args['max_file_size'] : '3MB';

if (!empty($args['name'])): ?>

    <div class="filepond-container">

        <input type="file"
               class="filepond"
               name="filepond_<?php echo esc_js($args['name']); ?>"
               multiple="<?php echo esc_js($multiple); ?>"
               data-files="<?php echo esc_js(json_encode(\App\buildFileData($files))); ?>"
               data-allow-reorder="true"
               data-max-file-size="<?php echo $max_file_size; ?>"
               data-labelIdle="<?php echo esc_js($labelIdle) ?>">

    </div>

<?php endif;