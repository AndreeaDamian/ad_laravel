import IndexComponent from "./components/IndexComponent.vue";
import CartComponent from "./components/CartComponent.vue";
import LoginComponent from "./components/LoginComponent.vue";
import ProductsComponent from "./components/ProductsComponent.vue";
import ProductComponent from "./components/ProductComponent.vue";
import AddProductComponent from "./components/AddProductComponent.vue";

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
    {
        name: 'vue.login',
        path: '/vue/login',
        component: LoginComponent
    },
    {
        name: 'vue.products',
        path: '/vue/products',
        component: ProductsComponent
    },
    {
        name: 'vue.product.edit',
        path: '/vue/product/:id',
        component: ProductComponent
    },
    {
        name: 'vue.product.create',
        path: '/vue/product',
        component: AddProductComponent
    },
]