<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crop img</title>
    {{-- Bootstrap styles --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/sweetalert2.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}"> --}}
    {{-- <link href="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.css" rel="stylesheet" />

    <script src="https://cdn.datatables.net/v/dt/dt-1.13.4/datatables.min.js"></script> --}}
</head>
<body>
    <div class="container" align="center">
        <br>
        <h3 align="center">Crop Image</h3>
        <br>
        <div class="row">
            <div class="col-md-4">&nbsp;</div>
            <div class="col-md-4">
                <div class="imgage_area">
                    <form method="post">
                        <label for="upload_image">
                            <img src="" id="uploaded_image" class="img-responsive img-circle">
                            <div class="overlay">
                                <div class="text">Change your DP</div>
                            </div>
                            <input type="file" name="image" id="upload_imgae" class="image" style="display: none;">
                        </label>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Image Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img src="" id="sample_image">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="crop" class="btn btn-primary">Crop</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap scripts --}}
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-3.6.3.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var $modal = $('.modal');
            var image = $('#sample_image');
            var cropper;
            $('#upload_image').change(function(event) {
                var files = event.target.files;

                var done = function(url) {
                    image.src = url;
                    $modal.modal('show');
                };

                if (files && files.length > 0) {
                    reader = new FileReader();
                    reader.onload = function(event) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(files[0]);
                }
            });
            $modal.on('shown.bs.modal', function() {
                cropper = new Cropper(image, {
                    aspectRatio: 1
                    , viewMode: 3
                    , preview: '.preview'
                });
            }).on('hidden.bs.modal', function() {
                cropper.destroy();
                cropper = null;
            });
            $('#crop').click(function() {
                canvas = cropper.getCroppedCanvas({
                    width: 400
                    , height: 400
                });

                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function(){
                        var base64data = reader.result;
                        $.ajax({
                            url: '/crop-img',
                            method: 'POST',
                            data:{image:base64data},
                            success:function(data){
                                $modal.modal('hide');
                                $("#uploaded_image").attr('src', data);
                            }
                        });
                    }
                });
            });
        });

    </script>
</body>
</html>
