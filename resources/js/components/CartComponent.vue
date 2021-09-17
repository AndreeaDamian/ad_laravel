<template>
    <div>
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
                        <form @submit.prevent="remove(product.id)">
                            <button type="submit">Remove</button>
                        </form>
                    </div>
                </td>
            </tr>
        </table>
        <br/>
        <div class="error" v-if="errors.length">
            <ul>
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </div>
        <div v-if="products.length">
            <form @submit.prevent="checkout" id="checkout-form" class="checkout-form" style="height: auto">
                <div>
                    <label>Name</label>
                    <input type="text" name="name" v-model="name">
                </div>
                <div>
                    <label>Contact Details</label>
                    <textarea name="contact_details" v-model="contact_details"></textarea>
                </div>
                <div>
                    <label>Comment</label>
                    <textarea name="comment" v-model="comment"></textarea>
                </div>
                <button class="btn-send" type="submit">Checkout</button>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: [],
                errors: [],
                name: null,
                contact_details: null,
                comment: null
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/cart')
                .then(response => {
                    this.products = response.data;
                });
        },
        methods: {
            remove(id) {
                this.axios
                    .post(`http://localhost:8000/cart/remove`, {product_id:id})
                    .then(response => {
                        this.products = response.data;
                    });
            },

            checkout() {
                this.axios
                    .post(`http://localhost:8000/checkout`, {
                        name: this.name,
                        contact_details: this.contact_details,
                        comment: this.comment
                    })
                    .then(response => {
                        this.errors = [];
                        this.name = null;
                        this.contact_details = null;
                        this.comment = null;
                        this.products = response.data;
                    })
                    .catch(e => {
                       this.errors = e.response.data.errors;
                    });
            }
        }
    }
</script>