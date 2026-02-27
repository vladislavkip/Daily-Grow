<template>
  <div class="review-card">
    <div class="review-header">
      <div>
        <div class="review-author">
          {{ author || 'Anonymous' }}
        </div>
        <div class="review-date">
          {{ date }}
        </div>
      </div>

      <div class="stars">
        <div class="stars-bg">★★★★★</div>
        <div
          class="stars-fill"
          :style="{ width: (rating / 5) * 100 + '%' }"
        >
          ★★★★★
        </div>
      </div>
    </div>
    
    <div class="review-text">
      {{ text }}
    </div>
  </div>
</template>

<script>
export default {
  props: ['text', 'author', 'rating', 'date']
}
</script>