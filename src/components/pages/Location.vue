<template>
  <h1 class="tw-text-2xl tw-font-bold tw-pb-6">{{ $t('nav.location') }}</h1>
  <GMapMap
      class="google-map"
      :center="center"
      :zoom="16"
  >
    <GMapMarker
        @click="open = !open"
        :position="center"
    >
      <GMapInfoWindow
          :closeclick="true"
          @closeclick="open = false"
          :opened="open"
      >
        <div class="tw-text-black">
          <p class="tw-font-bold">{{ $t('home.title') }}</p>
          <p>José Clemente Orozco 10093-Suite 4A<br />Zona Urbana Rio Tijuana<br />22010 Tijuana, B.C.<br />México</p>
          <p><a class="tw-text-blue-500 tw-font-semibold" href="tel:+526645201152">664 520 1152</a></p>
        </div>
      </GMapInfoWindow>
    </GMapMarker>
  </GMapMap>
</template>
<script setup lang="ts">
import { ref } from 'vue';
const center = { lat: 32.5227978, lng: -117.0151124 };
const open = ref(false);
</script>
<style scoped>
.google-map {
  height: 75vh;
}
</style>