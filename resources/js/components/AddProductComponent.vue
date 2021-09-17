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
                <input type="text" name="title" v-model="title">
            </div>
            <div>
                <label>Description</label>
                <textarea name="description" v-model="description"></textarea>
            </div>
            <div>
                <label>Price</label>
                <input type="text" name="price" v-model="price">
            </div>
            <div>
                <input type="file" name="image" accept="image/*" id="fileToUpload" @change="onFileChanged">
            </div>
            <button class="btn-send" type="submit">Add</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            errors: [],
            image: '',
            title: '',
            description: '',
            price: '',
            product: {}
        }
    },
    methods: {
        updateProduct() {
            var formData = new FormData();
            formData.append('title', this.title);
            formData.append('description', this.description);
            formData.append('price', this.price);
            formData.append('image', this.image);
            this.axios
                .post(`http://localhost:8000/products`, formData)
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