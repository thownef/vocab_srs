<template>
  <section id="main" class="p-0 h-screen">
    <RouterView v-slot="{ Component }">
      <transition name="page" mode="out-in">
        <component :is="Component" />
      </transition>
    </RouterView>
  </section>
</template>

<script setup lang="ts"></script>

<style lang="" scoped></style>
