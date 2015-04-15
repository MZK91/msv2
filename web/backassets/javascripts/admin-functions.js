function confirmLink(theLink){

    var confirmMsg = "Etes vous bien sur de vouloir supprimer ce sujet ???" ;
    if (confirmMsg == '' || typeof(window.opera) != 'undefined') {
        return true;
    }

    var is_confirmed = confirm(confirmMsg);
    if (is_confirmed) {
        theLink.href += '&confirm=1';
    }

    return is_confirmed;
}

function Clean(){
    var_titre = document.getElementById("titre_article").value;
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
    document.getElementById("titre_article").value = var_titre;
    autoAdjustTitre();
}