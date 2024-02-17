<template>
  <button
      class="tw-font-medium tw-rounded-lg tw-text-sm tw-px-5 tw-py-2.5 tw-me-2 tw-mb-2 focus:tw-outline-none"
      :class="buttonClass"
      :disabled="disabled"
      :type="buttonType">
    <slot></slot>
  </button>
</template>
<script setup lang="ts">
import { useIsFormDirty, useIsFormValid } from 'vee-validate';
import { computed, ref } from 'vue';

export interface Props {
  submit: boolean,
  type: string
};
const props = withDefaults(defineProps<Props>(), {
  submit: false,
  type: 'primary'
});

const dirty = useIsFormDirty();
const valid = useIsFormValid();
const classes = {
  primary: {
    disabled: 'tw-text-white tw-bg-blue-400 focus:tw-ring-4 focus:tw-ring-blue-300 dark:tw-bg-blue-400 dark:focus:tw-ring-blue-800 tw-cursor-not-allowed',
    enabled: 'tw-text-white tw-bg-blue-700 hover:tw-bg-blue-800 focus:tw-ring-4 focus:tw-ring-blue-300 dark:tw-bg-blue-600 dark:hover:tw-bg-blue-700 dark:focus:tw-ring-blue-800'
  },
  secondary: {
    disabled: 'tw-text-gray-900 tw-bg-white tw-border-gray-800 dark:tw-border-gray-200 tw-focus:z-10 tw-focus:ring-4 tw-focus:ring-gray-200 dark:focus:tw-ring-gray-700 dark:tw-bg-gray-600 dark:tw-text-gray-400 dark:tw-border-gray-600 tw-cursor-not-allowed',
    enabled: 'tw-text-gray-900 tw-bg-white tw-border-gray-800 dark:tw-border-gray-200 hover:bg-gray-100 tw-hover:text-blue-700 tw-focus:z-10 tw-focus:ring-4 tw-focus:ring-gray-200 dark:focus:tw-ring-gray-700 dark:tw-bg-gray-800 dark:tw-text-gray-400 dark:tw-border-gray-600 dark:hover:tw-text-white dark:hover:tw-bg-gray-700'
  },
};
const buttonClass = ref(classes[props.type as keyof typeof classes].enabled);
const disabled = computed(() => {
  const disable = props.submit && (!dirty.value || !valid.value);
  buttonClass.value = disable ? classes[props.type as keyof typeof classes].disabled : classes[props.type as keyof typeof classes].enabled;
  return disable;
});
const buttonType = props.submit ? 'submit' : 'button';
</script>