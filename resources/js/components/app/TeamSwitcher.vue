<script setup lang="ts">
import { ref } from 'vue'
import {
  CheckIcon,
  ChevronUpDownIcon as CaretSortIcon,
  PlusCircleIcon as PlusCircledIcon,
} from "@heroicons/vue/24/outline";
import {router, useForm} from '@inertiajs/vue3'
import { cn } from '@/lib/utils'
import {
  Avatar,
  AvatarFallback,
  AvatarImage,
} from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'

import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
  DialogTrigger,
} from '@/components/ui/dialog'
import { Command, CommandEmpty, CommandGroup, CommandItem, CommandList, CommandSeparator } from '@/components/ui/command'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'
import {usePage} from "@inertiajs/vue3";

const page = usePage();

const open = ref(false)
const showNewTeamDialog = ref(false)
const selectedTeam = page.props.auth.user.team

const form = useForm({
  name: '',
});

const createTeam = async () => {
  form.post(route('teams.store'), {
    errorBag: 'createTeam',
    preserveScroll: true,
  });
};

const switchTeam = async (teamId: string) => {
  const switchTeamForm = useForm({
    team_id: teamId,
  });
  switchTeamForm.put(route('current-team.update'), {
    onSuccess: () => window.location.reload(),
  });
};

</script>

<template>
  <Dialog v-model:open="showNewTeamDialog">
    <Popover v-model:open="open">
      <PopoverTrigger as-child>
        <Button
          variant="outline"
          role="combobox"
          aria-expanded="open"
          aria-label="Select a team"
          :class="cn('w-[200px] justify-between', $attrs.class ?? '')"
        >
          <Avatar class="mr-2 h-5 w-5">
            <AvatarImage
              :src="`https://github.com/${selectedTeam.name}.png`"
              :alt="selectedTeam.name"
            />
            <AvatarFallback>{{ selectedTeam.name.substring(0,2) }}</AvatarFallback>
          </Avatar>
          {{ selectedTeam.name }}
          <CaretSortIcon class="ml-auto h-4 w-4 shrink-0 opacity-50" />
        </Button>
      </PopoverTrigger>
      <PopoverContent class="w-[200px] p-0">
        <Command>
          <CommandList>
            <CommandEmpty>No team found.</CommandEmpty>
            <CommandGroup>
              <CommandItem
                v-for="team in page.props.auth.user.teams"
                :key="team.id"
                :value="team.name"
                class="text-sm"
                @select="switchTeam(team.id)"
              >
                <Avatar class="mr-2 h-5 w-5">
                  <AvatarImage
                    :src="`https://github.com/${team.name}.png`"
                    :alt="team.name"
                    class="grayscale"
                  />
                  <AvatarFallback>{{ team.name.substring(0,2) }}</AvatarFallback>
                </Avatar>
                {{ team.name }}
                <CheckIcon
                  :class="cn('ml-auto h-4 w-4',
                  selectedTeam.id === team.id
                    ? 'opacity-100'
                    : 'opacity-0',
                  )"
                />
              </CommandItem>
            </CommandGroup>
          </CommandList>
          <CommandSeparator />
          <CommandList>
            <CommandGroup>
              <DialogTrigger as-child>
                <CommandItem
                  value="create-team"
                  @select="() => {
                    open = false
                    showNewTeamDialog = true
                  }"
                >
                  <PlusCircledIcon class="mr-2 h-5 w-5" />
                  Create Team
                </CommandItem>
              </DialogTrigger>
            </CommandGroup>
          </CommandList>
        </Command>
      </PopoverContent>
    </Popover>
    <DialogContent>
      <DialogHeader>
        <DialogTitle>Create team</DialogTitle>
        <DialogDescription>
          Quickly create a new team to manage.
        </DialogDescription>
      </DialogHeader>
      <form @submit.prevent="createTeam">
        <div>
          <div class="space-y-4 py-2 pb-4">
            <div class="space-y-2">
              <Label for="name">Team name</Label>
              <Input v-model="form.name" id="name" type="text" name="name" placeholder="Kings Landing Inc." />
            </div>
          </div>
        </div>
        <DialogFooter>
          <Button variant="outline" @click="showNewTeamDialog = false">
            Cancel
          </Button>
          <Button type="submit">
            Continue
          </Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>
