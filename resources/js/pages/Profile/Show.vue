<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

import { Button } from '@/components/ui/button'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card'
import { Checkbox } from '@/components/ui/checkbox'
import { Input } from '@/components/ui/input'
import DeleteUserForm from '@/pages/Profile/Partials/DeleteUserForm.vue';
import LogoutOtherBrowserSessionsForm from '@/pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import TwoFactorAuthenticationForm from '@/pages/Profile/Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from '@/pages/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/pages/Profile/Partials/UpdateProfileInformationForm.vue';

defineProps({
  confirmsTwoFactorAuthentication: Boolean,
  sessions: Array,
});
</script>

<template>
  <AppLayout title="Profile Settings">
    <main class="flex min-h-[calc(100vh_-_theme(spacing.16))] flex-1 flex-col gap-4 bg-muted/40 p-4 md:gap-8 md:p-10">
      <div class="mx-auto grid w-full max-w-6xl gap-2">
        <h1 class="text-3xl font-semibold">
          Profile Settings
        </h1>
      </div>
      <div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[250px_1fr]">
        <nav class="grid gap-4 text-sm text-muted-foreground">
          <a href="#details" class="font-semibold text-primary">
            Personal Details
          </a>
          <a href="#password">
            User Password
          </a>
          <a href="#mfa">
            MFA Setup
          </a>
          <a href="#sessions">
            Active sessions
          </a>
          <a href="#remove">
            Remove Account
          </a>
        </nav>
        <div class="grid gap-6">
          <UpdateProfileInformationForm :user="$page.props.auth.user" />
          <UpdatePasswordForm />
          <TwoFactorAuthenticationForm
            :requires-confirmation="confirmsTwoFactorAuthentication"
          />
          <LogoutOtherBrowserSessionsForm :sessions="sessions" />
          <DeleteUserForm />
        </div>
      </div>
    </main>
  </AppLayout>
</template>
