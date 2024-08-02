<script setup lang="ts">
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import {
  Card,
  CardContent,
  CardFooter,
} from '@/components/ui/card'
import {Input} from "@/components/ui/input";
import {Label} from "@/components/ui/label";
import {Button} from "@/components/ui/button";
import {Checkbox} from "@/components/ui/checkbox";
import ActionMessage from "@/components/ActionMessage.vue";
import DialogModal from "@/components/DialogModal.vue";
import ConfirmationModal from "@/components/ConfirmationModal.vue";

const props = defineProps<{
  tokens: string[];
  availablePermissions: string[];
  defaultPermissions: string[];
}>();

const createApiTokenForm = useForm({
    name: '',
    permissions: props.defaultPermissions,
});

const updateApiTokenForm = useForm({
    permissions: [],
});

const deleteApiTokenForm = useForm({});

const displayingToken = ref(false);
const managingPermissionsFor = ref(null);
const apiTokenBeingDeleted = ref(null);

const createApiToken = async () => {
    createApiTokenForm.post(route('api-tokens.store'), {
        preserveScroll: true,
        onSuccess: () => {
            displayingToken.value = true;
            createApiTokenForm.reset();
        },
    });
};

const manageApiTokenPermissions = (token) => {
    updateApiTokenForm.permissions = token.abilities;
    managingPermissionsFor.value = token;
};

const updateApiToken = async () => {
    updateApiTokenForm.put(route('api-tokens.update', managingPermissionsFor.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (managingPermissionsFor.value = null),
    });
};

const confirmApiTokenDeletion = (token) => {
    apiTokenBeingDeleted.value = token;
};

const deleteApiToken = async () => {
    deleteApiTokenForm.delete(route('api-tokens.destroy', apiTokenBeingDeleted.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (apiTokenBeingDeleted.value = null),
    });
};
</script>

<template>
  <section class="md:grid md:grid-cols-3 md:gap-6 flex items-center space-y-12">
    <div class="md:col-span-1 flex justify-between">
      <div class="px-4 sm:px-0">
        <h3 class="text-lg font-medium">
          Create API Token
        </h3>

        <p class="mt-1 text-sm">
          API tokens allow third-party services to authenticate with our application on your behalf.
        </p>
      </div>
    </div>
    <Card class="mt-5 md:mt-0 md:col-span-2">
      <form @submit.prevent="createApiToken">
        <CardContent>
          <div class="py-6">
            <Label for="name" class="block text-sm font-medium leading-6">
              API Token Name
            </Label>
            <div class="mt-2">
              <Input
                id="name"
                name="name"
                type="text"
                autocomplete="off"
                placeholder="Token Name"
                required
                v-model="createApiTokenForm.name"
                class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-ring placeholder:text-foreground focus:ring-2 focus:ring-inset focus:ring-ring sm:text-sm sm:leading-6"
              />
              <template v-if="createApiTokenForm.errors.name">
                <p class="mt-2 text-md text-destructive">
                  {{ createApiTokenForm.errors.name }}
                </p>
              </template>
            </div>
          </div>
          <div v-if="availablePermissions.length > 0" class="col-span-6">
            <Label for="permissions" class="block text-sm font-medium leading-6">
              Permissions
            </Label>

            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
              <div v-for="permission in props.availablePermissions" :key="permission" class="items-top flex space-x-2">
                <Checkbox
                  :id="permission"
                  :value="permission"
                />
                <label
                  :for="permission"
                  class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                >
                  {{ permission }}
                </label>
              </div>
            </div>
          </div>
        </CardContent>
        <CardFooter>
          <ActionMessage :on="createApiTokenForm.recentlySuccessful" class="me-3">
              Created.
          </ActionMessage>
          <Button
            type="submit"
            :class="{ 'opacity-25': createApiTokenForm.processing }" :disabled="createApiTokenForm.processing"
            class="flex w-full justify-center rounded-md bg-ring px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-ring/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
          >Create
          </Button>
        </CardFooter>
      </form>
    </Card>

    <template v-if="tokens.length > 0">
      <div class="md:col-span-1 flex justify-between">
        <div class="px-4 sm:px-0">
          <h3 class="text-lg font-medium">
            Manage API Tokens
          </h3>

          <p class="mt-1 text-sm">
            You may delete any of your existing tokens if they are no longer needed.
          </p>
        </div>
      </div>
      <Card class="mt-5 md:mt-0 md:col-span-2">
        <CardContent v-for="token in tokens" :key="token.id" class="py-6">
          <div class="flex items-center justify-between">
            <div class="break-all dark:text-white">
              {{ token.name }}
            </div>

            <div class="flex items-center ms-2">
              <div v-if="token.last_used_ago" class="text-sm text-gray-400">
                Last used {{ token.last_used_ago }}
              </div>

              <button
                v-if="availablePermissions.length > 0"
                class="cursor-pointer ms-6 text-sm text-gray-400 underline"
                @click="manageApiTokenPermissions(token)"
              >
                Permissions
              </button>

              <button class="cursor-pointer ms-6 text-sm text-red-500" @click="confirmApiTokenDeletion(token)">
                Delete
              </button>
            </div>
          </div>
        </CardContent>
      </Card>
    </template>
    <DialogModal :show="displayingToken" @close="displayingToken = false">
        <template #title>
            API Token
        </template>

        <template #content>
            <div>
                Please copy your new API token. For your security, it won't be shown again.
            </div>

            <div v-if="$page.props.jetstream.flash.token" class="mt-4 bg-gray-100 dark:bg-gray-900 px-4 py-2 rounded font-mono text-sm text-gray-500 break-all">
                {{ $page.props.jetstream.flash.token }}
            </div>
        </template>

        <template #footer>
            <Button variant="secondary" @click="displayingToken = false">
                Close
            </Button>
        </template>
    </DialogModal>

    <DialogModal :show="managingPermissionsFor != null" @close="managingPermissionsFor = null">
        <template #title>
            API Token Permissions
        </template>

        <template #content>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div v-for="permission in availablePermissions" :key="permission">
                    <label class="flex items-center">
                        <Checkbox v-model:checked="updateApiTokenForm.permissions" :value="permission" />
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ permission }}</span>
                    </label>
                </div>
            </div>
        </template>

        <template #footer>
            <Button variant="secondary" @click="managingPermissionsFor = null">
                Cancel
            </Button>

            <Button
                variant="outline"
                class="ms-3"
                :class="{ 'opacity-25': updateApiTokenForm.processing }"
                :disabled="updateApiTokenForm.processing"
                @click="updateApiToken"
            >
                Save
            </Button>
        </template>
    </DialogModal>
    <ConfirmationModal :show="apiTokenBeingDeleted != null" @close="apiTokenBeingDeleted = null">
        <template #title>
            Delete API Token
        </template>

        <template #content>
            Are you sure you would like to delete this API token?
        </template>

        <template #footer>
            <SecondaryButton @click="apiTokenBeingDeleted = null">
                Cancel
            </SecondaryButton>

            <DangerButton
                class="ms-3"
                :class="{ 'opacity-25': deleteApiTokenForm.processing }"
                :disabled="deleteApiTokenForm.processing"
                @click="deleteApiToken"
            >
                Delete
            </DangerButton>
        </template>
    </ConfirmationModal>
  </section>
</template>
