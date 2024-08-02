<script setup lang="ts">
import {useForm} from '@inertiajs/vue3';
import ActionMessage from '@/components/ActionMessage.vue';
import FormSection from '@/components/FormSection.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import {Team} from "@/types";
import {Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle} from "@/components/ui/card";
import {Label} from "@/components/ui/label";
import {Input} from "@/components/ui/input";
import {Button} from "@/components/ui/button";

const props = defineProps<{
  team: Team,
  permissions: Object
}>();

const form = useForm({
  name: props.team.name,
});

const updateTeamName = async () => {
  form.put(route('teams.update', props.team), {
    errorBag: 'updateTeamName',
    preserveScroll: true,
  });
};
</script>

<template>
  <Card>
    <CardHeader>
      <CardTitle>Team Name</CardTitle>
      <CardDescription>The team's name and owner information.</CardDescription>
    </CardHeader>
    <form @submit.prevent="updateTeamName">
      <CardContent>
        <div class="flex items-center mt-2">
          <img class="w-12 h-12 rounded-full object-cover" :src="team.owner.profile_photo_path" :alt="team.owner.name">

          <div class="ms-4 leading-tight">
            <div class="text-gray-900 dark:text-white">{{ team.owner.name }}</div>
            <div class="text-gray-700 dark:text-gray-300 text-sm">
              {{ team.owner.email }}
            </div>
          </div>
        </div>
        <div class="py-6">
          <Label for="name" class="block text-sm font-medium leading-6">
            Team Name
          </Label>
          <div class="mt-2">
            <Input
              id="name"
              name="name"
              type="text"
              autocomplete="off"
              placeholder="Team Name"
              required
              autofocus
              v-model="form.name"
              :disabled="! permissions.canUpdateTeam"
              class="block w-full rounded-md border-0 py-1.5 shadow-sm ring-1 ring-inset ring-ring placeholder:text-foreground focus:ring-2 focus:ring-inset focus:ring-ring sm:text-sm sm:leading-6"
            />
            <template v-if="form.errors.name">
              <p class="mt-2 text-md text-destructive">
                {{ form.errors.name }}
              </p>
            </template>
          </div>
        </div>
      </CardContent>
      <template v-if="permissions.canUpdateTeam">
        <CardFooter class="border-t px-6 py-4">
          <ActionMessage :on="form.recentlySuccessful" class="me-3">
            Saved.
          </ActionMessage>

          <Button
            type="submit"
            :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
            class="flex w-full justify-center rounded-md bg-ring px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-ring/50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-ring"
          >
            Save<span :on="form.recentlySuccessful">d</span>
          </Button>
        </CardFooter>
      </template>
    </form>
  </Card>
</template>
