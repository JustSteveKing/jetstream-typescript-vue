<script setup lang="ts">
import Modal from './Modal.vue';

const emit = defineEmits(['close']);

const props = defineProps<{
  show: boolean | false,
  maxWidth: string | '2xl',
  closeable: boolean | true,
}>();

const close = async () => emit('close');
</script>

<template>
  <Modal
    :show="show"
    :max-width="maxWidth"
    :closeable="closeable"
    @close="close"
  >
    <div class="px-6 py-4">
      <div class="text-lg font-medium">
        <slot name="title"/>
      </div>

      <div class="mt-4 text-sm">
        <slot name="content"/>
      </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 dark:bg-gray-800 text-end">
      <slot name="footer"/>
    </div>
  </Modal>
</template>
