<template>
  <div class="tw-h-6 tw-cursor-pointer tw-flex" @click="selectLocale">
    <div class="tw-pr-3">
      <img class="tw-h-6" :src="'/images/flag-' + otherLocale + '.svg'" :alt="$t('nav.alt')" />
    </div>
    <div>
      {{ $t('nav.' + otherLocale) }}
    </div>
  </div>
</template>
<script setup lang="ts">
import { useI18n } from 'vue-i18n';
import { Ref, ref } from 'vue';
import { useStorage } from '@vueuse/core';

const { availableLocales, locale } = useI18n({ useScope: 'global' });
const getOtherLocale = (): string => {
  const result = availableLocales.find(language => language !== locale.value);
  return result ? result : '';
};
const setLocaleToHtmlTag = () => {
  const tags = document.getElementsByTagName('html');
  if (tags.length === 1) {
    tags[0].lang = locale.value;
  }
};
setLocaleToHtmlTag();

const otherLocale: Ref<string> = ref(getOtherLocale());
const localPreference = useStorage('vueuse-i18n-locale', locale.value);

const selectLocale = () => {
  locale.value = otherLocale.value;
  localPreference.value = locale.value;
  otherLocale.value = getOtherLocale();
  setLocaleToHtmlTag();
};
</script>