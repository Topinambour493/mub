function vide_notif(){
    document.querySelector("#notification").innerHTML='';
}

// Fonction qui permet d'acheter directement n'importe quel produit depuis le catalogue en l'ajoutant au panier
function purchasingDirect(product_id,product_name,product_price,product_stock) {
    if (product_stock == 0){
        alertify.error("Il n'y a plus de stock pour ce produit");
        return;
    }
    basketCase=getShopBasket();
    product={id:product_id,name:product_name,price:product_price,quantity:1};
    productInShopBasket=0;
    basketCase.forEach(basketCase_product => {
        if (basketCase_product['id'] == product_id){
            basketCase_product['quantity']+=1;
            productInShopBasket=1;
        }
    });
    if (productInShopBasket == 0){
        basketCase.push(product);
    }
    localStorage.setItem('basketCase',JSON.stringify(basketCase));
    removeStock(product);
    display_nb_products();
    window.location.href="/shopBasket";
}

// Fonction qui permet de tester de de verifier si il y a encore du stock
function purchasing(product_id,product_name,product_price,product_stock) {
    product_quantity=parseInt(document.querySelector("#quantity").value);
    if (product_stock==0){
        alertify.error("Il n'y a plus de stock pour ce produit");
        return;
    }
    if (product_stock < product_quantity ||  0 > product_quantity || product_quantity%1!=0 ) {
        return;
    }
    basketCase=getShopBasket();
    product={id:product_id,name:product_name,price:product_price,quantity:product_quantity};
    productInShopBasket=0;
    basketCase.forEach(basketCase_product => {
        if (basketCase_product['id'] == product_id){
            basketCase_product['quantity']+=product_quantity;
            productInShopBasket=1;
        }
    });
    if (productInShopBasket == 0){
        basketCase.push(product);
    }
    localStorage.setItem('basketCase',JSON.stringify(basketCase));
    removeStock(product);
    display_nb_products();
    window.location.href="/catalog";
}


function viewLogin(){
    window.location.href="/register"
}


function viewShopBasket(){
    window.location.href="/basketCase";
}


function getShopBasket(){
    if (JSON.parse(localStorage.getItem('basketCase')) == null){
        basketCase=[];
    } else {
        basketCase=JSON.parse(localStorage.getItem('basketCase'));
    }
    return basketCase;
}


function removeStock(basketCase_product){
    var _token= $('meta[name="_token"]').attr('content');
    product=JSON.stringify(basketCase_product);
    $.ajax({
        url:'/removeStock',
        data: {
            product,
            _token
        },
        method: 'POST'
    });
}

function refillStock(basketCase_product){
    var _token= $('meta[name="_token"]').attr('content');
    product=JSON.stringify(basketCase_product);
    $.ajax({
        url:'/refillStock',
        data: {
            product,
            _token
        },
        method: 'POST'
    });
}


function deleteProduit(product_id){
    basketCase=getShopBasket();
    basketCase.forEach(basketCase_product => {
        if (basketCase_product['id'] == product_id){
            refillStock(basketCase_product);
        }
    });
    document.querySelector("#tr"+product_id).remove();
    basketCase=getShopBasket();
    basketCase=basketCase.filter((basketCase_product) => basketCase_product['id'] != product_id);
    localStorage.setItem('basketCase',JSON.stringify(basketCase));
    display_nb_products();
    display_total();
}


// Fonction qui permet de cree le panier/et de l'afficher sous forme de tableau avec le javascript
function display_basketCase(){
    content_basketCase=document.querySelector("#items_basketCase");
    getShopBasket().forEach(basketCase_product => {
        content_basketCase.innerHTML += "<tr " + "id='tr" + basketCase_product["id"]+ "' ><td>"
        + basketCase_product['name'] + "</td><td>"
        + "<form>"
        + "<input type='hidden' name='product_id' value=" + basketCase_product["id"]+ ">"
        + "<input type='hidden' name='old_quantity' value=" + basketCase_product["quantity"] + ">"
        + `<input required min='0' max=${get_stock(basketCase_product['id'])} type='number' name='new_quantity' value=${basketCase_product["quantity"]}  class='modif' />`
        + "<button type='submit' onclick='changeQuantity(" + basketCase_product["id"] + ")' class='update'>update</button>"
        + "</form>"
        + "</td><td>"
        + basketCase_product['price'] + "</td><td>"
        + "<button onclick='deleteProduit(" + basketCase_product["id"] + ")' class='supp'>x</button></td></tr>"
    });
    display_total();
}



// Fonction qui permet d'afficher le nombre de produit dans le panier
function display_nb_products(){
    basketCase=getShopBasket();
    nb_products=0;
    basketCase.forEach(basketCase_product => {
        nb_products+=basketCase_product['quantity'];
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
        deleteProduit(product_id)
        return;
    }
    stock=parseInt(get_stock(product_id)) + old_quantity;
    if (stock < new_quantity){
        return;
    }
    basketCase=getShopBasket();
    basketCase.forEach(basketCase_product => {
        if (basketCase_product['id'] == product_id){
            refillStock(basketCase_product);
            basketCase_product['quantity']=new_quantity;
            removeStock(basketCase_product);
        }
    });
    localStorage.setItem('basketCase',JSON.stringify(basketCase));
    display_nb_products();
    display_total();
}



// Cette fonction nous sert à definir le total du price de la commande
function display_total(){
    total=0;
    getShopBasket().forEach(basketCase_product => {
        total+=basketCase_product['quantity']*basketCase_product['price']
    });
    document.querySelector("#total").innerHTML="Total: "+total+" €";
}




// Cette fonction nous sert a vider le contenue du panier lorsque il n'a pas été acheter, il remet deoncla quantité des products dans le stock
function cleanShopBasket(){
    basketCase=getShopBasket();;
    if (Object.keys(basketCase).length == 0 ){
        alertify.error("Votre panier est vide");
    }
    basketCase.forEach(basketCase_product => {
        refillStock(basketCase_product);
        document.querySelector("#tr"+basketCase_product['id']).remove();
    });
    localStorage.clear();
    display_nb_products();
    display_total();
}

// Cette fonction nous sert a vider le contenue du panier lorsque celui est validé, il ne remet donc pas la quantité des products dans le stock
function cleanShopBasket_validation(){
    basketCase=getShopBasket();;
    if (Object.keys(basketCase).length == 0 ){
        alertify.error("votre panier est vide");
    }
    basketCase.forEach(basketCase_product => {
        document.querySelector("#tr"+basketCase_product['id']).remove();
    });
    localStorage.clear();
    display_nb_products();
    display_total();
}


// Ici voici la fonction qui nous permet de valider notre panier avec la methode ajax
function validationShopBasket(){
    var _token= $('meta[name="_token"]').attr('content')
    basketCase=getShopBasket();
    let errore = 0;
    basketCase.forEach(basketCase_product => {
        product=JSON.stringify(basketCase_product);
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
                cleanShopBasket_validation();
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
    basketCase=getShopBasket();
    basketCase.forEach(shopBasket_product => {
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

