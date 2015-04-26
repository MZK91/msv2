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
    var_artiste = trim(document.getElementById("artiste").value);
    var_titre_son = trim(document.getElementById("titre").value);
    var_featuring = trim(document.getElementById("featuring").value);
    if (var_featuring != '') {
        document.getElementById("titre").value = var_artiste + ' - ' + var_titre_son + ' (ft. ' + var_featuring + ')';
    } else {
        document.getElementById("titre").value = var_artiste + ' - ' + var_titre_son;
    }
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
    autoAdjustTitre();
    featuring();
    rebuild();
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
    autoAdjustTitre();
    featuring();
    rebuild();
    if(document.getElementById("image").value == ''){
        var url = 'admin_img_article.php?search='+document.getElementById('artiste').value;
        //alert(url);
        window.frames['frame_img_article'].location.href = url;
        window.frames['frame_img_article'].document.getElementById("son").value = document.getElementById("artiste").value;
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
});
