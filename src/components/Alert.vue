<template>
  <div v-if="open" class="tw-flex tw-items-center tw-w-full tw-p-4 tw-text-sm tw-rounded-lg dark:tw-bg-stone-800" :class="typeClassesAndIcons[props.type as keyof typeof typeClassesAndIcons].classes" role="alert">
    <div class="tw-pr-1">
      <component class="tw-h-6 tw-inline" :is="typeClassesAndIcons[props.type as keyof typeof typeClassesAndIcons].icon" />
    </div>
    <div>
      <span class="tw-font-medium tw-pr-1">{{ label }}</span>
      <slot></slot>
    </div>
    <div v-if="dismissable" class="tw-ml-auto tw-cursor-pointer">
      <XMarkIcon class="tw-h-6" @click="toggleAlert()" />
    </div>
  </div>
</template>
<script setup lang="ts">
import { CheckCircleIcon, ExclamationTriangleIcon, InformationCircleIcon, ShieldExclamationIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { ref } from 'vue';
import { useToggle } from '@vueuse/core';

export interface Props {
  dismissable: boolean,
  label: string,
  type: string
};
const props = withDefaults(defineProps<Props>(), {
  dismissable: true,
  label: '',
  type: 'info'
});
const open = ref(true);
const toggleAlert = useToggle(open);

const typeClassesAndIcons = {
  danger: {
    classes: 'tw-bg-red-200 tw-text-red-800 dark:tw-text-red-800',
    icon: ShieldExclamationIcon
  },
  info: {
    classes: 'tw-bg-blue-200 tw-text-blue-800 dark:tw-text-blue-400',
    icon: InformationCircleIcon
  },
  success: {
    classes: 'tw-bg-green-200 tw-text-green-800 dark:tw-text-green-400',
    icon: CheckCircleIcon
  },
  warning: {
    classes: 'tw-bg-yellow-200 tw-text-yellow-800 dark:tw-text-yellow-300',
    icon: ExclamationTriangleIcon
  }
};
</script>