

// Cette fonction va nous permettre d'afficher un petit message flash pour vous prevenir du la presence ou non de produit dans votre panier
function notification_flash(texte){
    document.querySelector("#notification").innerHTML=texte;
    setTimeout(vide_notif,3000);
}



function vide_notif(){
    document.querySelector("#notification").innerHTML='';
}

// Fonction qui permet d'acheter directement n'importe quel produit depuis le catalogue en l'ajoutant au panier
function achatDirect(produit_id,produit_nom,produit_prix,produit_stock) {
    if (produit_stock == 0){
        alertify.error("Il n'y a plus de stock pour ce produit");
        return;
    }
    panier=getPanier();
    produit={id:produit_id,nom:produit_nom,prix:produit_prix,quantite:1};
    produitDansPanier=0;
    panier.forEach(panier_produit => {
        if (panier_produit['id'] == produit_id){
            panier_produit['quantite']+=1;
            produitDansPanier=1;
        }
    });
    if (produitDansPanier == 0){
        panier.push(produit);
    }
    localStorage.setItem('panier',JSON.stringify(panier));
    enleveStock(produit);
    display_nb_produits();
    window.location.href="/panier";
}

// Fonction qui permet de tester de de verifier si il y a encore du stock
function achat(produit_id,produit_nom,produit_prix,produit_stock) {
    produit_quantite=parseInt(document.querySelector("#quantité").value);
    if (produit_stock==0){
        alertify.error("Il n'y a plus de stock pour ce produit");
        return;
    }
    if (produit_stock < produit_quantite ||  0 > produit_quantite || produit_quantite%1!=0 ) {
        return;
    }
    panier=getPanier();
    produit={id:produit_id,nom:produit_nom,prix:produit_prix,quantite:produit_quantite};
    produitDansPanier=0;
    panier.forEach(panier_produit => {
        if (panier_produit['id'] == produit_id){
            panier_produit['quantite']+=produit_quantite;
            produitDansPanier=1;
        }
    });
    if (produitDansPanier == 0){
        panier.push(produit);
    }
    localStorage.setItem('panier',JSON.stringify(panier));
    enleveStock(produit);
    display_nb_produits();
    window.location.href="/catalogue";
}


function viewLogin(){
    window.location.href="/inscription";
}


function viewPanier(){
    window.location.href="/panier";
}


function getPanier(){
    if (JSON.parse(localStorage.getItem('panier')) == null){
        panier=[];
    } else {
        panier=JSON.parse(localStorage.getItem('panier'));
    }
    return panier;
}


function enleveStock(panier_produit){
    var _token= $('meta[name="_token"]').attr('content');
    produit=JSON.stringify(panier_produit);
    $.ajax({
        url:'/enleveStock',
        data: {
            produit,
            _token
        },
        method: 'POST'
    });
}

function remetStock(panier_produit){
    var _token= $('meta[name="_token"]').attr('content');
    produit=JSON.stringify(panier_produit);
    $.ajax({
        url:'/remetStock',
        data: {
            produit,
            _token
        },
        method: 'POST'
    });
}


function supprimeProduit(produit_id){
    panier=getPanier();
    panier.forEach(panier_produit => {
        if (panier_produit['id'] == produit_id){
            remetStock(panier_produit);
        }
    });
    document.querySelector("#tr"+produit_id).remove();
    panier=getPanier();
    panier=panier.filter((panier_produit) => panier_produit['id'] != produit_id);
    localStorage.setItem('panier',JSON.stringify(panier));
    display_nb_produits();
    display_total();
}


// Fonction qui permet de cree le panier/et de l'afficher sous forme de tableau avec le javascript
function display_panier(){
    contenu_panier=document.querySelector("#items_panier");
    getPanier().forEach(panier_produit => {
        contenu_panier.innerHTML += "<tr " + "id='tr" + panier_produit["id"]+ "' ><td>"
        + panier_produit['nom'] + "</td><td>"
        + "<form>"
        + "<input type='hidden' name='produit_id' value=" + panier_produit["id"]+ ">"
        + "<input type='hidden' name='ancienne_quantite' value=" + panier_produit["quantite"] + ">"
        + "<input required min='0' type='number' name='nouvelle_quantite' value=" + panier_produit["quantite"] + " get class='modif' />"
        + "<button type='submit' onclick='changeQuantite(" + panier_produit["id"] + ")' class='update'>update</button>"
        + "</form>"
        + "</td><td>"
        + panier_produit['prix'] + "</td><td>"
        + "<button onclick='supprimeProduit(" + panier_produit["id"] + ")' class='supp'>x</button></td></tr>"
    });
    display_total();
}



// Fonction qui permet d'afficher le nombre de produit dans le panier
function display_nb_produits(){
    panier=getPanier();
    nb_produits=0;
    panier.forEach(panier_produit => {
        nb_produits+=panier_produit['quantite'];
    });
    document.querySelector("#nb_produits").innerHTML=nb_produits;
}




// Fonction qui permet de changer la quantité du produit depuis le panier
function changeQuantite(produit_id){
    tableau=document.querySelector("#tr"+produit_id);
    nouvelle_quantite=parseInt(tableau.querySelector("input[name='nouvelle_quantite']").value);
    ancienne_quantite=parseInt(tableau.querySelector("input[name='ancienne_quantite']").value);
    if (nouvelle_quantite < 0){
        return ;
    }
    if (nouvelle_quantite==0){
        supprimeProduit(produit_id)
        return;
    }
    stock=parseInt(get_stock(produit_id)) + ancienne_quantite;
    if (stock < nouvelle_quantite){
        alertify.error("Impossible de dépasser le stock disponible qui est de " + stock + " pour ce produit");
        return;
    }
    panier=getPanier();
    panier.forEach(panier_produit => {
        if (panier_produit['id'] == produit_id){
            remetStock(panier_produit);
            panier_produit['quantite']=nouvelle_quantite;
            enleveStock(panier_produit);
        }
    });
    localStorage.setItem('panier',JSON.stringify(panier));
    display_nb_produits();
    display_total();
}



// Cette fonction nous sert à definir le total du prix de la commande
function display_total(){
    total=0;
    getPanier().forEach(panier_produit => {
        total+=panier_produit['quantite']*panier_produit['prix']
    });
    document.querySelector("#total").innerHTML="Total: "+total+" €";
}




// Cette fonction nous sert a vider le contenue du panier lorsque il n'a pas été acheter, il remet deoncla quantité des produits dans le stock
function videPanier(){
    panier=getPanier();;
    if (Object.keys(panier).length == 0 ){
        alertify.error("Votre panier est vide");
    }
    panier.forEach(panier_produit => {
        remetStock(panier_produit);
        document.querySelector("#tr"+panier_produit['id']).remove();
    });
    localStorage.clear();
    display_nb_produits();
    display_total();
}

// Cette fonction nous sert a vider le contenue du panier lorsque celui est validé, il ne remet donc pas la quantité des produits dans le stock
function videPanier_valide(){
    panier=getPanier();;
    if (Object.keys(panier).length == 0 ){
        alertify.error("votre panier est vide");
    }
    panier.forEach(panier_produit => {
        document.querySelector("#tr"+panier_produit['id']).remove();
    });
    localStorage.clear();
    display_nb_produits();
    display_total();
}


// Ici voici la fonction qui nous permet de valider notre panier avec la methode ajax
function validePanier(){
    var _token= $('meta[name="_token"]').attr('content')
    panier=getPanier();
    panier.forEach(panier_produit => {
        produit=JSON.stringify(panier_produit);
        $.ajax({
            url:'/ajoutePanier',
            data: {
                produit,
                _token
            },
            method: 'POST'
        });
    });
    $.ajax({
        url:'/validerPanier',
        data: {
            _token
        },
        method: 'POST',
        success: function(data){
            if (data=="catalogue"){
                window.location.href="/catalogue";
            }
        }
    });
    videPanier_valide();
};

//fonction qui permet de récuperer le stock d'un produit depuis la database SQL grace à la méthode AJAX
function get_stock(produit_id){
    var data;
    panier=getPanier();
    panier.forEach(panier_produit => {
        if (panier_produit['id'] == produit_id){
            produit=JSON.stringify(panier_produit);
            var _token= $('meta[name="_token"]').attr('content')
            $.ajax({
                url:'/getStock',
                data: {
                    produit,
                    _token
                },
                method: 'POST',
                async: false,
                success: function (resp) {
                    data = resp;
                }
            });
        }
    });
    return data;
}

