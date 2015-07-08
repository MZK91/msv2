$(document).ready(function(){
    $( ".cp_news" ).click(function() {
        parent.document.getElementById("thumbNews").value = $(this).attr('data-value');
    });
    $( ".cp_texte" ).click(function() {
        parent.tinymce.get('texte').execCommand('mceInsertContent',false,'<img src="'+$(this).attr('data-value')+'" alt="'+$(this).attr('data-title')+'" />');
    });
    $( ".cp_image" ).click(function() {
        parent.document.getElementById("image").value = $(this).attr('data-value');
        parent.document.getElementById("id_image").value = $(this).attr('data-id');
    });
});
