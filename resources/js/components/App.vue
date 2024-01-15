<template>
  <div>
    <h1>Dictionary Demo App</h1>

    <p>
      <router-link :to="{ name: 'Dictionary' }">Dictionary</router-link> |
      <router-link :to="{ name: 'Login' }">Login</router-link>
    </p>

    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>
<script>
export default {}
</script>