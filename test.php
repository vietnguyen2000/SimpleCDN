<!DOCTYPE html>
<html>

<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>

<body>

    <form enctype="multipart/form-data" id="formUpload">
        Select image to upload:
        <input type="file" name="image" id="image">
        <input type="submit" value="Upload Image" name="submit">
    </form>
    <p id="response"></p>
    <img id="img" />


    <script>
        $(document).ready(function() {
            $('#formUpload').on('submit', function(e) {
                e.preventDefault();
                upload();
            })
        })

        function upload() {
            var fd = new FormData();
            var files = $('#image')[0].files;

            // Check file selected or not
            if (files.length > 0) {
                fd.append('image', files[0]);

                $.ajax({
                    url: 'upload.php',
                    type: 'post',
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success != 0) {
                            $('#response').html('response: ' + JSON.stringify(response))
                            $("#img").attr("src", response.message);
                            $(".preview img").show(); // Display image element
                        } else {
                            alert('file not uploaded');
                        }
                    },
                });
            } else {
                alert("Please select a file.");
            }
        }
    </script>
</body>

</html>