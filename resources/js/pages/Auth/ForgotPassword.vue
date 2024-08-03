<script setup lang="ts">
import {Link, useForm} from '@inertiajs/vue3';
import {GuestLayout} from "@/layouts";
import {Label} from "@/components/ui/label";
import {Input} from "@/components/ui/input";
import {Button, buttonVariants} from "@/components/ui/button";
import {cn} from "@/lib/utils";

const props = defineProps<{
  status?: string
}>();

const form = useForm({
  email: '',
});

const submit = () => {
  form.post(route('password.email'));
};
</script>

<template>
  <GuestLayout title="Forgot Password">
    <template #link>
      <Link
        :href="route('login')"
        :class="cn(buttonVariants({ variant: 'ghost' }),'absolute right-4 top-4 md:right-8 md:top-8',)"
      >
        Login
      </Link>
    </template>
    <template #default>
      <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
        <div class="flex flex-col space-y-2 text-center">
          <h1 class="text-2xl font-semibold tracking-tight">
            Forgot your password?
          </h1>
          <p class="text-sm text-muted-foreground">
            Forgot your password? No problem. Just let us know your email address and we will email you a password reset
            link that will allow you to choose a new one.
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
              <Button
                type="submit"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                class="flex w-full justify-center rounded-md bg-ring px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-ring/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
              >Email Password Reset Link
              </Button>
            </div>
          </form>
        </div>
      </div>
    </template>
  </GuestLayout>
<!--  <GuestLayout title="Forgot Password">-->
<!--    <template #action>-->
<!--      <p class="mb-4 text-sm text-foreground">-->
<!--        Forgot your password? No problem. Just let us know your email address and we will email you a password reset-->
<!--        link that will allow you to choose a new one.-->
<!--      </p>-->
<!--    </template>-->
<!--    <template #default>-->
<!--      <div v-if="props.status" class="mb-4 font-medium text-sm text-destructive">-->
<!--        {{ props.status }}-->
<!--      </div>-->
<!--      <div class="mt-10">-->
<!--        <form @submit.prevent="submit" class="space-y-6">-->
<!--          <div>-->
<!--            <Label for="email" class="block text-sm font-medium leading-6">-->
<!--              Email Address-->
<!--            </Label>-->
<!--            <div class="mt-2">-->
<!--              <Input-->
<!--                id="email"-->
<!--                name="email"-->
<!--                type="email"-->
<!--                autocomplete="off"-->
<!--                placeholder="jon.snow@thewall.io"-->
<!--                required-->
<!--                autofocus-->
<!--                v-model="form.email"-->
<!--                class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-ring placeholder:text-foreground focus:ring-2 focus:ring-inset focus:ring-ring sm:text-sm sm:leading-6"-->
<!--              />-->
<!--              <template v-if="form.errors.email">-->
<!--                <p class="mt-2 text-md text-destructive">-->
<!--                  {{ form.errors.email }}-->
<!--                </p>-->
<!--              </template>-->
<!--            </div>-->
<!--          </div>-->

<!--          <div>-->
<!--            <Button-->
<!--              type="submit"-->
<!--              :class="{ 'opacity-25': form.processing }" :disabled="form.processing"-->
<!--              class="flex w-full justify-center rounded-md bg-ring px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-ring/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"-->
<!--            >Email Password Reset Link-->
<!--            </Button>-->
<!--          </div>-->
<!--        </form>-->
<!--      </div>-->
<!--    </template>-->
<!--  </GuestLayout>-->
</template>
