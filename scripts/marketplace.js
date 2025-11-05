const products = [
    {
        id: 1,
        name: "Gelang Eco",
        description: "Gelang stylish dari plastik daur ulang",
        price: 250000,
        icon: "⌚"
    },
    {
        id: 2,
        name: "Botol Minum Reusable",
        description: "Botol minum premium dari material ramah lingkungan",
        price: 150000,
        icon: "🍶"
    },
    {
        id: 3,
        name: "Dompet Eco",
        description: "Dompet praktis dari sampah plastik laut",
        price: 120000,
        icon: "💸"
    },
];

let cart = [];

// Render
function printProduct() {
    const grid = $('#products-grid');
    
    products.forEach(product => {
        const productCard = `
            <div class="product-card">
                <div class="product-image">${product.icon}</div>
                <div class="product-info">
                    <h3 class="product-name">${product.name}</h3>
                    <p class="product-description">${product.description}</p>
                    <div class="product-price">Rp ${(product.price)}</div>
                </div>
                <button class="add-to-cart-btn" data-id="${product.id}">
                    Tambah ke Keranjang
                </button>
            </div>
        `;
        grid.append(productCard);
    });
}

// Add
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    const itemAda = cart.find(item => item.id === productId);
    
    if (itemAda) {
        itemAda.jumlah++;
    } else {
        cart.push({
            ...product, jumlah: 1
        });
    }
    
    updateCart();
}

// Update
function updateCart() {
    const cartCount = cart.reduce((sum, item) => sum + item.jumlah, 0);
    $('#cart-count').text(cartCount);
    
    const cartItems = $('#cart-items');
    cartItems.empty();
    
    cart.forEach(item => {
        const cartItem = `
            <div class="cart-item">
                <div class="cart-item-image">${item.icon}</div>
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.name}</div>
                    <div class="cart-item-price">Rp ${(item.price)}</div>
                    <div class="cart-item-controls">
                        <button class="qty-btn qty-minus" data-id="${item.id}">-</button>
                        <span class="qty-display">${item.jumlah}</span>
                        <button class="qty-btn qty-plus" data-id="${item.id}">+</button>
                        <button class="remove-btn" data-id="${item.id}">Hapus</button>
                    </div>
                </div>
            </div>
        `;
        cartItems.append(cartItem);
    });
    
    updateTotal();
}

// Update total
function updateTotal() {
    const total = cart.reduce((sum, item) => sum + (item.price * item.jumlah), 0);
    $('#total-price').text(total);
}

// Increase
function tambahKuantitas(productId) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        item.jumlah++;
        updateCart();
    }
}

// Decrease
function kurangKuantitas(productId) {
    const item = cart.find(item => item.id === productId);
    if (item) {
        if (item.jumlah > 1) {
            item.jumlah--;
        } else {
            removeFromCart(productId);
        }
        updateCart();
    }
}

// Remove
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCart();
}

// Clear
function clearCart() {
    if (confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
        cart = [];
        updateCart();
    }
}

// Toggle cart
function toggleCart() {
    $('#cart-section').toggle(300);
}

// Checkout
function checkout() {
    if (cart.length === 0) {
        alert('Keranjang belanja Anda kosong!');
        return;
    }
    
    const total = cart.reduce((sum, item) => sum + (item.price * item.jumlah), 0);
    const itemCount = cart.reduce((sum, item) => sum + item.jumlah, 0);
    
    alert(`Checkout berhasil!\n\nTotal Item: ${itemCount}\nTotal Pembayaran: Rp ${(total)}\n\nTerima kasih telah berbelanja!`);
    
    cart = [];
    updateCart();
}

// Event listener
$(document).ready(function() {
    // Print 
    printProduct();
    
    // Add to cart
    $(document).on('click', '.add-to-cart-btn', function() {
        const productId = parseInt($(this).data('id'));
        addToCart(productId);
    });
    
    // Cart
    $('#cart-btn').click(toggleCart);
    $('#close-cart').click(toggleCart);
    
    // jumlah controls
    $(document).on('click', '.qty-plus', function() {
        const productId = parseInt($(this).data('id'));
        tambahKuantitas(productId);
    });
    
    $(document).on('click', '.qty-minus', function() {
        const productId = parseInt($(this).data('id'));
        kurangKuantitas(productId);
    });
    
    // Remove item
    $(document).on('click', '.remove-btn', function() {
        const productId = parseInt($(this).data('id'));
        removeFromCart(productId);
    });
    
    // Clear cart
    $('#clear-cart').click(clearCart);
    
    // Checkout
    $('.checkout-btn').click(checkout);
});