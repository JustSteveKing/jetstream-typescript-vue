<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import {
  Card,
  CardContent,
  CardFooter, CardHeader, CardTitle,
} from '@/components/ui/card'
import {Input} from "@/components/ui/input";
import {Label} from "@/components/ui/label";
import {Button} from "@/components/ui/button";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }

            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
  <Card id="password">
    <CardHeader>
      <CardTitle>Change your password</CardTitle>
    </CardHeader>
    <form @submit.prevent="updatePassword">
      <CardContent>
        <div class="py-6">
          <Label for="current_password" class="block text-sm font-medium leading-6">
            Current Password
          </Label>
          <div class="mt-2">
            <Input
              id="current_password"
              name="current_password"
              type="password"
              autocomplete="off"
              placeholder="Current Password"
              required
              v-model="form.current_password"
              class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-ring placeholder:text-foreground focus:ring-2 focus:ring-inset focus:ring-ring sm:text-sm sm:leading-6"
            />
            <template v-if="form.errors.current_password">
              <p class="mt-2 text-md text-destructive">
                {{ form.errors.current_password }}
              </p>
            </template>
          </div>
        </div>
        <div class="py-6">
          <Label for="password" class="block text-sm font-medium leading-6">
            New Password
          </Label>
          <div class="mt-2">
            <Input
              id="password"
              name="password"
              type="password"
              autocomplete="off"
              placeholder="New Password"
              required
              v-model="form.password"
              class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-ring placeholder:text-foreground focus:ring-2 focus:ring-inset focus:ring-ring sm:text-sm sm:leading-6"
            />
            <template v-if="form.errors.password">
              <p class="mt-2 text-md text-destructive">
                {{ form.errors.password }}
              </p>
            </template>
          </div>
        </div>
        <div class="py-6">
          <Label for="password_confirmation" class="block text-sm font-medium leading-6">
            Confirm Password
          </Label>
          <div class="mt-2">
            <Input
              id="password_confirmation"
              name="password_confirmation"
              type="password"
              autocomplete="off"
              placeholder="Confirm Password"
              required
              v-model="form.password_confirmation"
              class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-ring placeholder:text-foreground focus:ring-2 focus:ring-inset focus:ring-ring sm:text-sm sm:leading-6"
            />
            <template v-if="form.errors.password_confirmation">
              <p class="mt-2 text-md text-destructive">
                {{ form.errors.password_confirmation }}
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
