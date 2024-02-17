<template>
  <div class="jumbotron tw-mb-6">
    <h1 class="tw-font-bold tw-text-xl">{{ $t('home.title') }}</h1>
    <p>{{ $t('home.lead') }}</p>
  </div>
  <div class="md:tw-flex md:tw-w-full">
    <Card class="tw-mb-6 md:tw-mb-0">
      <template #title>
        {{ $t('home.cardOneTitle') }}
      </template>
      <template #content>
        {{ $t('home.cardOneText') }}
      </template>
    </Card>
    <Card class="tw-mb-6 md:tw-mb-0 md:tw-ml-3 md:tw-mr-3">
      <template #title>
        {{ $t('home.cardTwoTitle') }}
      </template>
      <template #content>
        {{ $t('home.cardTwoText') }}
      </template>
    </Card>
    <Card class="tw-mb-6 md:tw-mb-0">
      <template #title>
        {{ $t('home.cardThreeTitle') }}
      </template>
      <template #content>
        {{ $t('home.cardThreeText') }}
      </template>
    </Card>
  </div>
</template>
<style scoped>
.jumbotron {
  background: url("/images/corpjuridicoint-logo.png") no-repeat left center;
  border-radius: 0.3rem;
  padding: 4rem 2rem;
}
</style>
<script setup lang="ts">
import Card from '../Card.vue';
</script>