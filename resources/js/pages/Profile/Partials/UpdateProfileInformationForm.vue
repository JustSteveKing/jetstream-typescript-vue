<script setup lang="ts">
import {ref} from 'vue';
import {router, useForm} from '@inertiajs/vue3';
import {User} from "@/types";
import {
  Card,
  CardContent,
  CardFooter, CardHeader, CardTitle,
} from '@/components/ui/card'
import {Input} from "@/components/ui/input";
import {Label} from "@/components/ui/label";
import {Button} from "@/components/ui/button";

const props = defineProps<{
  user: User
}>();

const form = useForm({
  _method: 'PUT',
  name: props.user.name,
  email: props.user.email,
  photo: null,
});

const verificationLinkSent = ref(null);
const photoPreview = ref(null);
const photoInput = ref(null);

const updateProfileInformation = () => {
  if (photoInput.value) {
    form.photo = photoInput.value.files[0];
  }

  form.post(route('user-profile-information.update'), {
    errorBag: 'updateProfileInformation',
    preserveScroll: true,
    onSuccess: () => clearPhotoFileInput(),
  });
};

const sendEmailVerification = () => {
  verificationLinkSent.value = true;
};

const selectNewPhoto = () => {
  photoInput.value.click();
};

const updatePhotoPreview = () => {
  const photo = photoInput.value.files[0];

  if (!photo) return;

  const reader = new FileReader();

  reader.onload = (e) => {
    photoPreview.value = e.target.result;
  };

  reader.readAsDataURL(photo);
};

const deletePhoto = () => {
  router.delete(route('current-user-photo.destroy'), {
    preserveScroll: true,
    onSuccess: () => {
      photoPreview.value = null;
      clearPhotoFileInput();
    },
  });
};

const clearPhotoFileInput = () => {
  if (photoInput.value?.value) {
    photoInput.value.value = null;
  }
};
</script>

<template>
  <Card id="details">
    <form @submit.prevent="updateProfileInformation">
      <CardHeader>
        <CardTitle>Update profile information</CardTitle>
      </CardHeader>

      <CardContent>
        <div class="py-6">
          <Label for="name" class="block text-sm font-medium leading-6">
            Name
          </Label>
          <div class="mt-2">
            <Input
              id="name"
              name="name"
              type="text"
              autocomplete="off"
              placeholder="Jon Snow"
              required
              autofocus
              v-model="form.name"
              class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-ring placeholder:text-foreground focus:ring-2 focus:ring-inset focus:ring-ring sm:text-sm sm:leading-6"
            />
            <template v-if="form.errors.name">
              <p class="mt-2 text-md text-destructive">
                {{ form.errors.name }}
              </p>
            </template>
          </div>
        </div>
        <div>
          <Label for="email" class="block text-sm font-medium leading-6">
            Email Address
          </Label>
          <div class="mt-2">
            <Input
              id="email"
              name="email"
              type="email"
              autocomplete="off"
              placeholder="jon.snow@thewall.io"
              required
              autofocus
              v-model="form.email"
              class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-ring placeholder:text-foreground focus:ring-2 focus:ring-inset focus:ring-ring sm:text-sm sm:leading-6"
            />
            <template v-if="form.errors.email">
              <p class="mt-2 text-md text-destructive">
                {{ form.errors.email }}
              </p>
            </template>
          </div>
        </div>
      </CardContent>
      <CardFooter class="border-t px-6 py-4">
        <Button
          type="submit"
          :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
          class="flex w-full justify-center rounded-md bg-ring px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-ring/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
        >Save
        </Button>
      </CardFooter>
    </form>
  </Card>
</template>
