import IndexComponent from "./components/IndexComponent.vue";
import CartComponent from "./components/CartComponent.vue";

export const routes = [
    {
        name: 'vue',
        path: '/vue',
        component: IndexComponent
    },
    {
        name: 'vue.cart',
        path: '/vue/cart',
        component: CartComponent
    },
]