
// Fonction qui nous permet d'avoir le nombre de commandes totales faites sur le site
async function get_nb_commandes(){
    await fetch('/nb_commandes')
    .then(response => response.text())
    .then((result) => {
        document.querySelector("#nb_commandes").innerHTML="Nombres de commandes passées: "+result
    })
}

// Requete Ajax pour pouvoir trouver la plus grosse commande 
async function get_biggestpurchase(){
    await fetch('/biggestpurchase')
    .then(response => response.text())
    .then((result) => {
        document.querySelector("#biggestpurchase").innerHTML="La plus grosse commande est de "+JSON.parse(result).quantite+" objet achetés"
    })
}

// fonction qui nous permet d'afficher le nombre d'utilisateur inscrit sur le site
async function get_nb_users(){
    await fetch('/nb_users')
    .then(response => response.text())
    .then((result) => {
        document.querySelector("#nb_users").innerHTML="Nombres de comptes crées: "+result
    })
}



// Fonction refresh
function refresh(){
    get_nb_commandes()
    get_nb_users()
    get_biggestpurchase()
}


