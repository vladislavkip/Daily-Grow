<template>
  <aside class="sidebar">
    <div class="sideblock"><img :src="Logo" alt="Daily Grow" class="logo-icon"/>

    <div class="account-name">
      {{ user?.name || 'Loading...' }}
    </div>

    <div class="menu">
      <div class="menu-title"><img :src="Tool" alt="Отзывы" class="tool-icon"/>Меню</div>

      <ul>
        <li
          :class="{ active: active === 'reviews' }"
          @click="$router.push('/reviews')"
        >
          Отзывы
        </li>

        <li
          :class="{ active: active === 'settings' }"
          @click="$router.push('/settings')"
        >
          Настройки
        </li>
      </ul>
    </div></div>
  </aside>
</template>

<script>

import Logo from '@/../images/logo.png';
import Tool from '@/../images/tool.png';


export default {
  props: ['active', 'user'],
  data() {
    return {
      Logo,
      Tool
    }
  }
}
</script>