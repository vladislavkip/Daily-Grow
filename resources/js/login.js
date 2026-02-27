import './bootstrap'
import { createApp } from 'vue'
import LoginPage from './components/Pages/Login.vue'
import '../css/app.css'

const loginApp = createApp({})
loginApp.component('login-page', LoginPage)
loginApp.mount('#login')