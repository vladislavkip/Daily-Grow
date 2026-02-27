<template>
  <div class="layout">
    <Sidebar :active="'reviews'" :user="user"/>

    <div class="main">
      <Topbar title="Отзывы" />

      <div class="content">
        <div class="left">
          <ReviewCard
            v-for="(review, index) in paginatedReviews"
            :key="index"
            :date="review.date"
            :text="review.text"
            :author="review.author"
            :rating="review.rating"
          />

          <!-- Pagination -->
          <div class="pagination">
            <button
              class="pagination-btn"
              :disabled="currentPage === 1"
              @click="prevPage"
            >
              Предыдущая
            </button>

            <span class="pagination-info">
              Страница {{ currentPage }} из {{ totalPages }}
            </span>

            <button
              class="pagination-btn"
              :disabled="currentPage === totalPages"
              @click="nextPage"
            >
              Следующая
            </button>
          </div>
        </div>

        <div class="right">
          <Rating :score="rating" :count="reviews.length"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Sidebar from '../Layout/Sidebar.vue'
import Topbar from '../Layout/Topbar.vue'
import ReviewCard from '../Common/ReviewCard.vue'
import Rating from '../Common/Rating.vue'
import axios from 'axios'

export default {
  components: { Sidebar, Topbar, ReviewCard, Rating },
  props: ['user'],
  data() {
    return {
      reviews: [],
      rating: null,
      currentPage: 1,
      perPage: 5
    }
  },
  computed: {
    totalPages() {
      return Math.ceil(this.reviews.length / this.perPage)
    },
    paginatedReviews() {
      const start = (this.currentPage - 1) * this.perPage
      return this.reviews.slice(start, start + this.perPage)
    }
  },
  methods: {
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--
      }
    }
  },
  async created() {
    try {
      const response = await axios.get('/reviews/data', { withCredentials: true })
      this.reviews = response.data.reviews
      this.rating = response.data.rating
    } catch (e) {
      console.error('Failed to load reviews:', e)
    }
  }
}
</script>