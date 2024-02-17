<template>
  <div class="tw-block tw-rounded-lg tw-bg-white tw-text-center">
    <div class="px-6 py-3 tw-bg-neutral-400 dark:tw-border-neutral-600 dark:tw-bg-neutral-700 dark:tw-text-neutral-100">
      <slot name="title"></slot>
    </div>
    <div class="tw-p-6 tw-bg-neutral-300 dark:tw-bg-neutral-500">
      <p class="tw-mb-4 tw-text-base tw-text-neutral-800 dark:tw-text-neutral-100">
        <slot name="content"></slot>
      </p>
    </div>
  </div>
</template>