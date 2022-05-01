<script>
    $(document).ready(function() {
        $(document).on('click', '#admin-crud-form-btn-back', function(e) {
            e.preventDefault()
            let $form = $(this).closest('form');
            let $cloneForm = $('<form class="hidden" method="POST"></form>')
            $cloneForm.append('<input type="hidden" name="form_back" value="true"/>')
            $cloneForm.append($form.find('input[name="_token"]'))
            $cloneForm.attr('action', $form.attr('action'))
            $('body').append($cloneForm)
            $cloneForm.submit()
        });

        // $('.summernote').summernote({
        //     toolbar: [
        //         ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
        //         ['font', ['strikethrough', 'superscript', 'subscript']],
        //         ['insert', ['picture']],
        //         ['view', ['fullscreen', 'codeview', 'help']]
        //     ],
        //     height: 300,
        //     fontSize: 24,
        //     lang: "ja-JP",
        // });

        $('.summernote').summernote({
            toolbar: [
                ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['mybutton', ['imageUp']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            styleTags: ['p', 'h2', 'h3', 'h4'],
            height: 500,
            fontSize: 24,
            lang: "ja-JP",
            dialogsInBody: true,
            buttons: {
                imageUp: function(context) {
                    var ui = $.summernote.ui;
                    var button = ui.button({
                        contents: '<i class="note-icon-picture"/>',
                        tooltip: '画像',
                        click: function() {
                            context.invoke('editor.saveRange');
                            $('#addDataImageEditor').modal('show');

                            $('#upload-image-modal-editor').change(function() {
                                $('#image-name-modal-editor').val(this.files[0]
                                    .name);
                            });

                            $('#submit-modal-image-editor').click(function(event) {
                                let file = $('#upload-image-modal-editor').prop(
                                    'files')[0];
                                sendFile(file, context);
                                $('#addDataImageEditor').modal('toggle');
                                $('#form-image-editor').trigger('reset');
                                // duplicate click event so remove click event after image is render
                                $('#submit-modal-image-editor').off('click');
                            });
                        }
                    });

                    return button.render();
                }
            },
            callbacks: {
                onImageUpload: function(files) {
                    var $this = $(this);
                    sendFile(files[0], function(url) {
                        $this.summernote("insertImage", url);
                    });
                },
                onPaste: function(e) {
                    var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData)
                        .getData('text/html');
                    if (bufferText) {
                        e.preventDefault();
                        var div = $('<div />');
                        div.append(bufferText);
                        div.find('*').removeAttr('style');
                        setTimeout(function() {
                            document.execCommand('insertHtml', false, div.html());
                        }, 10);
                    }
                }
            },
            onInit: function() {
                $('body > .note-popover').hide();
            },
        });

        function sendFile(file, context = null) {
            var form_data = new FormData();
            form_data.append('file', file);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data,
                type: "POST",
                url: '/admin/posts/upload/image',
                cache: false,
                contentType: false,
                processData: false,
                success: function(filename) {
                    const image = $('<img>').attr('src', filename).addClass("img-fluid");
                    if (context) {
                        context.invoke('editor.restoreRange');
                        context.invoke('editor.insertNode', image[0])
                    } else {
                        $('.summernote').summernote("insertNode", image[0]);
                    }
                },
                error: function(data) {
                    console.log("失敗");
                }
            });
        }


    })
</script>

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/lang/summernote-ja-JP.js">
</script>

<div class="modal fade" id="addDataImageEditor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">画像挿入設定</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-image-editor">
                    <div class="form-group">
                        <label for="image" class="col-form-label">画像ファイルを選択</label>
                        <input type="text" class="form-control" id="image-name-modal-editor" readonly
                            style="background-color: #fff">
                        <input type="file" id="upload-image-modal-editor" hidden />
                        <label for="upload-image-modal-editor" class="lable-upload-modal">参照</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="justify-content: flex-start;">
                <button type="button" class="btn btn-primary" id="submit-modal-image-editor">画像挿入</button>
            </div>
        </div>
    </div>
    <style>
        .lable-upload-modal {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 0.2rem 2rem;
            border-radius: 0.3rem;
            cursor: pointer;
            margin-top: 1rem;
            font-weight: inherit !important;
        }

    </style>
</div>
