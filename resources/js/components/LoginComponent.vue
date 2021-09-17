<template>
    <div>
        <div class="error" v-if="errors">
            <ul>
                <li v-for="error in errors">
                    {{ error }}
                </li>
            </ul>
        </div>
        <form @submit.prevent="login" id="checkout-form" class="checkout-form" style="height: auto">
            <div>
                <label>Email</label>
                <input type="email" name="email" v-model="email">
            </div>
            <div>
                <label>Password</label>
                <input type="password" name="password" v-model="password">
            </div>
            <button class="btn-send" type="submit">Login</button>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                errors: [],
                password: null,
                email: null
            }
        },
        created() {
            if (sessionStorage.getItem('logged')) {
                this.$router.push({ name: 'vue.products'})
            }
        },
        methods: {
            login() {
                this.axios
                    .post(`http://localhost:8000/login`, {
                        email: this.email,
                        password: this.password
                    })
                    .then(response => {
                        sessionStorage.setItem('logged', true);
                        this.$router.push({ name: 'vue.products'})
                    })
                    .catch(e => {
                        this.errors = e.response.data.errors;
                    });
            }
        }
    }
</script>