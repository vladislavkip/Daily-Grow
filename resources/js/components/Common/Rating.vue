<template>
  <div class="rating-card">
    <div class="rating-score">
      {{ score || 0 }}
    

    <div class="stars big">
      <div class="stars-bg">★★★★★</div>
      <div
        class="stars-fill"
        :style="{ width: (score / 5) * 100 + '%' }"
      >
        ★★★★★
      </div>
    </div>
</div>
<hr>
    <div class="rating-count">
      Всего отзывов: {{ count }}
    </div>
  </div>
</template>

<script>
export default {
  props: ['score', 'count']
}
</script>