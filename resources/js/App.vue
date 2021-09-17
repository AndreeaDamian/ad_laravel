<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">
                    <router-link to="/vue" class="nav-item nav-link">Home</router-link>
                    <router-link to="/vue/cart" class="nav-item nav-link">Cart</router-link>
                    <router-link v-if="logged" to="/vue/products" class="nav-item nav-link">Products</router-link>
                    <router-link v-if="logged" to="/vue/orders" class="nav-item nav-link">Orders</router-link>
                    <router-link v-if="!logged" to="/vue/products" class="nav-item nav-link">Login</router-link>
                    <form v-if="logged" @submit.prevent="logout">
                        <button type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
        <br/>
        <router-view></router-view>
    </div>
</template>


<script>
    export default {
        data() {
           return {
               logged: false
           }
        },
        created() {
           if (sessionStorage.getItem('logged')) {
               this.logged = true;
           }
        },
        methods: {
            logout() {
                this.axios
                    .post(`http://localhost:8000/logout`)
                    .then(response => {
                        sessionStorage.removeItem('logged');
                        this.logged = false;
                        this.$router.push({ name: 'vue'})
                    });
            }
        }
    }
</script>