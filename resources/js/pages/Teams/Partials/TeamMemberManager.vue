<script setup lang="ts">
import {ref} from 'vue';
import {router, useForm, usePage} from '@inertiajs/vue3';
import ActionMessage from '@/components/ActionMessage.vue';
import ActionSection from '@/components/ActionSection.vue';
import ConfirmationModal from '@/components/ConfirmationModal.vue';
import DangerButton from '@/components/DangerButton.vue';
import DialogModal from '@/components/DialogModal.vue';
import FormSection from '@/components/FormSection.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import SecondaryButton from '@/components/SecondaryButton.vue';
import SectionBorder from '@/components/SectionBorder.vue';
import TextInput from '@/components/TextInput.vue';
import {Team} from "@/types";
import Modal from "@/components/Modal.vue";
import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Button} from "@/components/ui/button";
import {Label} from "@/components/ui/label";
import {Input} from "@/components/ui/input";

const props = defineProps<{
  team: Team,
  availableRoles: string[],
  userPermissions: Object,
}>();

const page = usePage();

const addTeamMemberForm = useForm({
  email: '',
  role: null,
});

const updateRoleForm = useForm({
  role: null,
});

const leaveTeamForm = useForm({});
const removeTeamMemberForm = useForm({});

const currentlyManagingRole = ref(false);
const managingRoleFor = ref(null);
const confirmingLeavingTeam = ref(false);
const teamMemberBeingRemoved = ref(null);

const addTeamMember = () => {
  addTeamMemberForm.post(route('team-members.store', props.team), {
    errorBag: 'addTeamMember',
    preserveScroll: true,
    onSuccess: () => addTeamMemberForm.reset(),
  });
};

const cancelTeamInvitation = (invitation) => {
  router.delete(route('team-invitations.destroy', invitation), {
    preserveScroll: true,
  });
};

const manageRole = (teamMember) => {
  managingRoleFor.value = teamMember;
  updateRoleForm.role = teamMember.membership.role;
  currentlyManagingRole.value = true;
};

const updateRole = () => {
  updateRoleForm.put(route('team-members.update', [props.team, managingRoleFor.value]), {
    preserveScroll: true,
    onSuccess: () => currentlyManagingRole.value = false,
  });
};

const confirmLeavingTeam = () => {
  confirmingLeavingTeam.value = true;
};

const leaveTeam = () => {
  leaveTeamForm.delete(route('team-members.destroy', [props.team, page.props.auth.user]));
};

const confirmTeamMemberRemoval = (teamMember) => {
  teamMemberBeingRemoved.value = teamMember;
};

const removeTeamMember = () => {
  removeTeamMemberForm.delete(route('team-members.destroy', [props.team, teamMemberBeingRemoved.value]), {
    errorBag: 'removeTeamMember',
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => teamMemberBeingRemoved.value = null,
  });
};

const displayableRole = (role) => {
  return props.availableRoles.find(r => r.key === role).name;
};
</script>

<template>
  <div>
    <Card v-if="userPermissions.canAddTeamMembers">
      <CardHeader>
        <CardTitle>Add Team Member</CardTitle>
        <CardDescription>Add a new team member to your team, allowing them to collaborate with you.</CardDescription>
      </CardHeader>
      <form @submit.prevent="addTeamMember">
        <CardContent>
          <div class="col-span-6 sm:col-span-4 py-6">
            <Label for="email" class="block text-sm font-medium leading-6">
              Email
            </Label>
            <Input
              id="email"
              name="email"
              type="email"
              autocomplete="off"
              placeholder="Email Address"
              required
              autofocus
              v-model="addTeamMemberForm.email"
              class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-ring placeholder:text-foreground focus:ring-2 focus:ring-inset focus:ring-ring sm:text-sm sm:leading-6"
            />
            <p class="mt-2 text-md text-muted-foreground">
              Please provide the email address of the person you would like to add to this team.
            </p>
            <template v-if="addTeamMemberForm.errors.email">
              <p class="mt-2 text-md text-destructive">
                {{ addTeamMemberForm.errors.email }}
              </p>
            </template>
          </div>

          <div v-if="availableRoles.length > 0" class="col-span-6 lg:col-span-4">
            <InputLabel for="roles" value="Role"/>
            <InputError :message="addTeamMemberForm.errors.role" class="mt-2"/>

            <div class="relative z-0 mt-1 border border-ring rounded-lg cursor-pointer">
              <button
                v-for="(role, i) in availableRoles"
                :key="role.key"
                type="button"
                class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-ring focus:ring-2 focus:ring-ring"
                :class="{'border-t border-ring focus:border-none rounded-t-none': i > 0, 'rounded-b-none': i != Object.keys(availableRoles).length - 1}"
                @click="addTeamMemberForm.role = role.key"
              >
                <div :class="{'opacity-50': addTeamMemberForm.role && addTeamMemberForm.role != role.key}">
                  <div class="flex items-center">
                    <div class="text-sm" :class="{'font-semibold': addTeamMemberForm.role == role.key}">
                      {{ role.name }}
                    </div>

                    <svg v-if="addTeamMemberForm.role == role.key" class="ms-2 h-5 w-5 text-green-400"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </div>
                  <div class="mt-2 text-xs text-start">
                    {{ role.description }}
                  </div>
                </div>
              </button>
            </div>
          </div>
        </CardContent>
        <CardFooter class="border-t px-6 py-4">
          <ActionMessage :on="addTeamMemberForm.recentlySuccessful" class="me-3">
            Saved.
          </ActionMessage>

          <Button
            type="submit"
            :class="{ 'opacity-25': addTeamMemberForm.processing }" :disabled="addTeamMemberForm.processing"
            class="flex w-full justify-center rounded-md bg-ring px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-ring/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
          >
            Save
          </Button>
        </CardFooter>
      </form>
    </Card>

    <div v-if="team.team_invitations.length > 0 && userPermissions.canAddTeamMembers">
      <Card>
        <CardHeader>
          <CardTitle>Pending Team Invitations</CardTitle>
          <CardDescription>These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.</CardDescription>
        </CardHeader>
        <CardContent>
          <div class="space-y-6">
            <div v-for="invitation in team.team_invitations" :key="invitation.id"
                 class="flex items-center justify-between">
              <div class="text-gray-600 dark:text-gray-400">
                {{ invitation.email }}
              </div>

              <div class="flex items-center">
                <!-- Cancel Team Invitation -->
                <button
                  v-if="userPermissions.canRemoveTeamMembers"
                  class="cursor-pointer ms-6 text-sm text-red-500 focus:outline-none"
                  @click="cancelTeamInvitation(invitation)"
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>

    <div v-if="team.users.length > 0">
      <Card>
        <CardHeader>
          <CardTitle>Team Members</CardTitle>
          <CardDescription>All of the people that are part of this team.</CardDescription>
        </CardHeader>
        <CardContent>
          <div class="space-y-6">
            <div v-for="user in team.users" :key="user.id" class="flex items-center justify-between">
              <div class="flex items-center">
                <img class="w-8 h-8 rounded-full object-cover" :src="user.profile_photo_url" :alt="user.name">
                <div class="ms-4">
                  {{ user.name }}
                </div>
              </div>

              <div class="flex items-center">
                <Button
                  variant="ghost"
                  v-if="userPermissions.canUpdateTeamMembers && availableRoles.length"
                  @click="manageRole(user)"
                >
                  {{ displayableRole(user.membership.role) }}
                </Button>

                <div v-else-if="availableRoles.length" class="ms-2 text-sm">
                  {{ displayableRole(user.membership.role) }}
                </div>

                <Button
                  variant="destructive"
                  v-if="$page.props.auth.user.id === user.id"
                  @click="confirmLeavingTeam"
                >
                  Leave
                </Button>

                <Button
                  variant="outline"
                  v-else-if="userPermissions.canRemoveTeamMembers"
                  @click="confirmTeamMemberRemoval(user)"
                >
                  Remove
                </Button>
              </div>
            </div>
          </div>
        </CardContent>
      </Card>
    </div>

    <DialogModal max-width="2xl" :closeable="true" :show="currentlyManagingRole" @close="currentlyManagingRole = false">
      <template #title>
        Manage Role
      </template>

      <template #content>
        <div v-if="managingRoleFor">
          <div class="relative z-0 mt-1 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer">
            <button
              v-for="(role, i) in availableRoles"
              :key="role.key"
              type="button"
              class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-600"
              :class="{'border-t border-gray-200 dark:border-gray-700 focus:border-none rounded-t-none': i > 0, 'rounded-b-none': i !== Object.keys(availableRoles).length - 1}"
              @click="updateRoleForm.role = role.key"
            >
              <div :class="{'opacity-50': updateRoleForm.role && updateRoleForm.role !== role.key}">
                <!-- Role Name -->
                <div class="flex items-center">
                  <div class="text-sm text-gray-600 dark:text-gray-400"
                       :class="{'font-semibold': updateRoleForm.role === role.key}">
                    {{ role.name }}
                  </div>

                  <svg v-if="updateRoleForm.role == role.key" class="ms-2 h-5 w-5 text-green-400"
                       xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                       stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                  </svg>
                </div>

                <!-- Role Description -->
                <div class="mt-2 text-xs text-gray-600 dark:text-gray-400">
                  {{ role.description }}
                </div>
              </div>
            </button>
          </div>
        </div>
      </template>

      <template #footer>
        <SecondaryButton @click="currentlyManagingRole = false">
          Cancel
        </SecondaryButton>

        <PrimaryButton
          class="ms-3"
          :class="{ 'opacity-25': updateRoleForm.processing }"
          :disabled="updateRoleForm.processing"
          @click="updateRole"
        >
          Save
        </PrimaryButton>
      </template>
    </DialogModal>

    <ConfirmationModal max-width="2xl" :closeable="true" :show="confirmingLeavingTeam"
                       @close="confirmingLeavingTeam = false">
      <template #title>
        Leave Team
      </template>

      <template #content>
        Are you sure you would like to leave this team?
      </template>

      <template #footer>
        <SecondaryButton @click="confirmingLeavingTeam = false">
          Cancel
        </SecondaryButton>

        <DangerButton
          class="ms-3"
          :class="{ 'opacity-25': leaveTeamForm.processing }"
          :disabled="leaveTeamForm.processing"
          @click="leaveTeam"
        >
          Leave
        </DangerButton>
      </template>
    </ConfirmationModal>

    <ConfirmationModal max-width="2xl" :closeable="true" :show="teamMemberBeingRemoved" @close="teamMemberBeingRemoved = null">
      <template #title>
        Remove Team Member
      </template>

      <template #content>
        Are you sure you would like to remove this person from the team?
      </template>

      <template #footer>
        <SecondaryButton @click="teamMemberBeingRemoved = null">
          Cancel
        </SecondaryButton>

        <DangerButton
          class="ms-3"
          :class="{ 'opacity-25': removeTeamMemberForm.processing }"
          :disabled="removeTeamMemberForm.processing"
          @click="removeTeamMember"
        >
          Remove
        </DangerButton>
      </template>
    </ConfirmationModal>
  </div>
</template>
