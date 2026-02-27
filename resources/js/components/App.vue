<template>
  <router-view :user="user" />
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
      user: null
    }
  },

  async created() {
    try {
      const response = await axios.get('/user', {
        withCredentials: true
      })

      this.user = response.data
    } catch (e) {
      this.user = null
    }
  }
}
</script>