<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Single Page App</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="menu">
        <a href="#index">Home</a>
        <a href="#cart">Cart</a>
        <a href="#products" class="orders-link">Products</a>
        <a href="#orders" class="orders-link">Orders</a>
        <a href="#login" class="login-link">Login</a>
        <form class="logout-link">
            <button type="submit">Logout</button>
        </form>
    </div>

    <div class="page index">
        <table class="list"></table>
    </div>

    <div class="page cart">
        <h3>Cart</h3>
        <table class="list"></table>
        <br>
        <div class="error" style="display: none;">
        </div>
        <form id="checkout-form" class="checkout-form" style="height: auto">
            <div>
                <label>Name</label>
                <input type="text" class="checkout-name" name="name" value="">
            </div>
            <div>
                <label>Contact Details</label>
                <textarea class="checkout-details" name="contact_details"></textarea>
            </div>
            <div>
                <label>Comment</label>
                <textarea class="checkout-comment" name="comment"></textarea>
            </div>
            <button class="btn-send" type="submit">Checkout</button>
        </form>
    </div>

    <div class="page login">
        <div class="login-error" style="display: none;"></div>
        <form id="login-form" class="checkout-form" style="height: auto">
            <div>
                <label>Email</label>
                <input type="text" class="login-email" name="email" value="">
            </div>
            <div>
                <label>Password</label>
                <input type="password" class="login-pass" name="password" value="">
            </div>
            <button class="btn-send" type="submit">Login</button>
        </form>
    </div>

    <div class="page products">
        <h3>Products</h3>
        <a href="#product">Add Product</a>
        <table class="products-list">
        </table>
    </div>

    <div class="page product">
        <div class="product-error" style="display: none;"></div>
        <form class="checkout-form product" enctype="multipart/form-data" style="height: auto">
            <input type="hidden" class="product_id" name="product_id" value="">
            <input type="hidden" class="method" name="_method" value="">
            <div>
                <label>Title</label>
                <input type="text" class="product_name" name="title" value="">
            </div>
            <div>
                <label>Description</label>
                <textarea rows="7" class="product_description" name="description"></textarea>
            </div>
            <div>
                <label>Price</label>
                <input type="text" class="product_price" name="price" value="">
            </div>
            <div>
                <img src="#" class="product_image" alt="Product Image">
                <input type="file" name="image" accept="image/*" id="fileToUpload">
            </div>
            <div>
                <button class="btn-send product" type="submit"></button>
            </div>
        </form>
    </div>

    <div class="page orders">
        <h3>Orders</h3>
        <table class="orders-list">
        </table>
    </div>

    <div class="page order">
        <div class="customer-details">
            <h3>Customer Details</h3>
            <table class="details-list">
            </table>
        </div>
        <br>
        <div class="products-details">
            <h3>Purchased Products</h3>
            <table class="products-list">
            </table>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/spa.js') }}"></script>
</body>
</html>