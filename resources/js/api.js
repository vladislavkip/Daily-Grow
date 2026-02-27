import axios from 'axios'

export default axios.create({
    baseURL: '/',
    withCredentials: true, // важно для сессий Laravel
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
})