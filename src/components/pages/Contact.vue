<template>
  <h1>{{ $t('contact.contact') }}</h1>
  <Form @submit="send">
    <div v-for="field of fields" :key="field.name" class="tw-mb-6">
      <label class="tw-block" :for="field.name">{{ $t('contact.' + field.name + '.label') }}</label>
      <Field v-if="field.type === 'textarea'" class="tw-block dark:tw-text-black" as="textarea" :id="field.name" :name="field.name" :type="field.type" :placeholder="$t('contact.' + field.name + '.placeholder')" :rules="field.rules" cols="32" rows="6" />
      <Field v-else class="tw-block dark:tw-text-black" :id="field.name" :name="field.name" :type="field.type" :placeholder="$t('contact.' + field.name + '.placeholder')" :rules="field.rules" size="32" />
      <ErrorMessage :name="field.name" v-slot="{ message }">
        <Alert class="tw-mt-3 md:tw-w-1/2" :dismissable="false" label="" type="warning">{{ message }}</Alert>
      </ErrorMessage>
    </div>
    <Button :submit="true" type="primary"><EnvelopeIcon class="tw-inline tw-h-3 tw-mr-3" />{{ $t('contact.send') }}</button>
    <p class="tw-text-[0.5rem] tw-mb-3">This site is protected by reCAPTCHA and the Google
      <a href="https://policies.google.com/privacy">Privacy Policy</a> and
      <a href="https://policies.google.com/terms">Terms of Service</a> apply.
    </p>
  </Form>
  <Alert
      v-if="message !== ''"
      :dismissable="true"
      label="3, 2, 1 Contact!"
      :type="alertType"
  >
    {{ message }}
  </Alert>
</template>
<script setup lang="ts">
import { EnvelopeIcon } from '@heroicons/vue/24/solid';
import axios from 'axios';
import { getCookie } from 'typescript-cookie';
import { ErrorMessage, Field, Form } from 'vee-validate';
import { useReCaptcha } from 'vue-recaptcha-v3';
import { onMounted, onUnmounted, ref } from 'vue';
import { useI18n } from 'vue-i18n';
import * as Yup from 'yup';
import Alert from '../Alert.vue';
import Button from '../Button.vue';
const fields = [
  {
    name: 'name',
    rules: Yup.string().required(),
    type: 'text'
  },
  {
    name: 'email',
    rules: Yup.string().email().required(),
    type: 'email'
  },
  {
    name: 'subject',
    rules: Yup.string().required(),
    type: 'text'
  },
  {
    name: 'message',
    rules: Yup.string().required(),
    type: 'textarea'
  }
];

const alertType = ref('success');
const message = ref('');
const { t } = useI18n();
const xsrfToken = getCookie('XSRF-TOKEN');

const badges = Array.from(document.getElementsByClassName('grecaptcha-badge') as HTMLCollectionOf<HTMLElement>);
onMounted(() => {
  if (badges.length === 1) {
    badges[0].style.visibility = 'visible';
  }
});
onUnmounted(() => {
  if (badges.length === 1) {
    badges[0].style.visibility = '';
  }
});

const recaptchaInstance = useReCaptcha();
const send = async (values: any) => {
  await recaptchaInstance?.recaptchaLoaded();
  values.recaptcha = await recaptchaInstance?.executeRecaptcha('contact');
  const result = await axios.post('/api/mail/', values, { headers: { 'X-XSRF-TOKEN': xsrfToken }});
  alertType.value = result.status >= 400 ? 'danger' : 'success';
  message.value = t('contact.result.' + alertType.value);
};
</script>