document.addEventListener("DOMContentLoaded", function() {
    const cartIconContainer = document.querySelector('.fa-basket-shopping');
    const cartIcon = document.querySelector('.content-shopping-cart .number');
    const cartPanel = document.querySelector('.cart-panel');
    const cartPanelItems = document.querySelector('.cart-items');
    const totalQuantityDisplay = document.querySelector('.total-quantity');
    const totalPriceDisplay = document.querySelector('.total-price');
    const closeCartButton = document.querySelector('.close-cart-btn');
    const userIcon = document.querySelector('.fa-user');
    const userPanel = document.querySelector('.user-panel');
    const closeButton = document.querySelector('.close-user-btn');
    const checkoutButton = document.querySelector('.checkout-btn');

    let cart = [];
    let totalQuantity = 0;  
    let totalPrice = 0;

    userIcon.addEventListener('click', function() {
        userPanel.style.display = userPanel.style.display === 'block' ? 'none' : 'block';
    });

    closeButton.addEventListener('click', function() {
        userPanel.style.display = 'none';
    });

    cartIconContainer.addEventListener('click', function() {
        cartPanel.classList.toggle('open');
    });

    closeCartButton.addEventListener('click', function() {
        cartPanel.classList.remove('open');
    });

    document.querySelectorAll('.cart').forEach(button => {
        button.addEventListener('click', function() {
            const productCard = button.closest('.preview');
            const productName = productCard.querySelector('h3').textContent.trim();
            const priceElement = productCard.querySelector('.price');
            let productPriceText;

            if (priceElement.querySelector('span')) {
                productPriceText = priceElement.childNodes[0].textContent.trim();
            } else {
                productPriceText = priceElement.textContent.trim();
            }

            const productPrice = parseFloat(productPriceText.replace(/[^\d.]/g, ''));
            const productImageSrc = productCard.querySelector('img').src;
            const productId = productCard.getAttribute('data-id');
            const productClass = productCard.querySelector('.class').textContent.split(': ')[1];
            const productExpDate = productCard.querySelector('.exp-date').textContent.split(': ')[1];

            addToCart(productId, productName, productPrice, productImageSrc, productClass, productExpDate);
        });
    });

    function addToCart(id, name, price, imageSrc, productClass, productExpDate) {
        const existingProduct = cart.find(product => product.id === id);
        if (existingProduct) {
            existingProduct.quantity++;
        } else {
            cart.push({ id, name, price, imageSrc, quantity: 1, productClass, productExpDate });
        }
        updateCart();

        // Enviar solicitud al servidor para disminuir el stock
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_stock.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                console.log(xhr.responseText);
            }
        };
        xhr.send("id=" + id + "&quantity=1");
    }

    function updateCart() {
        cartPanelItems.innerHTML = '';
        totalQuantity = 0;
        totalPrice = 0;

        cart.forEach(product => {
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.innerHTML = `
                <img src="${product.imageSrc}" alt="${product.name}" class="cart-item-image">
                <div class="cart-item-info">
                    <p class="cart-item-name">${product.name}</p>
                    <p class="cart-item-price">S/ ${product.price.toFixed(2)}</p>
                </div>
                <p class="cart-item-quantity">Cantidad: ${product.quantity}</p>
                <button class="remove-item-btn">&times;</button>
            `;
            const removeBtn = cartItem.querySelector('.remove-item-btn');
            removeBtn.addEventListener('click', function() {
                removeItemFromCart(product.id);
            });

            cartPanelItems.appendChild(cartItem);
            totalQuantity += product.quantity;
            totalPrice += product.price * product.quantity;
        });

        updateCartSummary();
    }

    function removeItemFromCart(id) {
        cart = cart.filter(product => product.id !== id);
        updateCart();
    }

    function updateCartSummary() {
        totalQuantityDisplay.textContent = totalQuantity;
        totalPriceDisplay.textContent = totalPrice.toFixed(2);
        cartIcon.textContent = `(${totalQuantity})`;
    }

    checkoutButton.addEventListener('click', function() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'checkout.php';

        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'cart';
        input.value = JSON.stringify(cart);

        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    });
});
