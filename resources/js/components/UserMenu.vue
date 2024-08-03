<script setup lang="ts">
import {
  Cloud,
  Briefcase,
  Github,
  LogOut,
  Plus,
  Settings,
  User,
} from 'lucide-vue-next'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import { Button } from '@/components/ui/button'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuGroup,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import {Link, usePage} from "@inertiajs/vue3";

const page = usePage();
</script>

<template>
  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost">
        <Avatar>
          <AvatarImage :src="page.props.auth.user.avatar ?? 'https://github.com/octocat.png'" alt="@radix-vue" />
          <AvatarFallback>CN</AvatarFallback>
        </Avatar>
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent class="w-56">
      <DropdownMenuLabel>
        {{ page.props.auth.user.name }}
      </DropdownMenuLabel>
      <DropdownMenuSeparator />
      <DropdownMenuGroup>
        <DropdownMenuItem>
          <User class="mr-2 h-4 w-4" />
          <Link :href="route('profile.show')" class="w-full text-left">
            Profile
          </Link>
        </DropdownMenuItem>
      </DropdownMenuGroup>
      <DropdownMenuSeparator />
      <DropdownMenuItem>
        <Briefcase class="mr-2 h-4 w-4" />
        <Link :href="route('teams.show', page.props.auth.user.team.id)" class="w-full text-left">Manage Team</Link>
      </DropdownMenuItem>
      <DropdownMenuSeparator />
      <DropdownMenuItem>
        <Settings class="mr-2 h-4 w-4" />
        <Link :href="route('api-tokens.index')" class="w-full text-left">API</Link>
      </DropdownMenuItem>
      <DropdownMenuSeparator />
      <DropdownMenuItem>
        <LogOut class="mr-2 h-4 w-4" />
        <Link :href="route('logout')" method="post" class="w-full text-left">
          Log out
        </Link>
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>
</template>
