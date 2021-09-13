$(document).ready(function () {

    function init() {
        $('#checkout-form').submit(function (e) {
            e.preventDefault();
            checkout();
        });

        $('#checkout-form').keypress(function (e) {
            if (e.which == 13) {
                e.preventDefault();
                checkout();
            }
        });
    }

    function renderList(products, type) {
        var html = '';
        html = `<tr>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>`;

        $.each(products, function (key, product) {
            html += `<tr>
                        <td>${product.title}</td>
                        <td>
                            <img src="${product.image_path ? product.image_path : 'images/placeholder.png'}">
                        </td>
                        <td>${product.description}</td>
                        <td>${product.price}</td>`;

            if(type == 'index') {
                html += `<td><form onsubmit="addToCartForm(${product.id}); return false;">
                                <button type="submit">Add to cart</button>
                            </form>
                        </td>`;
            } else {
                html += `<td>
                            <form onsubmit="removeFromCart(${product.id}); return false;">
                            <button type="submit">Remove</button>
                            </form>
                        </td>`;
            }

            html += `</tr>`;
        });

        if (products.length > 0 && type == 'cart') {
            $('#checkout-form').show();
        } else {
            $('#checkout-form').hide();
        }

        return html;
    }

    window.onhashchange = function () {
        $('.page').hide();

        switch (window.location.hash) {
            case '#cart':
                $('.cart').show();
                $.ajax('ajax/cart', {
                    dataType: 'json',
                    success: function (response) {
                        $('.cart .list').html(renderList(response, 'cart'));
                    }
                });
                break;
            default:
                $('.index').show();
                $.ajax('/ajax/index', {
                    dataType: 'json',
                    success: function (response) {
                        $('.index .list').html(renderList(response, 'index'));
                    }
                });
                break;
        }
    }

    window.addToCartForm = function (id) {
        $.ajax('/ajax/cart', {
            type: 'POST',
            dataType: 'json',
            data: {product_id:id},
            success: function (response) {
                $('.index .list').html(renderList(response, 'index'));
            }
        });
    }

    window.removeFromCart = function (id) {
        $.ajax('/ajax/cart/remove', {
            type: 'POST',
            dataType: 'json',
            data: {product_id:id},
            success: function (response) {
                $('.cart .list').html(renderList(response, 'cart'));
            }
        });
    }

    window.checkout = function () {
        var name = $('.checkout-name').val();
        var details = $('.checkout-details').val();
        var comment = $('.checkout-comment').val();
        var errorsHtml = '';

        $.ajax('/ajax/checkout', {
            type: 'POST',
            dataType: 'json',
            data: {name:name, contact_details:details, comment:comment},
            success: function (response) {
                $('.error').hide();
                name = '';
                details = '';
                comment = '';
                $('.cart .list').html(renderList(response, 'cart'));
            },
            error: function (response) {
                $('.error').show();
                var errors = response.responseJSON;
                errorsHtml = `<ul>`;
                $.each(errors.errors , function(key, value) {
                    errorsHtml += `<li>${value}</li>`;
                });
                errorsHtml += `</ul>`;
                $('.error').html(errorsHtml);
            },
        });
    }

    init();
    window.onhashchange();

});
