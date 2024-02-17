<template>
  <div class="tw-flex tw-flex-col tw-justify-between tw-h-full tw-min-h-screen tw-w-screen tw-text-black dark:tw-text-stone-200">
    <Nav :pages="pages" />
    <main class="tw-container tw-px-6 tw-py-8 tw-mx-auto tw-text-xl">
      <router-view />
    </main>
    <Footer />
  </div>
</template>
<script setup lang="ts">
import Footer from './components/Footer.vue';
import Nav from './components/Nav.vue';
import NavRoute from './interfaces/NavRoute.ts';

const pages: Array<NavRoute> = [
  { href: '/', label: 'home' },
  { href: '/location', label: 'location' },
  { href: '/contact', label: 'contact' }
];
</script>
