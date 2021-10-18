import * as FilePond from 'filepond';
import * as FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import * as FilePondPluginImageExifOrientation from 'filepond-plugin-image-exif-orientation';
import * as FilePondPluginFileValidateSize from 'filepond-plugin-image-transform';
import * as FilePondPluginImageEdit from 'filepond-plugin-file-validate-type';
import FilePondPluginFilePoster from 'filepond-plugin-file-poster';
import 'filepond-plugin-file-poster/dist/filepond-plugin-file-poster.css';

/**
 *
 * @var mediaUploaderData
 * @param mediaUploaderData.process_url: string
 * @param mediaUploaderData.revert_url: string
 * @param mediaUploaderData.load_url: string
 * @param mediaUploaderData.fetch_url: string
 *
 */

class MediaUploader {
    fileUploadInput;
    $fileUploadInput;
    fileUploadPond;
    loadedFiles;
    $hiddenInput;

    constructor(fileUploadInput) {
        this.fileUploadInput = fileUploadInput;
        this.$fileUploadInput = $(fileUploadInput);
        const loadedFiles = this.$fileUploadInput.data('files');
        this.loadedFiles = (loadedFiles) ? loadedFiles : [];

        this.register();
        this.attachHandler();
    }

    /**
     * Register FilePond Library with preview images, so we register:
     * the Image Preview plugin,
     * exif orientation (to correct mobile image orientation)
     * size validation, to prevent large files from being added
     *
     * @return void
     * */
    register() {
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginImageExifOrientation,
            FilePondPluginFileValidateSize,
            FilePondPluginImageEdit,
            FilePondPluginFilePoster
        );

        FilePond.setOptions({
            allowReorder: true,
            server: {
                process: {
                    url: mediaUploaderData.process_url,
                },
                revert: {
                    url: mediaUploaderData.revert_url,
                },
                load: {
                    url: mediaUploaderData.load_url,
                    method: 'POST'
                }
            },
            onreorderfiles : (files) => {
                this.updateFileList(files);
            }
        });
    }

    /**
     * We dont want to init every single input form with new class.
     * Just all of them with data attribute via loop
     *
     * @return void
     */
    attachHandler() {

        /**
         * Due to current upload with comma separated image ids,
         * we have to create additional hidden input, besides FilePond hidden input
         */
        this.createInput();

        const options = {
            credits: false,
            files: this.loadedFiles
        }

        const labelIdle = this.$fileUploadInput.attr('data-labelIdle');
        if (labelIdle) {
            options.labelIdle = `<span class='filepond--label-action'>${labelIdle}</span>`
        }

        this.fileUploadPond = FilePond.create(
            this.fileUploadInput,
            options
        );

        this.fileUploadPond.on('updatefiles', () => {
            this.updateFileList();
        })

        this.fileUploadPond.on('init', () => {
            this.updateFileList();
        })

        this.fileUploadPond.on('processfiles', () => {
            this.updateFileList();
        });

    }

    createInput() {
        this.$hiddenInput = $(`<input type="hidden" name="${this.getFileUploadName()}" />`);
        this.$hiddenInput.insertAfter(this.$fileUploadInput);
    }

    getFileUploadName() {
        return this.$fileUploadInput.attr('name').replace('filepond_', '');
    }

    updateFileList(files) {
        if(!files) files = this.fileUploadPond.getFiles();
        const fileIds = files.map((pondFile) => {
            return pondFile.serverId;
        })
        this.$hiddenInput.val(fileIds.join(','));
    }

}

(function ($) {
    $(document).ready(function () {
        $("input.filepond").each((index, fileUploadInput) => {
            new MediaUploader(fileUploadInput);
        })
    })
})(jQuery)