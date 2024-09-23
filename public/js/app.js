
let totalPrice = 0;
const baseurl = 'http://127.0.0.1:8000'

function updateCartList() {
    let getitem = JSON.parse(localStorage.getItem('CartItem')) || [];

    if (getitem.length < 1) {
        return;
    }
    document.getElementById('cartContain').innerHTML = `Cart(${getitem.length})`;
}
updateCartList();

function addCart(a, buttonElement) {
    let cartItems = JSON.parse(localStorage.getItem('CartItem')) || [];

    if (cartItems.includes(a)) {
        alert("Item already exists in the cart");
        return;  // Exit the function if the item already exists
    }
    cartItems.push(a);

    localStorage.setItem('CartItem', JSON.stringify(cartItems));

    updateCartList();
    buttonElement.disabled = true;
}

function qunatityChange() {
    // Get all elements with class 'quantityvalue'
    const quantityElements = document.querySelectorAll('.quantityvalue');

    // Initialize total price
    totalPrice = 0;

    // Loop through each quantity element
    quantityElements.forEach(function (element) {
        // Get the quantity value (convert to number)
        let quantity = parseFloat(element.value);

        if (quantity <= 0) {
            quantity = 1;
            element.value = 1;  // Reset the input field to 1
        }

        // Get the product price from the data attribute
        let price = parseFloat(element.getAttribute('data-price'));

        // Multiply quantity with price and add to total price
        totalPrice += quantity * price;
    });

    // Set the total price in an element, assuming it has an id 'totalprice'
    document.getElementById('totalprice').innerHTML = `Total: ${totalPrice.toFixed(2)}`; // Keep 2 decimal places

    if (totalPrice == 0) {
        window.location.reload()
    }
}

async function cartList() {
    // Retrieve the cart items from localStorage
    let cartItems = JSON.parse(localStorage.getItem('CartItem')) || [];

    // Check if cartItems is not empty
    let mainContainer = document.getElementById("MainContentOfBase");
    if (cartItems.length === 0) {
        return mainContainer.innerHTML = `<a href="http://127.0.0.1:8000/">No data . Go to Shop..</a>`;
    }

    // Make a POST request to the Laravel backend
    await fetch('/api/cart-items', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ cartItems: cartItems })
    })
        .then(response => response.json())
        .then(data => {

            // Get the main container where the products will be displayed

            mainContainer.innerHTML = '<div id="mainContainer" class=" flex flex-wrap justify-center gap-4"></div>'; // Clear the container before adding new items

            // Iterate over the product list and add each product to the container
            data.forEach((product) => {
                totalPrice += product.price


                document.getElementById('mainContainer').innerHTML += `
            <div id="${product.id}" class="bg-gray-400 w-52 border rounded-lg shadow-md p-4">
                <a href="/product/${product.id}">
                    <img src="http://127.0.0.1:8000/uploads/${product.image}" alt="${product.name}"
                        class="w-48 h-48 object-contain rounded-md mb-4">
                    
                    <h2 class="text-xl font-bold mb-2">${product.name}</h2>
                    <p class="text-gray-600 mb-2 text-wrap">${product.description}</p>
                    <p class="text-green-500 font-semibold mb-2">$${(product.price).toFixed(2)}</p>
                    <p class="text-sm ${product.available ? 'text-green-500' : 'text-red-500'}">
                        ${product.available == 1 ? 'Available' : 'Out of Stock'}
                    </p>
                </a>
                <div class=" flex justify-around flex-wrap">
                <div>
                Quantity:
                <input onchange="qunatityChange()" data-name="${product.name}" data-pid="${product.id}" data-price="${product.price}" class="quantityvalue w-10" type="number" value='1'>
                </div>
                <button onclick="removeCartItem('${product.id}')" class=" bg-gray-400 hover:bg-gray-700 text-red-400 p-1 rounded-lg">Remove</button>
                </div>
            </div>
            `;
            });


            mainContainer.innerHTML += `
        <div class="flex justify-center gap-4 flex-wrap my-1">
          <div id="totalprice" class=" p-2 bg-purple-400  text-blue-400">Total:${totalPrice}</div>
          <button onclick="makeOrder()" class=" p-2 bg-black rounded-lg hover:bg-yellow-400 text-red-400">Make a order</button>
        </div>
        `


        })
        .catch(error => {
            console.error("Error:", error);
        });
}

function removeCartItem(a) {
    let cartItems = JSON.parse(localStorage.getItem('CartItem')) || [];

    cartItems = cartItems.filter(item => item !== a);
    localStorage.setItem('CartItem', JSON.stringify(cartItems));
    document.getElementById(a).classList.toggle('hidden')
    document.getElementById(a).innerHTML = ''
    qunatityChange()
}

function makeOrder() {
    const quantityElements = document.querySelectorAll('.quantityvalue');
    let data = [];

    // Iterate over each quantity element to gather product data
    quantityElements.forEach(product => {
        let productId = product.getAttribute('data-pid');
        let product_name = product.getAttribute('data-name');
        let quantity = product.value;

        // Ensure both product ID and quantity are present before adding to data
        if (productId && quantity && product_name) {
            data.push({ 'id': productId, 'quantity': quantity, 'name': product_name });
        }
    });

    // Ensure there's at least one product before making the request
    if (data.length === 0) {
        return;
    }

    // Create a hidden form element
    let form = document.createElement('form');
    form.method = 'POST';
    form.action = `${baseurl}/order`;

    // Add CSRF token as a hidden input
    let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = csrfToken;
    form.appendChild(csrfInput);

    // Add each product's data as hidden inputs
    data.forEach(item => {
        let productIdInput = document.createElement('input');
        productIdInput.type = 'hidden';
        productIdInput.name = 'items[' + item.id + '][id]';
        productIdInput.value = item.id;
        form.appendChild(productIdInput);

        let quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'items[' + item.id + '][quantity]';
        quantityInput.value = item.quantity;
        form.appendChild(quantityInput);

        let nameInput = document.createElement('input');
        nameInput.type = 'hidden';
        nameInput.name = 'items[' + item.id + '][name]';
        nameInput.value = item.name;
        form.appendChild(nameInput);
    });

    // Append the form to the body and submit it
    document.body.appendChild(form);
    form.submit();

    localStorage.removeItem('CartItem')
    updateCartList()
}


async function showCartItem(cartKey, element) {
    // Fetch the cart items from the backend
    const cartDiv = document.getElementById(cartKey);

    if (cartDiv.classList.contains('hidden')) {
        cartDiv.classList.remove('hidden')
        element.innerHTML = 'Hide Details'

        await fetch(`${baseurl}/cart-items/${cartKey}/`)
            .then(response => response.json())
            .then(data => {
                // Clear the existing cart items
                cartDiv.innerHTML = '<div> Item :</div>';

                // Check if the cart_items array is not empty
                if (data.cart_items.length > 0) {
                    // Loop through the cart items
                    data.cart_items.forEach((item, index) => {
                        cartDiv.innerHTML += `
                     <div data-product_id="${item.product_id}" class="${cartKey} mx-10 my-2 p-1">
                     ${index + 1}. ${item.name} x ${item.quantity} .
                     </div>
                     `;
                    });

                    // Display billing address if available
                    const billingAddress = data.billing_address;
                    
                    if (billingAddress) {
                        const ab = billingAddress.is_accept ? 'Your order is on the way..' : 'Pending....'
                        cartDiv.innerHTML += `
                        <div class="billing-info">
                            <p class=""><strong>Billing Address:</strong></p>
                            <p class="mx-10 my-2 p-1">Name: ${billingAddress.name}</p>
                            <p class="mx-10 my-2 p-1">Phone: ${billingAddress.phone}</p>
                            <p class="mx-10 my-2 p-1">Email: ${billingAddress.email}</p>
                            <p class="mx-10 my-2 p-1">Address: ${billingAddress.present_address}</p>
                            <p class="mx-10 my-2 p-1">Payment Method: ${billingAddress.payment_method}</p>
                            <p class="mx-10 my-2 p-1">Transaction ID: ${billingAddress.transaction_id}</p>
                            <p class="mx-10 my-2 p-1">Transaction Date: ${billingAddress.transaction_date}</p>
                            <p class="">Stutas : ${ab}</p>
                        </div>
                        `;
                    }else{
                        cartDiv.innerHTML += `
                        <p class="mx-10 my-2 p-1">
                        <a href="${baseurl}/payment-address/${cartKey}/">Note:Plase add your payment and address..</a>
                        </p>
                        `
                    }

                    // Add buttons for updating, canceling, and entering payment/address information
                    if (billingAddress) {
                        if (!billingAddress.is_accept) {
                            cartDiv.innerHTML += `
                            <div class="flex gap-3 justify-center">
                                <button onclick="updateCartItem('${cartKey}')" class="button bg-red">Update</button>
                                <button onclick="CancleCart('${cartKey}')" class="button bg-yellow">Cancel</button>
                                <button onclick="PaymentAddress('${cartKey}')" class="button bg-green">Address/Payment</button>
                            </div>
                        `;
                        }
                    }else{
                        cartDiv.innerHTML += `
                        <div class="flex gap-3 justify-center">
                            <button onclick="updateCartItem('${cartKey}')" class="button bg-red">Update</button>
                            <button onclick="CancleCart('${cartKey}')" class="button bg-yellow">Cancel</button>
                            <button onclick="PaymentAddress('${cartKey}')" class="button bg-green">Address/Payment</button>
                        </div>
                    `;
                    }

                } else {
                    cartDiv.innerHTML = '<p>No items found in this cart.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching cart items:', error);
                const cartDiv = document.getElementById(cartKey);
                cartDiv.innerHTML = '<p>Error loading cart details. Please try again later.</p>';
            })
    } else {
        element.innerHTML = 'Show Details'

        cartDiv.classList.add('hidden')
    }
}

async function CancleCart(a, b = false) {
    if (b) {
        await fetch(`${baseurl}/delete-cart/${a}/`)
            .catch(error => {
                console.log(error);

            })
    }
    else {
        window.location.href = `${baseurl}/delete-cart/${a}/`
    }
}

function updateCartItem(unique_key) {
    const productElements = document.querySelectorAll(`.${unique_key}`)
    let data = [];

    productElements.forEach(item => {
        let a = item.getAttribute("data-product_id")
        data.push(a)
    })

    if (data.length > 0) {
        localStorage.setItem('CartItem', JSON.stringify(data))
        CancleCart(a = unique_key, b = true)
        cartList()
    }
}

function PaymentAddress(Cart_key) {
    window.location.href = `${baseurl}/payment-address/${Cart_key}/`
}
