<script setup lang="ts">
import { Head } from "@inertiajs/vue3";

const props = defineProps<{
  title: string
}>();
</script>

<template>
  <div class="h-full">
    <Head :title="title" />

    <main id="content" class="h-full">
      <slot />
    </main>
  </div>
</template>
