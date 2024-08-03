<script setup lang="ts">
import { cn } from '@/lib/utils'
import {Link, useForm} from '@inertiajs/vue3';
import {GuestLayout} from "@/layouts";
import { buttonVariants } from '@/components/ui/button'
import {Label} from '@/components/ui/label'
import {Input} from '@/components/ui/input'
import {Checkbox} from '@/components/ui/checkbox'
import {Button} from '@/components/ui/button'

const props = defineProps<{
  status: string
}>();

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.transform(data => ({
    ...data,
    remember: form.remember ? 'on' : '',
  })).post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <GuestLayout title="Sign into your account">
    <template #link>
      <Link
        :href="route('register')"
        :class="cn(buttonVariants({ variant: 'ghost' }),'absolute right-4 top-4 md:right-8 md:top-8',)"
      >
        Register
      </Link>
    </template>
    <template #default>
      <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
        <div class="flex flex-col space-y-2 text-center">
          <h1 class="text-2xl font-semibold tracking-tight">
            Sign into your account
          </h1>
          <p class="text-sm text-muted-foreground">
            Sign in or register for a new account.
          </p>
        </div>

        <div :class="cn('grid gap-6', $attrs.class ?? '')">
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
              <Label for="password" class="block text-sm font-medium leading-6">
                Password
              </Label>
              <div class="mt-2">
                <Input
                  id="password"
                  name="password"
                  type="password"
                  autocomplete="off"
                  placeholder="super-secret-password"
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

            <div class="flex items-center justify-between">
              <div class="flex items-center">
                <Label for="remember-me" class="mr-3 block text-sm leading-6 text-foreground">
                  Remember me
                </Label>
                <Checkbox
                  id="remember-me"
                  name="remember-me"
                  v-model="form.remember"
                  class="h-4 w-4 rounded text-ring focus:ring-ring"
                />
              </div>

              <div class="text-sm leading-6">
                <Link :href="route('password.request')" class="font-semibold text-ring hover:text-ring/50">
                  Forgot password?
                </Link>
              </div>
            </div>

            <div>
              <Button
                type="submit"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                class="flex w-full justify-center rounded-md bg-ring px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-ring/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
              >Sign In
              </Button>
            </div>
          </form>
        </div>

        <p class="px-8 text-center text-sm text-muted-foreground">
          By clicking continue, you agree to our
          <Link
            :href="route('pages:terms')"
            class="underline underline-offset-4 hover:text-primary"
          >
            Terms of Service
          </Link>
          and
          <Link
            :href="route('pages:privacy')"
            class="underline underline-offset-4 hover:text-primary"
          >
            Privacy Policy
          </Link>
          .
        </p>
      </div>
    </template>
  </GuestLayout>
</template>
