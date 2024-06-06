let openShopping = document.querySelector('.shopping');
let closeShopping = document.querySelector('.closeShopping');
let list = document.querySelector('.list');
let listCard = document.querySelector('.listCard');
let body = document.querySelector('body');
let total = document.querySelector('.total');
let quantity = document.querySelector('.quantity');

openShopping.addEventListener('click', () => {
    body.classList.add('active');
});
closeShopping.addEventListener('click', () => {
    body.classList.remove('active');
});

var role; // Zmienna roli użytkownika
console.log(role);

function addProduct(id, name, price) {
    var product = {
        id_product: id,
        name: name,
        price: price
    };
    products.push(product);
}

let listCards = [];

function initApp() {
    products.forEach((value, key) => {
        let newDiv = document.createElement('span');
        newDiv.classList.add('item');
        newDiv.innerHTML = `
            <img src="images/${value.name}.jpg">
            <div class="title">${value.name}</div>
            <div class="price">${value.price.toLocaleString()}</div>
            <button onclick="addToCard(${key})">Dodaj do koszyka</button>`;
        if (role == 'admin' || role == 'moderator') {
            newDiv.innerHTML += `<button onclick="removeProduct(${key})">Usuń</button>`;
        }
        list.appendChild(newDiv);
    });
}
initApp();

function addToCard(key) {
    if (listCards[key] == null) {
        listCards[key] = JSON.parse(JSON.stringify(products[key])); //Kopiowanie indeksu listy do koszyka
        listCards[key].quantity = 1;
    }
    reloadCard();
}

function reloadCard() {
    listCard.innerHTML = '';
    let count = 0;
    let totalPrice = 0;
    listCards.forEach((value, key) => {
        totalPrice = parseFloat(totalPrice) + parseFloat(value.price);
        count = count + value.quantity;
        if (value != null) {
            let newDiv = document.createElement('li');
            newDiv.innerHTML = `
                <div style="float: left"><img src="images/${value.name}.jpg"/></div>
                <div>${value.name}</div>
                <div>${value.price.toLocaleString()}</div>
                <div>
                    <button onclick="changeQuantity(${key}, ${value.quantity - 1})">-</button>
                    <div class="count">${value.quantity}</div>
                    <button onclick="changeQuantity(${key}, ${value.quantity + 1})">+</button>`;
            listCard.appendChild(newDiv);
        }
    });
    total.innerText = totalPrice.toLocaleString();
    quantity.innerText = count;
}

function changeQuantity(key, quantity) {
    if (quantity == 0) {
        delete listCards[key];
    } else {
        listCards[key].quantity = quantity;
        listCards[key].price = quantity * products[key].price;
    }
    reloadCard();
}

function removeProduct(key) {
    products.splice(key, 1); // Usuwamy produkt z listy produktów
    list.innerHTML = ''; // Czyścimy listę produktów
    initApp(); // Inicjujemy ponownie listę produktów
}