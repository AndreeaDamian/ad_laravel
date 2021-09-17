<template>
    <div>
        <table>
            <tr>
                <td>Name</td>
                <td>{{ order.name }}</td>
            </tr>
            <tr>
                <td>Contact Details</td>
                <td>{{ order.contact_details }}</td>
            </tr>
            <tr>
                <td>Comment</td>
                <td>{{ order.comment }}</td>
            </tr>
        </table>
        <br/>
        <table class="list">
            <tr>
                <th>Title</th>
                <th>Image</th>
                <th>Description</th>
                <th>Price</th>
            </tr>
            <tr v-for="product in order.products">
                <td>{{ product.title }}</td>
                <td>
                    <img v-bind:src="'../../' + getImage(product.image_path)" class="product_image" alt="Product Image" style="height: 50px; width:50px">
                </td>
                <td>{{ product.description }}</td>
                <td>{{ product.price }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                order: {}
            }
        },
        created() {
            var id = this.$route.params.id
            this.axios
                .get('http://localhost:8000/orders/'+ id)
                .then(response => {
                    this.order = response.data;
                });
        },
        methods: {
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