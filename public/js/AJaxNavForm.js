$(document).ready(function () {
    AjaxNav();
});


function AjaxNav() {
    // definition des select pour les categories d'activité'
    var activite = document.querySelectorAll('#activite')
    var activiteLi = document.querySelectorAll('#activiteLi')
    var activteForm = document.querySelectorAll('#inputActivite')
    //definition de select pour les classes decouverte
    var classes = document.querySelectorAll('#classesDecouverte')
    // definition des select pour les categories de centre
    var centre = document.querySelectorAll('#categorieCentre')
    // definition dinput select pour les categories de centre
    var select = document.querySelectorAll('#inputcategorieCentre')
    var LiCentre = document.querySelectorAll('#categorieCentreLi')

    $.ajax(
        {
            url: "",
            type: "GET",
            data: {},
            success: function (data) {
                // remplir activité
                for (let a = 0; a < activite.length; a++) {
                    for (let b = 0; b < data.activite.length; b++) {

                        activite[a].innerHTML += '<a href="/sports/'+data.activite[b]+'">'+data.activite[b]+'</a>'
                    }
                }
                // remplir activité footer
                for (let a = 0; a < activiteLi.length; a++) {
                    for (let b = 0; b < data.activite.length; b++) {

                        activiteLi[a].innerHTML += '<a href="/sports/'+data.activite[b]+'">'+data.activite[b]+'</a>'
                    }
                }


                // remplir centre
                for (let i = 0; i < centre.length; i++) {
                    for (let j = 0; j < data.centres.length; j++) {
                        centre[i].innerHTML +=  '<a href="/etablissements/'+data.centres[j]+'">'+data.centres[j]+'</a>'
                    }
                }
                //remplir centre footer
                for (let i = 0; i < LiCentre.length; i++) {
                    for (let j = 0; j < data.centres.length; j++) {
                        LiCentre[i].innerHTML +=  '<a href="/etablissements/'+data.centres[j]+'">'+data.centres[j]+'</a>'
                    }
                }

                // remplir classes
                for (let e = 0; e < classes.length; e++) {
                    for (let f = 0; f < data.lesClasses.length; f++) {
                        classes[e].innerHTML +=  '<a href="/sessions/'+data.lesClasses[f]+'">'+data.lesClasses[f]+'</a>'
                    }
                }
                for (let s = 0; s < select.length; s++) {
                    for (let k = 0; k < data.centreNom.length; k++) {
                        var opt = document.createElement("option");
                        opt.value = data.centreNom[k]
                        opt.text = data.centreNom[k]
                        select[s].appendChild(opt)
                    }
                }

                for (let t = 0; t < activteForm.length; t++) {
                    for (let k = 0; k < data.acti.length; k++) {
                        var opt = document.createElement("option");
                        opt.value = data.acti[k]
                        opt.text = data.acti[k]
                        activteForm[t].appendChild(opt)
                    }
                }
            }
        })
}
