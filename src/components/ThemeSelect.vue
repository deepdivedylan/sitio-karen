<template>
  <button @click="toggleDark()"><component class="tw-h-6" :is="isDark ? SunIcon : MoonIcon" /></button>
</template>
<script setup lang="ts">
import { MoonIcon, SunIcon } from '@heroicons/vue/24/outline';
import { useDark, useToggle } from '@vueuse/core';

const isDark = useDark({
  attribute: 'class',
  selector: 'body',
  valueDark: 'tw-bg-stone-900',
  valueLight: 'tw-bg-white'
});
const toggleDark = useToggle(isDark);
</script>