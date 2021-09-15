$(document).ready(function () {

    var logged = sessionStorage.getItem('logged');

    window.onhashchange = function () {
        $('.page').hide();
        var page = [];

        if (sessionStorage.getItem('logged')) {
            $('.login-link').hide();
            $('.products-link').show();
            $('.orders-link').show();
            $('.logout-link').show();
        } else {
            $('.login-link').show();
            $('.products-link').hide();
            $('.orders-link').hide();
            $('.logout-link').hide();
        }

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
                $('.products').show();
                $.ajax('/products', {
                    dataType: 'json',
                    success: function (response) {
                        $('.products .products-list').html(productsPageList(response));
                    },
                    error: function (response) {
                        if(response.status === 401) {
                            window.location.hash = '#login';
                        }
                    }
                });
                break;
            case '#product-edit':
                break;
            case '#product':
                $('.product').show();
                productPage();
                break;
            case '#orders':
                $('.orders').show();
                $.ajax('/orders', {
                    dataType: 'json',
                    success: function (response) {
                        $('.orders .orders-list').html(ordersPageList(response));
                    },
                    error: function (response) {
                        if(response.status === 401) {
                            window.location.hash = '#login';
                        }
                    }
                });
                break;
            case '#login':
                $('.login').show();
                if (sessionStorage.getItem('logged')) {
                    window.location.hash = '#products'
                }
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

    $(document).on('submit','#checkout-form', function (e) {
        e.preventDefault();

        var name = $('.checkout-name').val();
        var details = $('.checkout-details').val();
        var comment = $('.checkout-comment').val();
        var errorsHtml = '';

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

    $(document).on('submit','#login-form', function (e) {
        var email = $('.login-email').val();
        var password = $('.login-pass').val();
        var errorsHtml = '';
        e.preventDefault();

        $.ajax('/login', {
            type: 'POST',
            dataType: 'json',
            data: {email:email, password:password},
            success: function (response) {
                $('.login-error').hide();
                $('.login-link').hide();
                email = '';
                password = '';
                sessionStorage.setItem('logged', true);
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

    $(document).on('submit','form.logout-link', function (e) {
        $.ajax('/logout', {
            type: 'POST',
            dataType: 'json',
            success: function (response) {
                sessionStorage.removeItem('logged');
                window.location.hash = '#index';
            }
        });
    });

    function productsPageList(products) {
        var html = '';
        html = `<tr>
                    <th>Nr</th>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Actions</th>
                </tr>`;

        $.each(products, function (key, product) {
            html += `<tr>
                        <td>${key + 1}</td>
                        <td>${product.title}</td>
                        <td>
                            <img src="${product.image_path ? product.image_path : 'images/placeholder.png'}">
                        </td>
                        <td>${product.description}</td>
                        <td>${product.price}</td>`;

            html += `<td>
                        <a href="#product-edit" class="editProduct" data-id="${product.id}">Edit</a>
                        <form class="deleteProduct" data-id="${product.id}">
                            <button type="submit">Delete</button>
                        </form>
                    </td>`;
            html += `</tr>`;
        });
        return html;
    }

    function productPage(product = null) {
        if (product) {
            $('form').attr('id', 'editProduct');
            $('.btn-send.product').html('Edit');
            $('.method').val('PUT');
            $('.product_id').val(product.id);
            $('.product_name').val(product.title);
            $('.product_description').val(product.description);
            $('.product_price').val(product.price);
            if (product.image_path) {
                $('.product_image').attr('src', product.image_path);
            } else {
                $('.product_image').hide();
            }
        } else {
            $('form').attr('id', 'createProduct');
            $('.product_id').val('');
            $('.method').val('');
            $('.product_name').val('');
            $('.product_description').val('');
            $('.product_price').val('');
            $('.product_image').hide();
            $('.btn-send.product').html('Save');
        }

    }

    $(document).on('submit','form.deleteProduct', function (e) {
        var id = $(this).attr('data-id');
        $.ajax('/products/' + id, {
            type: 'DELETE',
            dataType: 'json',
            success: function (response) {
                $('.products .products-list').html(productsPageList(response));
            },
            error: function (response) {
                if(response.status === 401) {
                    window.location.hash = '#login';
                }
            }
        });
    });

    $(document).on('click','.editProduct', function (e) {
        var id = $(this).attr('data-id');
        if (id) {
            $.ajax('/products/' + id + '/edit', {
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    $('.product').show();
                    productPage(response);
                },
                error: function (response) {
                    if (response.status === 401) {
                        window.location.hash = '#login';
                    }
                }
            });
        } else {
            productPage();
        }
    });

    $(document).on('submit','form#createProduct', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        var errorsHtml = '';

        $.ajax('/products', {
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
                window.location.hash = '#products';
            },
            error: function (response) {
                var status = response.status;
                if (status === 401) {
                    $("#fileToUpload").val('');
                    window.location.hash = '#login';
                }
                if (status === 422) {
                    $('.product-error').show();
                    var errors = response.responseJSON;
                    errorsHtml = `<ul>`;
                    $.each(errors.errors, function (key, value) {
                        errorsHtml += `<li>${value}</li>`;
                    });
                    errorsHtml += `</ul>`;
                    $('.product-error').html(errorsHtml);
                }
            }
        });
    });

    $(document).on('submit','form#editProduct', function (e) {
        e.preventDefault();
        var id = $('.product_id').val();
        var formData = new FormData(this);
        var errorsHtml = '';

        $.ajax('/products/' + id, {
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (response) {
                $("#fileToUpload").val('');
                window.location.hash = '#products';
            },
            error: function (response) {
                var status = response.status;
                if(status === 401) {
                    window.location.hash = '#login';
                }
                if (status === 422) {
                    $('.product-error').show();
                    var errors = response.responseJSON;
                    errorsHtml = `<ul>`;
                    $.each(errors.errors, function (key, value) {
                        errorsHtml += `<li>${value}</li>`;
                    });
                    errorsHtml += `</ul>`;
                    $('.product-error').html(errorsHtml);
                }
            }
        });
    });

    function ordersPageList(orders) {
        var html = '';
        html = `<tr>
                    <th>Nr</th>
                    <th>Date</th>
                    <th>Contact Details</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>`;

        $.each(orders, function (key, order) {
            html += `<tr>
                        <td>${key + 1}</td>
                        <td>${order.created_at}</td>
                        <td>
                            <table>
                                <tr>
                                    <td>Name</td>
                                    <td>${order.name}</td>
                                </tr>
                                <tr>
                                    <td>Contact Details</td>
                                    <td>${order.contact_details}</td>
                                </tr>
                                <tr>
                                    <td>Comment</td>
                                    <td>${order.comment}</td>
                                </tr>
                            </table>
                        </td>
                        <td>${order.total}</td>
                        <td><a href="#order">Details</a></td>
                    </tr>`;
        });
        return html;
    }

});
