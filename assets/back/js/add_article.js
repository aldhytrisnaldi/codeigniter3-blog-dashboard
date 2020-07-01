$(function(){
    $('#description').summernote();
})
function imagesPreview(images,idpreview)
{
    var gb = images.files;
    for (var i = 0; i < gb.length; i++)
    {
        var gbPreview = gb[i];
        var imageType = /image.*/;
        var preview=document.getElementById(idpreview);
        var reader = new FileReader();
        if (gbPreview.type.match(imageType))
        {
            preview.file = gbPreview;
            reader.onload = (function(element)
            {
                return function(e)
            {
                element.src = e.target.result;
            };
            })(preview);
            reader.readAsDataURL(gbPreview);
        }
        else
        {
            alert("File type must jpg, jpeg or png");
        }
    }
}