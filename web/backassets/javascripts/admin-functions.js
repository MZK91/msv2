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

function Clean(field){
    var_titre = document.getElementById(field).value;
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
    document.getElementById(field).value = var_titre;
    autoAdjustTitre(field);
}
function autoAdjustTitre(field,field2,field3){
    var_titre = document.getElementById(field).value;
    var_titre = var_titre.replace(/–/, '-');
    var_titre = var_titre.replace(/ +/g, ' ');
    var_titre = trim(var_titre);
    var_titre = ucfirst(var_titre);
    document.getElementById(field).value = var_titre;
    tab = var_titre.split(' - ');
    document.getElementById(field).value = ucfirst(trim(tab[0]))+' - '+ucfirst(trim(tab[1]));
    document.getElementById(field2).value = ucfirst(trim(tab[0]));
    document.getElementById(field3).value = ucfirst(trim(tab[1]));
}