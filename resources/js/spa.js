$(document).ready(function () {

    var logged = false;

    $(document).on('submit','#checkout-form', function (e) {
        var name = $('.checkout-name').val();
        var details = $('.checkout-details').val();
        var comment = $('.checkout-comment').val();
        var errorsHtml = '';

        e.preventDefault();

        $.ajax('/checkout', {
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
    });

    $(document).on('submit','#login-form', function (e) {
        var email = $('.login-email').val();
        var password = $('.login-pass').val();
        var errorsHtml = '';
        e.preventDefault();

        $.ajax('/login', {
            type: 'POST',
            dataType: 'json',
            data: {email:email, password:password},
            success: function () {
                $('.login-error').hide();
                $('.login-link').hide();
                email = '';
                password = '';
                logged = true;
                $('.products-link').show();
                $('.orders-link').show();
                $('.logout-link').show();
                window.location.hash = '#products';
            },
            error: function (response) {
                $('.login-error').show();
                var errors = response.responseJSON;
                errorsHtml = `<p>${errors.message}</p>`;
                $('.login-error').html(errorsHtml);
            },
        });
    });

    $(document).on('submit','form.addToCart', function (e) {
        var id = $(this).attr('data-id');
        $.ajax('/cart', {
            type: 'POST',
            dataType: 'json',
            data: {product_id:id},
            success: function (response) {
                $('.index .list').html(renderList(response, 'addToCart'));
            }
        });
    });

    $(document).on('submit','form.remove', function (e) {
        var id = $(this).attr('data-id');
        $.ajax('/cart/remove', {
            type: 'POST',
            dataType: 'json',
            data: {product_id:id},
            success: function (response) {
                $('.cart .list').html(renderList(response, 'remove'));
            }
        });
    });

    function renderList(products, page) {
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

                html += `<td><form class="${page['form-method']}" data-id="${product.id}">
                                <button type="submit">${page['form-method']}</button>
                            </form>
                        </td>`;
            html += `</tr>`;
        });

        if (products.length > 0 && page['name'] == 'cart') {
            $('#checkout-form').show();
        } else {
            $('#checkout-form').hide();
        }

        return html;
    }

    window.onhashchange = function () {
        $('.page').hide();
        var page = [];
        switch (window.location.hash) {
            case '#cart':
                $('.cart').show();
                $.ajax('/cart', {
                    dataType: 'json',
                    success: function (response) {
                        page['name'] = 'cart';
                        page['form-method'] = 'remove'
                        $('.cart .list').html(renderList(response, page));
                    }
                });
                break;
            case '#products':
                $('.cart').show();
                $.ajax('/products', {
                    dataType: 'json',
                    success: function (response) {
                        $('.cart .list').html(renderList(response, 'products'));
                    }
                });
                break;
            case '#login':
                $('.login').show();
                break;
            default:
                $('.index').show();
                page['name'] = 'index';
                page['form-method'] = 'addToCart'
                $.ajax('/', {
                    dataType: 'json',
                    success: function (response) {
                        $('.index .list').html(renderList(response, page));
                    }
                });
                break;
        }
    }

    window.onhashchange();

});
