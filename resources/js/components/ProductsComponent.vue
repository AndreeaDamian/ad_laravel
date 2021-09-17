<template>
    <div>
        <router-link to="/vue/product/">Add Product</router-link>
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
                <td><img v-bind:src="'../' + getImage(product.image_path)" style="height: 100px; width: 100px"></td>
                <td>{{ product.description }}</td>
                <td>{{ product.price }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{ name: 'vue.product.edit', params: { id: product.id }}">Edit</router-link>
                        <form @submit.prevent="deleteProduct(product.id)">
                            <button type="submit">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
    </div>
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
                .get('http://localhost:8000/products')
                .then(response => {
                    this.products = response.data;
                })
                .catch(e => {
                   if (e.response.status === 401) {
                       this.$router.push({ name: 'vue.login'})
                   }
                });
        },
        methods: {
            deleteProduct(id) {
                this.axios
                    .delete(`http://localhost:8000/products/${id}`)
                    .then(response => {
                        this.products = response.data;
                    });
            },

            getImage(image) {
                if (image) {
                    return image
                } else {
                    return 'images/placeholder.png'
                }
            }
        }
    }
</script>