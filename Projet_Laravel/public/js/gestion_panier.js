function vide_notif(){
    document.querySelector("#notification").innerHTML='';
}

// Fonction qui permet d'acheter directement n'importe quel produit depuis le catalogue en l'ajoutant au panier
function achatDirect(product_id,product_nom,product_prix,product_stock) {
    if (product_stock == 0){
        alertify.error("Il n'y a plus de stock pour ce produit");
        return;
    }
    panier=getPanier();
    product={id:product_id,nom:product_nom,prix:product_prix,quantity:1};
    productDansPanier=0;
    panier.forEach(panier_product => {
        if (panier_product['id'] == product_id){
            panier_product['quantity']+=1;
            productDansPanier=1;
        }
    });
    if (productDansPanier == 0){
        panier.push(product);
    }
    localStorage.setItem('panier',JSON.stringify(panier));
    enleveStock(product);
    display_nb_products();
    window.location.href="/shopBasket";
}

// Fonction qui permet de tester de de verifier si il y a encore du stock
function achat(product_id,product_nom,product_prix,product_stock) {
    product_quantity=parseInt(document.querySelector("#quantité").value);
    if (product_stock==0){
        alertify.error("Il n'y a plus de stock pour ce produit");
        return;
    }
    if (product_stock < product_quantity ||  0 > product_quantity || product_quantity%1!=0 ) {
        return;
    }
    panier=getPanier();
    product={id:product_id,nom:product_nom,prix:product_prix,quantity:product_quantity};
    productDansPanier=0;
    panier.forEach(panier_product => {
        if (panier_product['id'] == product_id){
            panier_product['quantity']+=product_quantity;
            productDansPanier=1;
        }
    });
    if (productDansPanier == 0){
        panier.push(product);
    }
    localStorage.setItem('panier',JSON.stringify(panier));
    enleveStock(product);
    display_nb_products();
    window.location.href="/catalog";
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


function enleveStock(panier_product){
    var _token= $('meta[name="_token"]').attr('content');
    product=JSON.stringify(panier_product);
    $.ajax({
        url:'/enleveStock',
        data: {
            product,
            _token
        },
        method: 'POST'
    });
}

function remetStock(panier_product){
    var _token= $('meta[name="_token"]').attr('content');
    product=JSON.stringify(panier_product);
    $.ajax({
        url:'/remetStock',
        data: {
            product,
            _token
        },
        method: 'POST'
    });
}


function supprimeProduit(product_id){
    panier=getPanier();
    panier.forEach(panier_product => {
        if (panier_product['id'] == product_id){
            remetStock(panier_product);
        }
    });
    document.querySelector("#tr"+product_id).remove();
    panier=getPanier();
    panier=panier.filter((panier_product) => panier_product['id'] != product_id);
    localStorage.setItem('panier',JSON.stringify(panier));
    display_nb_products();
    display_total();
}


// Fonction qui permet de cree le panier/et de l'afficher sous forme de tableau avec le javascript
function display_panier(){
    contenu_panier=document.querySelector("#items_panier");
    getPanier().forEach(panier_product => {
        contenu_panier.innerHTML += "<tr " + "id='tr" + panier_product["id"]+ "' ><td>"
        + panier_product['nom'] + "</td><td>"
        + "<form>"
        + "<input type='hidden' name='product_id' value=" + panier_product["id"]+ ">"
        + "<input type='hidden' name='old_quantity' value=" + panier_product["quantity"] + ">"
        + `<input required min='0' max=${get_stock(panier_product['id'])} type='number' name='new_quantity' value=${panier_product["quantity"]}  class='modif' />`
        + "<button type='submit' onclick='changeQuantity(" + panier_product["id"] + ")' class='update'>update</button>"
        + "</form>"
        + "</td><td>"
        + panier_product['prix'] + "</td><td>"
        + "<button onclick='supprimeProduit(" + panier_product["id"] + ")' class='supp'>x</button></td></tr>"
    });
    display_total();
}



// Fonction qui permet d'afficher le nombre de produit dans le panier
function display_nb_products(){
    panier=getPanier();
    nb_products=0;
    panier.forEach(panier_product => {
        nb_products+=panier_product['quantity'];
    });
    document.querySelector("#nb_products").innerHTML=nb_products;
}




// Fonction qui permet de changer la quantité du product depuis le panier
function changeQuantity(product_id){
    tableau=document.querySelector("#tr"+product_id);
    new_quantity=parseInt(tableau.querySelector("input[name='new_quantity']").value);
    old_quantity=parseInt(tableau.querySelector("input[name='old_quantity']").value);
    console.log(new_quantity, old_quantity);
    if (new_quantity < 0){
        return ;
    }
    if (new_quantity==0){
        supprimeProduit(product_id)
        return;
    }
    stock=parseInt(get_stock(product_id)) + old_quantity;
    if (stock < new_quantity){
        return;
    }
    panier=getPanier();
    panier.forEach(panier_product => {
        if (panier_product['id'] == product_id){
            remetStock(panier_product);
            panier_product['quantity']=new_quantity;
            enleveStock(panier_product);
        }
    });
    localStorage.setItem('panier',JSON.stringify(panier));
    display_nb_products();
    display_total();
}



// Cette fonction nous sert à definir le total du prix de la commande
function display_total(){
    total=0;
    getPanier().forEach(panier_product => {
        total+=panier_product['quantity']*panier_product['prix']
    });
    document.querySelector("#total").innerHTML="Total: "+total+" €";
}




// Cette fonction nous sert a vider le contenue du panier lorsque il n'a pas été acheter, il remet deoncla quantité des products dans le stock
function videPanier(){
    panier=getPanier();;
    if (Object.keys(panier).length == 0 ){
        alertify.error("Votre panier est vide");
    }
    panier.forEach(panier_product => {
        remetStock(panier_product);
        document.querySelector("#tr"+panier_product['id']).remove();
    });
    localStorage.clear();
    display_nb_products();
    display_total();
}

// Cette fonction nous sert a vider le contenue du panier lorsque celui est validé, il ne remet donc pas la quantité des products dans le stock
function videPanier_valide(){
    panier=getPanier();;
    if (Object.keys(panier).length == 0 ){
        alertify.error("votre panier est vide");
    }
    panier.forEach(panier_product => {
        document.querySelector("#tr"+panier_product['id']).remove();
    });
    localStorage.clear();
    display_nb_products();
    display_total();
}


// Ici voici la fonction qui nous permet de valider notre panier avec la methode ajax
function validePanier(){
    var _token= $('meta[name="_token"]').attr('content')
    panier=getPanier();
    let errore = 0;
    panier.forEach(panier_product => {
        product=JSON.stringify(panier_product);
        $.ajax({
            url:'/addShopBasket',
            data: {
                product,
                _token
            },
            method: 'POST',
            success: function (){
                $.ajax({
                    url: '/validateShopBasket',
                    data: {
                        _token
                    },
                    method: 'POST',
                    success: function (data) {
                        if (data == "catalog") {
                            window.location.href = "/catalog";
                        }
                    }
                });
                videPanier_valide();
            },
            error: function (error) {
                console.log(error["responseJSON"]);
                errore = 1;
                alertify.error(error["responseJSON"].message);
            }
        });
    });
};

//fonction qui permet de récuperer le stock d'un produit depuis la database SQL grace à la méthode AJAX
function get_stock(product_id){
    var data;
    panier=getPanier();
    panier.forEach(shopBasket_product => {
        if (shopBasket_product['id'] == product_id){
            product=JSON.stringify(shopBasket_product);
            var _token= $('meta[name="_token"]').attr('content')
            $.ajax({
                url:'/getStock',
                data: {
                    product,
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

