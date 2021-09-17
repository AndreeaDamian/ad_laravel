<template>
    <table class="list">
        <tr>
            <th>Title</th>
            <th>Image</th>
            <th>Description</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <tr v-for="product in products" :key="product.id">
            <td>{{ product.title }}</td>
            <td>{{ product.image }}</td>
            <td>{{ product.description }}</td>
            <td>{{ product.price }}</td>
            <td>
                <div class="btn-group" role="group">
                    <form @submit.prevent="addToCart(product.id)">
                        <button type="submit">Add to cart</button>
                    </form>
                </div>
            </td>
        </tr>
    </table>
</template>

<script>
    export default {
        data() {
            return {
                products: []
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/')
                .then(response => {
                    this.products = response.data;
                });
        },
        methods: {
            addToCart(id) {
                this.axios
                    .post(`http://localhost:8000/cart`, {product_id:id})
                    .then(response => {
                        this.products = response.data;
                    });
            }
        }
    }
</script>