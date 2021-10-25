<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class MediaUploader extends Component
{
    /**
     * The DOM name
     *
     * @var string
     */
    public $name;

    /**
     * The default files
     *
     * @var array
     */
    public $files;

    /**
     * The label for the upload UI
     *
     * @var string
     */
    public $label_idle;

    /**
     * The max size of the upload in Megabytes (MB)
     *
     * @var string
     */
    public $max_file_size;

    /**
     * The max number of files from user
     *
     * @var string
     */
    public $max_file_count;

    /**
     * Create the component instance.
     *
     * @param string $name
     * @param array $files
     * @param string $labelIdle
     * @param int $maxFileSize
     * @param int $maxFileCount
     * @return void
     */
    
    public function __construct(
        $name = '', 
        $files = [], 
        $labelIdle = 'Upload here', 
        $maxFileSize = 5,
        $maxFileCount = 7
    ) {
        $this->name = $name;
        $this->label_idle = $labelIdle;
        $this->files = $this->build_file_data($files);
        $this->max_file_size = $this->set_max_file_size($maxFileSize);
        $this->max_file_count = $maxFileCount;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */

    public function render() {
        return $this->view('components.media-uploader');
    }

    public function set_max_file_size($input_size = 5) {
        if (!is_numeric($input_size)) 
            $input_size = 5;

        $mega_byte = 1048576;
        $max_file_size = $mega_byte * $input_size;

        $formatted_size = size_format($max_file_size);

        return $formatted_size;
    }

    public function build_file_data($ids = []) {
        $data = [];

        foreach ($ids as $id) {
            $file_path = get_attached_file($id);

            $data[] = (object) [
                'source' => $id,
                'options' => (object) [
                    'type' => 'local',
                    'file' => (object) [ 
                        'name' => basename($file_path),
                        'size' => filesize($file_path),
                        'type' => get_post_mime_type($id)
                    ],
                    'metadata' => (object) [
                        'poster' => wp_get_attachment_url($id),
                    ],
                ]
            ];
        }

        return $data;
    }
}
