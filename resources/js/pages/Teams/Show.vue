<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import DeleteTeamForm from '@/pages/Teams/Partials/DeleteTeamForm.vue';
import SectionBorder from '@/components/SectionBorder.vue';
import TeamMemberManager from '@/pages/Teams/Partials/TeamMemberManager.vue';
import UpdateTeamNameForm from '@/pages/Teams/Partials/UpdateTeamNameForm.vue';
import {Team} from "@/types";
import UpdateProfileInformationForm from "@/pages/Profile/Partials/UpdateProfileInformationForm.vue";
import UpdatePasswordForm from "@/pages/Profile/Partials/UpdatePasswordForm.vue";
import LogoutOtherBrowserSessionsForm from "@/pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue";
import DeleteUserForm from "@/pages/Profile/Partials/DeleteUserForm.vue";
import TwoFactorAuthenticationForm from "@/pages/Profile/Partials/TwoFactorAuthenticationForm.vue";

const props = defineProps<{
  team: Team,
  availableRoles: string[],
  permissions: Object
}>();
</script>

<template>
  <AppLayout title="Team Settings">
    <main class="flex min-h-[calc(100vh_-_theme(spacing.16))] flex-1 flex-col gap-4 bg-muted/40 p-4 md:gap-8 md:p-10">
      <div class="mx-auto grid w-full max-w-6xl gap-2">
        <h1 class="text-3xl font-semibold">
          Team Settings
        </h1>
      </div>
      <div class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[250px_1fr]">
        <nav class="grid gap-4 text-sm text-muted-foreground">
          <a href="#details" class="font-semibold text-primary">
            Team Details
          </a>
          <a href="#members">
            Manage Members
          </a>
          <template v-if="permissions.canDeleteTeam && ! props.team.personal_team">
            <a href="#remove">
              Delete Team
            </a>
          </template>
        </nav>
        <div class="grid gap-6">
          <UpdateTeamNameForm :team="team" :permissions="permissions"/>
          <TeamMemberManager
            :team="team"
            :available-roles="availableRoles"
            :user-permissions="permissions"
          />
        </div>
      </div>
    </main>
  </AppLayout>
<!--  <AppLayout title="Team Settings">-->
<!--    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">-->
<!--      <UpdateTeamNameForm :team="team" :permissions="permissions"/>-->

<!--      <TeamMemberManager-->
<!--        class="mt-10 sm:mt-0"-->
<!--        :team="team"-->
<!--        :available-roles="availableRoles"-->
<!--        :user-permissions="permissions"-->
<!--      />-->

<!--      <template v-if="permissions.canDeleteTeam && ! props.team.personal_team">-->
<!--        <SectionBorder/>-->

<!--        <DeleteTeamForm class="mt-10 sm:mt-0" :team="props.team"/>-->
<!--      </template>-->
<!--    </div>-->
<!--  </AppLayout>-->
</template>
