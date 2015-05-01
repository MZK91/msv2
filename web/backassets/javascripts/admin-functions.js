function ucfirst (str) {
    var f = str.charAt(0).toUpperCase();
    return f + str.substr(1);
}
function trim(aString) {
    var regExpBeginning = /^\s+/;
    var regExpEnd = /\s+$/;
    return aString.replace(regExpBeginning, "").replace(regExpEnd, "");
}

function autoAdjustTitre(){
    var_titre = document.getElementById("titre").value;
    var_titre = var_titre.replace(/–/, '-');
    var_titre = var_titre.replace(/ +/g, ' ');
    var_titre = trim(var_titre);
    var_titre = ucfirst(var_titre);
    document.getElementById("titre").value = var_titre;
    tab = var_titre.split(' - ');
    document.getElementById("titre").value = ucfirst(trim(tab[0]))+' - '+ucfirst(trim(tab[1]));
    document.getElementById("artiste").value = ucfirst(trim(tab[0]));
    document.getElementById("son").value = ucfirst(trim(tab[1]));
}

function inverse() {
    var_titre = document.getElementById("titre").value;
    var_titre = var_titre.replace(/–/, '-');
    tab = var_titre.split(' - ');
    document.getElementById("titre").value = ucfirst(trim(tab[1])) + ' - ' + ucfirst(trim(tab[0]));
}
function search_rapgenius(){
    var_titre = document.getElementById('titre').value;
    var_titre = var_titre.replace(/ /,'+');
    var_titre = var_titre.replace(/\&/,'');
    var_titre = var_titre.replace(/\(.+\)/,'');
    window.open("http://rapgenius.com/search?hide_unexplained_songs=false&q="+var_titre+"");
}
function search_lyrics(){

    var_titre = document.getElementById('titre').value;
    var_titre = var_titre.replace(/\&| /,'+');
    var_titre = var_titre.replace(/\(.+\)/,'');
    artiste_article = document.getElementById("artiste").value;
    titre_son_article = document.getElementById("son").value;
    artiste_article = artiste_article.replace(/\&| /,'+');
    titre_son_article = titre_son_article.replace(/\&| /,'+');
    window.open("http://www.google.fr/search?q="+var_titre+"+lyrics#q=%22"+artiste_article+"%22%2B%22"+titre_son_article+"%22%2B%22lyrics%22");
}
function featuring(){
    feat_artiste_article = '';
    feat_titre_son_article = '';
    artiste_article = document.getElementById("artiste").value;
    titre_son_article = document.getElementById("son").value;

    if(artiste_article.match(/\(|\)/)){
        feat_artiste_article = artiste_article.replace(/(.*)(\(.+\))/,'$2');
        feat_artiste_article = trim(feat_artiste_article.replace(/\(|\)/gm,""));
        feat_artiste_article = trim(feat_artiste_article.replace(/feat\. |ft\. |featuring |ft |feat |f\. |featuring: /gmi,""));
    }
    if(titre_son_article.match(/\(|\)/)){
        feat_titre_son_article = titre_son_article.replace(/(.*)(\(.+\))/,'$2');
        feat_titre_son_article = trim(feat_titre_son_article.replace(/\(|\)/gm,""));
        feat_titre_son_article = trim(feat_titre_son_article.replace(/feat\. |ft\. |featuring |ft |feat |f\. |featuring: /gmi,""));
    }
    document.getElementById("featuring").value = ucfirst(trim(feat_artiste_article+' '+feat_titre_son_article));
    document.getElementById("artiste").value = document.getElementById("artiste").value.replace(/(.*)(\(.+\))/,'$1');
    document.getElementById("son").value = document.getElementById("son").value.replace(/(.*)(\(.+\))/,'$1');
}
function inverse(){
    var_titre = document.getElementById("titre").value;
    var_titre = var_titre.replace(/–/, '-');
    tab = var_titre.split(' - ');
    document.getElementById("titre").value = ucfirst(trim(tab[1]))+' - '+ucfirst(trim(tab[0]));
    /*var url = 'admin_img_article.php?search='+document.getElementById('artiste').value;
    window.frames['frame_img_article'].location.href = url;
    window.frames['frame_img_article'].document.getElementById("titre_complet_son").value = document.getElementById("artiste_article").value;
    */
}
function vire(){
    var_titre = document.getElementById("titre").value;
    var_titre = var_titre.replace(/–/g, '-');
    var_titre = var_titre.replace(/_/g, ' ');
    var_titre = var_titre.replace(/\[/g, '(');
    var_titre = var_titre.replace(/\]/g, ')');
    var_titre = var_titre.replace(/“/g, '');
    var_titre = var_titre.replace(/”/g, '');
    var_titre = var_titre.replace(/"/g, '');
    var_titre = var_titre.replace(/'/g, '');
    document.getElementById("titre").value = var_titre;
    autoAdjustTitre();
}
function clean(){
    var_titre = document.getElementById("titre").value;
    var_titre = var_titre.replace(/–/g, '-');
    var_titre = var_titre.replace(/_/g, ' ');
    var_titre = var_titre.replace(/\[/g, '(');
    var_titre = var_titre.replace(/\]/g, ')');
    var_titre = var_titre.replace(/“/g, '');
    var_titre = var_titre.replace(/”/g, '');
    var_titre = var_titre.replace(/"/g, '');
    var_titre = var_titre.toLowerCase();
    val = var_titre;
    newVal = '';
    val = val.split(' ');
    for(var c=0; c < val.length; c++) {
        newVal += val[c].substring(0,1).toUpperCase() + val[c].substring(1,val[c].length) + ' ';
    }
    var_titre = newVal;
    document.getElementById("titre").value = var_titre;
    autoAdjustTitre();
}
function cleanFin(){
    var_titre = document.getElementById("titre").value;
    var_titre = var_titre.replace(/"/gmi,'');
    var_titre = trim(var_titre.replace(/(.+)[\(\[\{\|](.+)/,"$1"));
    document.getElementById("titre").value = var_titre;
    autoAdjustTitre();
}

function rebuild() {
    artiste = trim(document.getElementById("artiste").value);
    titre = trim(document.getElementById("titre").value);
    featuring = trim(document.getElementById("featuring").value);
    document.getElementById("titre").value = '';
    document.getElementById("titre").value = artiste + ' - ' + titre + ' (ft. ' + featuring + ')';
}

function featuring(){
    feat_artiste_article = '';
    feat_titre_son_article = '';
    artiste_article = document.getElementById("artiste").value;
    titre_son_article = document.getElementById("titre").value;

    if(artiste_article.match(/\(|\)/)){
        feat_artiste_article = artiste_article.replace(/(.*)(\(.+\))/,'$2');
        feat_artiste_article = trim(feat_artiste_article.replace(/\(|\)/gm,""));
        feat_artiste_article = trim(feat_artiste_article.replace(/feat\. |ft\. |featuring |ft |feat |f\. |featuring: /gmi,""));
    }
    if(titre_son_article.match(/\(|\)/)){
        feat_titre_son_article = titre_son_article.replace(/(.*)(\(.+\))/,'$2');
        feat_titre_son_article = trim(feat_titre_son_article.replace(/\(|\)/gm,""));
        feat_titre_son_article = trim(feat_titre_son_article.replace(/feat\. |ft\. |featuring |ft |feat |f\. |featuring: /gmi,""));
    }
    document.getElementById("featuring").value = ucfirst(trim(feat_artiste_article+' '+feat_titre_son_article));
    document.getElementById("artiste").value = document.getElementById("artiste").value.replace(/(.*)(\(.+\))/,'$1');
    document.getElementById("son").value = document.getElementById("son").value.replace(/(.*)(\(.+\))/,'$1');
}

function featEnd(){
    //var regex = "/feat\.(.+)$|ft\.(.+)$|featuring(.+)$|ft(.+)$|feat(.+)$|f\.(.+)$/";
    content =  document.getElementById("titre").value;
    content = trim(content.replace(/(feat\. |ft\. |featuring |ft |feat |f\. |featuring: )(.+)/gmi,"(ft. $2)"));
    document.getElementById("titre").value = content;
   /* if(document.getElementById("image").value == ''){
        var url = 'admin_img_article.php?search='+document.getElementById('artiste_article').value;
        //alert(url);
        window.frames['frame_img_article'].location.href = url;
        window.frames['frame_img_article'].document.getElementById("titre_complet_son").value = document.getElementById("artiste_article").value;
    }
    */
}

function featStart(){
    content =  document.getElementById("titre").value;
    content = trim(content.replace(/(.+)(feat\. |ft\. |featuring |ft |feat |f\. |featuring: )(.+)-(.+)/gmi,"$1-$4 (ft. $3)"));
    document.getElementById("titre").value = content;
    if(document.getElementById("image").value == ''){
        var url = 'admin_img_article.php?search='+document.getElementById('artiste').value;
        //alert(url);
        window.frames['frame_img_article'].location.href = url;
        window.frames['frame_img_article'].document.getElementById("son").value = document.getElementById("artiste").value;
    }
}



function youtubeimg(){
    lien_img = document.getElementById("img_url").value;
    lien_img = lien_img.replace(/(.+?v=)/, '');
    lien_img =  lien.replace(/(&.+|#.+)/,'');
    lien_img = 'http://i3.ytimg.com/vi/'+lien_img+'/default.jpg';
    document.getElementById("img_url").value = lien_img;
}
function vimeoAuto(popup){
    lien =  document.getElementById("media_article").value;
    lien_old = lien;
    lien = lien.replace(/http(s)?:\/\/vimeo.com\/|http(s)?:\/\/www\.vimeo.com\//, '');
    lien = lien.replace(/[\S\s].*?video\/([a-z0-9_-]*)[^a-z0-9_-].+[\S\s]*?/i,'$1');
    idvid = lien;
    $.ajax({
        method: "get", url: "ajax/vimeo.php",data: { id : idvid },
        success: function(html){
            document.getElementById("img_url").value = html;
        }
    }); //close $.ajax(

    lien_media = '[vimeo]'+idvid+'[/vimeo]';
    document.getElementById("media_article").value = lien_media;
    if(popup ==1){
        window.open(lien_old,'mywindow','width=900,height=600');
    }
    copie();
}

function hulkshareAuto(popup){
    lien =  document.getElementById("media_article").value;
    lien = lien.replace(/http:\/\/hulkshare.com\/|http:\/\/www\.hulkshare.com\//, '');
    idvid = lien;
    lien_media = '<embed width=\"500\" height=\"30\" flashvars=\"skin=http://static.hulkshare.com/mediaplayer/stylish_slim.swf&amp;backcolor=292929&amp;lightcolor=D60041&amp;file=http://new.hulkshare.com/stream/'+idvid+'.mp3\" wmode=\"opaque\" allowscriptaccess=\"always\" allowfullscreen=\"true\" quality=\"high\" name=\"mpl\" id=\"mpl\" src=\"http://static.hulkshare.com/mediaplayer/player.swf\" type=\"application/x-shockwave-flash\">';
    document.getElementById("media").value = lien_media;

}
function sharebeastAuto(popup){
    lien =  document.getElementById("media_article").value;
    lien = lien.replace(/[\s\S]*.+file=([a-zA-Z0-9_-]*)&.+[\s\S]*/i,'$1');
    idvid = lien;
    lien_media = '<iframe src="http://emd.sharebeast.com/embed.php?type=sharebeast&file='+idvid+'&width=100%" scrolling="no" frameborder="0" allowTransparency="true" style="width:100%;height:50px;"></iframe>';
    document.getElementById("media").value = lien_media;
}
function soundcloudAuto(popup){
    lien =  document.getElementById("media_article").value;
    lien = lien.replace(/[\s\S]*.+tracks(%|\/)([a-zA-Z0-9]*)(&|"|%3F).+[\s\S]*/i,'$2');
    idvid = lien;
    lien_media = '<iframe width="100%" height="450" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'+idvid+'&amp;auto_play=true&amp;visual=true"></iframe>';
    document.getElementById("media").value = lien_media;
}
function audiomackAuto(popup){
    iframe();
    lien =  document.getElementById("media_article").value;
    lien = lien.replace(/\?[a-zA-Z0-9\=&;]+"/i,'"');
    document.getElementById("media").value = lien;
    mediaAuto();
}


function youtubeAuto(popup){

    lien =  document.getElementById("media").value;

    lien = lien.replace(/[\s\S]*.+video_id=([a-zA-Z0-9_-]*)&.+[\s\S]*/i,'$1');
    lien = lien.replace(/[\S\s].*?embed\/([a-z0-9_-]*)[^a-z0-9_-].+[\S\s]*?/i,'$1');
    lien = lien.replace(/(.+?v=|.+\/v\/)/,'');
    lien =  lien.replace(/(&.+|#.+)/,'');
    lien =  lien.replace(/.+youtu\.be\//,'');
    idvid = lien;

    var base_url = $("#media_auto").attr("data-youtube");
    ajax_url = base_url+"/"+idvid;

    $.ajax({
        type: "GET",
        url: ajax_url,
        dataType: "xml",
        success: function(xml) {
            $(xml).find('videos').each(function () {
                document.getElementById("titre").value = $(this).find('Title').text();
                document.getElementById("image").value = $(this).find('Image').text();
            });
        },
        error: function() {
            alert("The XML File could not be processed correctly.");
        }
    });

    //document.getElementById("img_url").value = lien_img;
    lien_media = '[youtube]'+idvid+'[/youtube]';
    document.getElementById("media").value = lien_media;
    lien = 'http://www.youtube.com/watch?v='+idvid;
    if(popup == 1){
        window.open(lien,'mywindow','width=900,height=600');
    }

}

function dailyAuto(popup) {
    lien =  document.getElementById("media").value;
    if(!lien.match('/embed/')){
        lien = lien.replace(/.+video\//,'');
        lien =  lien.replace(/_.+/,'');
        idvid = lien;

        var base_url = $("#media_auto").attr("data-dailymotion");
        ajax_url = base_url+"/"+idvid;

        $.ajax({
            type: "GET",
            url: ajax_url,
            dataType: "xml",
            success: function(xml) {
                $(xml).find('videos').each(function () {
                    document.getElementById("titre").value = $(this).find('Title').text();
                    document.getElementById("image").value = $(this).find('Image').text();
                });
            },
            error: function() {
                alert("The XML File could not be processed correctly.");
            }
        });
        lien_media = '[dailymotion]'+idvid+'[/dailymotion]';
        document.getElementById("media").value = lien_media;
        lien = 'http://www.dailymotion.com/video/'+idvid;
        if(popup ==1){
            window.open(lien,'mywindow','width=900,height=500');
        }
    }

}

function vimeoAuto(popup){
    lien =  document.getElementById("media").value;
    lien_old = lien;
    lien = lien.replace(/http(s)?:\/\/vimeo.com\/|http(s)?:\/\/www\.vimeo.com\//, '');
    lien = lien.replace(/[\S\s].*?video\/([a-z0-9_-]*)[^a-z0-9_-].+[\S\s]*?/i,'$1');
    idvid = lien;

    var base_url = $("#media_auto").attr("data-vimeo");
    ajax_url = base_url+"/"+idvid;

    $.ajax({
        type: "GET",
        url: ajax_url,
        dataType: "xml",
        success: function(xml) {
            $(xml).find('videos').each(function () {
                document.getElementById("titre").value = $(this).find('Title').text();
                document.getElementById("image").value = $(this).find('Image').text();
            });
        },
        error: function() {
            alert("The XML File could not be processed correctly.");
        }
    });

    lien_media = '[vimeo]'+idvid+'[/vimeo]';
    document.getElementById("media").value = lien_media;
    if(popup ==1){
        window.open(lien_old,'mywindow','width=900,height=600');
    }
    copie();
}


function exp_reg(){
    var regex = document.getElementById("regex").value;
    var reg = new RegExp(regex, "gm");
    var remplac = document.getElementById("remplac").value;
    content =  tinymce.get('texte').getContent();
    content = content.replace(reg,remplac);
    document.getElementById("texte").value = content;
    tinymce.get('texte').setContent(content);
}
function hq(){
    lien_img = document.getElementById("image_panell").value;
    lien_img = lien_img.replace(/(\/default.jpg)/, '/hqdefault.jpg');
    lien_img = lien_img.replace(/(jpeg_preview_small)/,'jpeg_preview_large');
    lien_img = lien_img.replace(/(jpeg_preview_medium)/,'jpeg_preview_large');
    lien_img = lien_img.replace(/vimeocdn\.com\/(.+)\/(.+)\/(.+)\/(.+)_.+.jpg/,'vimeocdn.com/$1\/$2/$3/$4_640.jpg');
    document.getElementById("image_panell").value = lien_img;
}
function mediaAuto(popup){
    lien =  document.getElementById("media").value;
    patt=/dailymotion/g;
    if(patt.test(lien)){
        dailyAuto(popup);
    }
    patt=/youtube|youtu\.be|ytimg\.com/g;
    if(patt.test(lien)){
        youtubeAuto(popup);
    }
    patt=/vimeo/g;
    if(patt.test(lien)){
        vimeoAuto(popup);
    }
    patt=/sharebeast/g;
    if(patt.test(lien)){
        sharebeastAuto(popup);
    }
    patt=/soundcloud/g;
    if(patt.test(lien)){
        soundcloudAuto(popup);
    }
    patt=/audiomack/g;
    if(patt.test(lien)){
        audiomackAuto(popup);
    }
}

function display_img(){
    var image = document.getElementById("image").value;
    $("#preview_img").empty().append( $('<img />', { src: image , height:'80' , width: '120' }));
}

function preview_media(){
    var url = $("#preview_media_button").attr("data-media");
    if ($('#preview_media').is(':empty')) {
        $.post(url, { media: $('#media').val() },
            function(html){
                if($('#preview_media').val() == ""){
                    $("#preview_media").html(html);
                }else{
                    $("#preview_media").hide("slow");
                    $("#preview_media").empty();
                    $("#preview_media").html(html);
                    $("#preview_media").show("slow");
                }
            });
    }else{
        $("#preview_media").empty();
    }
}
function adjust(){
    var val = document.getElementById("media_article").value;
    val = val.replace(/(.+<object|.+<(\s+)object)/, '<object');
    val = val.replace(/(<\/object>.+|<\/\s+object>.+)/, '</object>');
    val = val.replace(/(width=\"|width=\')([0-9]+)(\"|\')/gi, 'width="640"');
    val = val.replace(/(height=\"|height=\')([0-9]+)(\"|\')/gi, 'height="360"');
    document.getElementById("media_article").value = val;
    //alert('Média Ajuster');
}
function same_artiste(){
    var url = $("#mm_artiste").attr("data-url");
    var type = $("#mm_artiste").attr("data-type");
    if ($('#same_artiste').is(':empty')) {
        $.ajax({
            type: "POST",
            url: url,
            data: 'find=' + $('#artiste').val(),
            dataType: "xml",
            success: function (xml) {
                $(xml).find('item').each(function () {
                    $('#same_artiste').append('<p><a href="http://www.muzikspirit.com/' + type + '/' + $(this).find('slug').text() + '/' + $(this).find('id').text() + '">' + $(this).find('titre').text() + '</a></p>');
                });
            },
            error: function () {
                alert("The XML File could not be processed correctly.");
            }
        });
    }else{
        $("#same_artiste").empty();
    }
}

function miniature(){
    var artiste = $('#artiste').val();
    var url = $("#miniature").attr("data-url");
    var image = path = '';
    if ($('#image').is(':empty')) {
        $.ajax({
            type: "POST",
            url: url,
            data: 'find=' + $('#artiste').val(),
            dataType: "xml",
            success: function (xml) {
                $(xml).find('item').each(function () {
                    image = $(this).find('image').text();

                        $(xml).find('typeImage').each(function () {
                           path = $(this).find('path').text();
                        });
                });
                $('#image').val('http://www.muzikspirit.com/'+path+image);
            },
            error: function () {
                alert("The XML File could not be processed correctly.");
            }
        });
    }
}

$(document).ready(function(){
    $( "#titre" ).blur(function() {
        autoAdjustTitre();
    });
    $( "#genius" ).click(function() {
        search_rapgenius();
    });
    $( "#lyrics" ).click(function() {
        search_lyrics();
    });
    $( "#inverse" ).click(function() {
        inverse();
    });
    $( "#vire" ).click(function() {
        vire();
    });
    $( "#clean" ).click(function() {
        clean();
    });
    $( "#feat_start" ).click(function() {
        featStart();
    });
    $( "#feat_end" ).click(function() {
        featEnd();
    });
    $( "#feat" ).click(function() {
        featuring();
    });
    $( "#media_auto" ).click(function() {
        mediaAuto(0);
    });
    $( "#app_reg" ).click(function() {
        exp_reg();
    });
    $( "#image" ).bind("propertychange change click keyup input paste mouseenter mouseleave", function() {
        display_img();
    });
    $( "#preview_media_button" ).click(function() {
        preview_media();
    });
    $( "#adjust" ).click(function() {
        adjust();
    });
    $( "#mm_artiste" ).click(function() {
        same_artiste();
    });
    $( "#miniature" ).click(function() {
        miniature();
    });
});
