<script setup lang="ts">
import {ref} from 'vue';
import {useForm} from '@inertiajs/vue3';
import ActionSection from '@/components/ActionSection.vue';
import DangerButton from '@/components/DangerButton.vue';
import DialogModal from '@/components/DialogModal.vue';
import InputError from '@/components/InputError.vue';
import SecondaryButton from '@/components/SecondaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
  password: '',
});

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true;

  setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
  form.delete(route('current-user.destroy'), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUserDeletion.value = false;

  form.reset();
};
</script>

<template>
  <Card id="remove">
    <CardHeader>
      <CardTitle>Delete Account</CardTitle>
      <CardDescription>
        Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your
        account, please download any data or information that you wish to retain.
      </CardDescription>
    </CardHeader>
    <CardFooter class="border-t px-6 py-4">
      <div class="mt-5">
        <DangerButton @click="confirmUserDeletion">
          Delete Account
        </DangerButton>
      </div>
    </CardFooter>
    <DialogModal max-width="2xl" :closeable="true" :show="confirmingUserDeletion" @close="closeModal">
      <template #title>
        Delete Account
      </template>

      <template #content>
        Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will
        be permanently deleted. Please enter your password to confirm you would like to permanently delete your
        account.

        <div class="mt-4">
          <Input
            typeof="password"
            ref="passwordInput"
            v-model="form.password"
            type="password"
            class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-ring placeholder:text-foreground focus:ring-2 focus:ring-inset focus:ring-ring sm:text-sm sm:leading-6"
            placeholder="Password"
            autocomplete="current-password"
            @keyup.enter="deleteUser"
          />
          <template v-if="form.errors.password">
            <p class="mt-2 text-md text-destructive">
              {{ form.errors.password }}
            </p>
          </template>
        </div>
      </template>

      <template #footer>
        <Button variant="secondary" @click="closeModal">
          Cancel
        </Button>

        <Button
          variant="destructive"
          class="ms-3"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          @click="deleteUser"
        >
          Delete Account
        </Button>
      </template>
    </DialogModal>
  </Card>
</template>
