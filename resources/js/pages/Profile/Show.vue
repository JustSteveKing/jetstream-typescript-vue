<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import DeleteUserForm from '@/pages/Profile/Partials/DeleteUserForm.vue';
import LogoutOtherBrowserSessionsForm from '@/pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import SectionBorder from '@/components/SectionBorder.vue';
import TwoFactorAuthenticationForm from '@/pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from '@/pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/pages/Profile/Partials/UpdateProfileInformationForm.vue';

defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
});
</script>

<template>
  <AppLayout title="Profile">
    <div class="px-6 py-6">
      <UpdateProfileInformationForm :user="$page.props.auth.user"/>

      <SectionBorder/>
    </div>
    <div>
      <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <UpdatePasswordForm class="mt-10 sm:mt-0"/>

        <SectionBorder/>

        <TwoFactorAuthenticationForm
          :requires-confirmation="confirmsTwoFactorAuthentication"
          class="mt-10 sm:mt-0"
        />

        <SectionBorder/>

        <LogoutOtherBrowserSessionsForm :sessions="sessions" class="mt-10 sm:mt-0"/>

        <SectionBorder/>

        <DeleteUserForm class="mt-10 sm:mt-0"/>
      </div>
    </div>
  </AppLayout>
</template>
