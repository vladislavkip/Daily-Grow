<template>
  <div class="layout">
    <Sidebar :active="'settings'" :user="user" />

    <div class="main">
      <Topbar title="Настройки" />

      <div class="content">
        <div class="settings-card">
          <h2 class="settings-title">Подключить Яндекс</h2>

          <p class="settings-subtitle">
            Укажите ссылку на Яндекс, пример
            <span class="settings-example">
              <a href="https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/">https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/</a>
            </span>
          </p>

          <form class="settings-form" @submit.prevent="save">
            <input
              v-model="yandexUrl"
              class="settings-input"
              placeholder="https://yandex.ru/maps/..."
            />

            <button
              type="submit"
              class="settings-button"
              :disabled="loading"
            >
              {{ loading ? 'Сохранение...' : 'Сохранить' }}
            </button>
          </form>

          <p v-if="message" class="settings-message">
            {{ message }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from '../Layout/Sidebar.vue'
import Topbar from '../Layout/Topbar.vue'
import axios from 'axios'

export default {
  components: { Sidebar, Topbar },
  props: ['user'],
  data() {
    return {
      yandexUrl: '',
      loading: false,
      message: ''
    }
  },
  async created() {
    try {
      const response = await axios.get('/settings/yandex', { withCredentials: true })
      this.yandexUrl = response.data.yandex_url
    } catch (err) {
      console.error(err)
    }
  },
  methods: {
    async save() {
      this.loading = true
      this.message = ''
      try {
        const response = await axios.post('/settings/yandex', {
          yandex_url: this.yandexUrl
        }, { withCredentials: true })

        this.message = response.data.message
      } catch (err) {
        this.message = 'Failed to save.'
        console.error(err)
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

