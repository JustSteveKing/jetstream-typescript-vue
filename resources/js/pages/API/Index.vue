<script setup lang="ts">
import ApiTokenManager from '@/pages/API/Partials/ApiTokenManager.vue';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps<{
  tokens: string[];
  availablePermissions: string[];
  defaultPermissions: string[];
}>();
</script>

<template>
    <AppLayout title="API Tokens">
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <ApiTokenManager
          :tokens="tokens"
          :available-permissions="availablePermissions"
          :default-permissions="defaultPermissions"
        />
      </div>
    </AppLayout>
</template>
