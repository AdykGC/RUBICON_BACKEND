// app.js
import './bootstrap';
import { createApp } from 'vue'
import Home from './rubicon/Home.vue'
import Product from './rubicon/Product.vue'

const routes = {
    '/': Home,
    '/product': Product,
}

const rawPath = window.location.pathname.replace('/rubicon', '')
const path = rawPath === '' ? '/' : rawPath
const View = routes[path] || Home

createApp(View).mount('#app')