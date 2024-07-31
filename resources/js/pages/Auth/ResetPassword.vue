<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { GuestLayout } from "@/layouts";
import {Label} from "@/components/ui/label";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
  <GuestLayout title="Reset your password">
    <template #default>
      <div class="mt-10">
        <form @submit.prevent="submit" class="space-y-6">
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

          <div>
            <Button
              type="submit"
              :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
              class="flex w-full justify-center rounded-md bg-ring px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-ring/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
            >
              Reset Password
            </Button>
          </div>
        </form>
      </div>
    </template>
  </GuestLayout>
<!--    <Head title="Reset Password" />-->

<!--    <AuthenticationCard>-->
<!--        <template #logo>-->
<!--            <AuthenticationCardLogo />-->
<!--        </template>-->

<!--        <form @submit.prevent="submit">-->
<!--            <div>-->
<!--                <InputLabel for="email" value="Email" />-->
<!--                <TextInput-->
<!--                    id="email"-->
<!--                    v-model="form.email"-->
<!--                    type="email"-->
<!--                    class="mt-1 block w-full"-->
<!--                    required-->
<!--                    autofocus-->
<!--                    autocomplete="username"-->
<!--                />-->
<!--                <InputError class="mt-2" :message="form.errors.email" />-->
<!--            </div>-->

<!--            <div class="mt-4">-->
<!--                <InputLabel for="password" value="Password" />-->
<!--                <TextInput-->
<!--                    id="password"-->
<!--                    v-model="form.password"-->
<!--                    type="password"-->
<!--                    class="mt-1 block w-full"-->
<!--                    required-->
<!--                    autocomplete="new-password"-->
<!--                />-->
<!--                <InputError class="mt-2" :message="form.errors.password" />-->
<!--            </div>-->

<!--            <div class="mt-4">-->
<!--                <InputLabel for="password_confirmation" value="Confirm Password" />-->
<!--                <TextInput-->
<!--                    id="password_confirmation"-->
<!--                    v-model="form.password_confirmation"-->
<!--                    type="password"-->
<!--                    class="mt-1 block w-full"-->
<!--                    required-->
<!--                    autocomplete="new-password"-->
<!--                />-->
<!--                <InputError class="mt-2" :message="form.errors.password_confirmation" />-->
<!--            </div>-->

<!--            <div class="flex items-center justify-end mt-4">-->
<!--                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">-->
<!--                    Reset Password-->
<!--                </PrimaryButton>-->
<!--            </div>-->
<!--        </form>-->
<!--    </AuthenticationCard>-->
</template>
