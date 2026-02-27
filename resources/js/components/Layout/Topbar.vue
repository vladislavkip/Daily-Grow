<template>
  <div class="topbar">
    <div class="topbar-title">
      {{ title }}
    </div>

    <img :src="Logout" alt="Выйти" class="logout-btn" @click="logout" />

  </div>
</template>

<script>
import axios from 'axios'
import Logout from '@/../images/logout.png';

export default {
  props: ['title'],
  data() {
    return {
      Logout
    }
  },
  methods: {
    async logout() {
      try {
        await axios.post('/logout', {}, { withCredentials: true })
      } catch (e) {
        console.error(e)
      } finally {
        window.location.href = '/'
      }
    }
  }
}
</script>