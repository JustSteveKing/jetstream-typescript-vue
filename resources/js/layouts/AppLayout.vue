<script setup lang="ts">
import {
  RocketLaunchIcon,
} from "@heroicons/vue/24/outline";
import { Menu, Package2 } from 'lucide-vue-next'
import {Button} from '@/components/ui/button'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger
} from '@/components/ui/dropdown-menu'
import {Sheet, SheetContent, SheetTrigger} from '@/components/ui/sheet'
import {Link, usePage} from "@inertiajs/vue3";
import TeamSwitcher from "@/components/app/TeamSwitcher.vue";
import {Avatar, AvatarFallback, AvatarImage} from "@/components/ui/avatar";

const page = usePage();
</script>

<template>
  <div class="flex min-h-screen w-full flex-col">
    <header class="sticky top-0 flex h-16 items-center gap-4 border-b bg-background px-4 md:px-6">
      <nav
        role="navigation"
        aria-label="Application navigation"
        aria-description="Application navigation"
        class="hidden flex-col gap-6 text-lg font-medium md:flex md:flex-row md:items-center md:gap-5 md:text-sm lg:gap-6">
        <Link
          :href="route('pages:home')"
          class="flex items-center gap-2 text-lg font-semibold md:text-base"
        >
          <RocketLaunchIcon class="h-6 w-6"/>
          <span class="sr-only">Acme Inc</span>
        </Link>
        <Link
          :href="route('pages:home')"
          class="text-foreground transition-colors hover:text-foreground"
        >
          Dashboard
        </Link>
        <a
          href="#"
          class="text-muted-foreground transition-colors hover:text-foreground"
        >
          Orders
        </a>
        <a
          href="#"
          class="text-muted-foreground transition-colors hover:text-foreground"
        >
          Products
        </a>
        <a
          href="#"
          class="text-muted-foreground transition-colors hover:text-foreground"
        >
          Customers
        </a>
        <a
          href="#"
          class="text-muted-foreground transition-colors hover:text-foreground"
        >
          Analytics
        </a>
      </nav>
      <Sheet>
        <SheetTrigger as-child>
          <Button
            variant="outline"
            size="icon"
            class="shrink-0 md:hidden"
          >
            <Menu class="h-5 w-5"/>
            <span class="sr-only">Toggle navigation menu</span>
          </Button>
        </SheetTrigger>
        <SheetContent side="left">
          <nav class="grid gap-6 text-lg font-medium">
            <Link
              :href="route('pages:home')"
              class="flex items-center gap-2 text-lg font-semibold"
            >
              <Package2 class="h-6 w-6"/>
              <span class="sr-only">Acme Inc</span>
            </Link>
            <Link :href="route('pages:home')" class="hover:text-foreground">
              Dashboard
            </Link>
            <a
              href="#"
              class="text-muted-foreground hover:text-foreground"
            >
              Orders
            </a>
            <a
              href="#"
              class="text-muted-foreground hover:text-foreground"
            >
              Products
            </a>
            <a
              href="#"
              class="text-muted-foreground hover:text-foreground"
            >
              Customers
            </a>
            <a
              href="#"
              class="text-muted-foreground hover:text-foreground"
            >
              Analytics
            </a>
          </nav>
        </SheetContent>
      </Sheet>
      <div class="flex w-full items-center justify-end gap-4 md:ml-auto md:gap-2 lg:gap-4">
        <TeamSwitcher/>

        <DropdownMenu>
          <DropdownMenuTrigger as-child>
            <Button variant="secondary" size="icon" class="rounded-full">
              <Avatar class="h-10 w-10">
                <AvatarImage
                  :src="page.props.auth.user.avatar"
                  :alt="page.props.auth.user.name"
                />
                <AvatarFallback>{{ page.props.auth.user.name.substring(0,2) }}</AvatarFallback>
              </Avatar>
              <span class="sr-only">Toggle user menu</span>
            </Button>
          </DropdownMenuTrigger>
          <DropdownMenuContent align="end">
            <DropdownMenuLabel class="flex flex-col">
              <span class="text-foreground">{{ page.props.auth.user.name }}</span>
              <span class="text-muted-foreground">{{ page.props.auth.user.email }}</span>
            </DropdownMenuLabel>
            <DropdownMenuSeparator/>
            <DropdownMenuItem>
              <Link :href="route('profile.show')">Account</Link>
            </DropdownMenuItem>
            <DropdownMenuSeparator/>
            <DropdownMenuItem>
              <Link :href="route('teams.show', page.props.auth.user.team.id)">Manage Team</Link>
            </DropdownMenuItem>
            <DropdownMenuSeparator/>
            <DropdownMenuItem>
              <Link :href="route('api-tokens.index')">API Tokensx</Link>
            </DropdownMenuItem>
            <DropdownMenuSeparator/>
            <DropdownMenuItem>
              <Link :href="route('logout')" method="POST">Logout</Link>
            </DropdownMenuItem>
          </DropdownMenuContent>
        </DropdownMenu>
      </div>
    </header>
    <slot/>
  </div>
</template>
