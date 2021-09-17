<template>
    <div>
        <div class="error" v-if="errors">
            <ul>
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </div>
        <form @submit.prevent="updateProduct()" id="checkout-form" class="checkout-form" style="height: auto" enctype="multipart/form-data">
            <div>
                <label>Title</label>
                <input type="text" name="title" v-model="product.title">
            </div>
            <div>
                <label>Description</label>
                <textarea name="description" v-model="product.description"></textarea>
            </div>
            <div>
                <label>Price</label>
                <input type="text" name="price" v-model="product.price">
            </div>
            <div>
                <img v-if="product.image_path" v-bind:src="'../../' + product.image_path" class="product_image" alt="Product Image" style="height: 50px; width:50px">
                <input type="file" name="image" accept="image/*" id="fileToUpload" @change="onFileChanged">
            </div>
            <button class="btn-send" type="submit">Edit</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                product: {},
                errors: [],
                image: '',
            }
        },
        created() {
            var id = this.$route.params.id
            this.axios
               .get('http://localhost:8000/products/' + id + '/edit')
               .then(response => {
                   this.product = response.data;
                   this.id = this.product.id;
               });

        },
        methods: {
            updateProduct() {
                var formData = new FormData();
                formData.append('_method', 'PUT');
                formData.append('title', this.product.title);
                formData.append('description', this.product.description);
                formData.append('price', this.product.price);
                formData.append('image', this.image);
                this.axios
                    .post(`http://localhost:8000/products/` + this.id, formData)
                    .then(response => {
                        this.errors = [];
                        this.image = null;
                        this.$router.push({ name: 'vue.products'})
                    })
                    .catch(e => {
                       this.errors = e.response.data.errors;
                    });
            },
            onFileChanged(event) {
                this.image = event.target.files[0];
            }
        }
    }
</script>