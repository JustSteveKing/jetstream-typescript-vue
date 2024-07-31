<script setup lang="ts">
import { ref } from 'vue'
import {
  Dialog,
  DialogPanel,
  TransitionChild,
  TransitionRoot,
} from '@headlessui/vue'
import {
  Bars3Icon,
  Cog6ToothIcon,
  HomeIcon,
  XMarkIcon,
  RocketLaunchIcon,
} from '@heroicons/vue/24/outline'
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid'
import { usePage } from "@inertiajs/vue3";
import { Layout } from "@/layouts";
import { UserMenu } from "@/components";

const page = usePage();

const props = defineProps<{
  title: string
}>();

const navigation = [
  { name: 'Dashboard', href: route('pages:home'), icon: HomeIcon, current: page.props.route.name === 'pages:home' },
]
const teams = [
  { id: 1, name: 'Heroicons', href: '#', initial: 'H', current: false },
  { id: 2, name: 'Tailwind Labs', href: '#', initial: 'T', current: false },
  { id: 3, name: 'Workcation', href: '#', initial: 'W', current: false },
]
const userNavigation = [
  { name: 'Your profile', href: '#' },
  { name: 'Sign out', href: '#' },
]

const sidebarOpen = ref(false)
</script>

<template>
  <Layout :title="props.title">
    <div>
      <TransitionRoot as="template" :show="sidebarOpen">
        <Dialog class="relative z-50 lg:hidden" @close="sidebarOpen = false">
          <TransitionChild as="template" enter="transition-opacity ease-linear duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="transition-opacity ease-linear duration-300" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-foreground/80" />
          </TransitionChild>

          <div class="fixed inset-0 flex">
            <TransitionChild as="template" enter="transition ease-in-out duration-300 transform" enter-from="-translate-x-full" enter-to="translate-x-0" leave="transition ease-in-out duration-300 transform" leave-from="translate-x-0" leave-to="-translate-x-full">
              <DialogPanel class="relative mr-16 flex w-full max-w-xs flex-1">
                <TransitionChild as="template" enter="ease-in-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in-out duration-300" leave-from="opacity-100" leave-to="opacity-0">
                  <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                    <button type="button" class="-m-2.5 p-2.5" @click="sidebarOpen = false">
                      <span class="sr-only">Close sidebar</span>
                      <XMarkIcon class="h-6 w-6 text-white" aria-hidden="true" />
                    </button>
                  </div>
                </TransitionChild>
                <div id="mobile-nav" class="flex grow flex-col gap-y-5 overflow-y-auto bg-background px-6 pb-4">
                  <div class="flex h-16 shrink-0 items-center">
                    <RocketLaunchIcon class="h-8 w-auto text-indigo-800 dark:text-indigo-400" />
                  </div>
                  <nav class="flex flex-1 flex-col">
                    <ul role="list" class="flex flex-1 flex-col gap-y-7">
                      <li>
                        <ul role="list" class="-mx-2 space-y-1">
                          <li v-for="item in navigation" :key="item.name">
                            <a :href="item.href" :class="[item.current ? 'text-ring' : 'text-ring/50 hover:text-ring', 'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6']">
                              <component :is="item.icon" :class="[item.current ? 'text-ring' : 'text-ring/50 group-hover:text-ring', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                              {{ item.name }}
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li>
                        <div class="text-xs font-semibold leading-6 text-foreground">Your teams</div>
                        <ul role="list" class="-mx-2 mt-2 space-y-1">
                          <li v-for="team in teams" :key="team.name">
                            <a :href="team.href" :class="[team.current ? 'text-ring' : 'text-ring/50 hover:text-ring', 'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6']">
                              <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-ring bg-indigo-500 text-[0.625rem] font-medium text-accent">{{ team.initial }}</span>
                              <span class="truncate">{{ team.name }}</span>
                            </a>
                          </li>
                        </ul>
                      </li>
                      <li class="mt-auto">
                        <a href="#" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-ring/50 hover:text-ring">
                          <Cog6ToothIcon class="h-6 w-6 shrink-0 text-ring/50 group-hover:text-ring" aria-hidden="true" />
                          Settings
                        </a>
                      </li>
                    </ul>
                  </nav>
                </div>
              </DialogPanel>
            </TransitionChild>
          </div>
        </Dialog>
      </TransitionRoot>

      <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <div id="nav" class="flex grow flex-col gap-y-5 overflow-y-auto bg-background border-r border-ring px-6 pb-4">
          <div class="flex h-16 shrink-0 items-center justify-center">
            <RocketLaunchIcon class="h-8 w-auto text-indigo-800 dark:text-indigo-400" />
          </div>
          <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
              <li>
                <ul role="list" class="-mx-2 space-y-1">
                  <li v-for="item in navigation" :key="item.name">
                    <a :href="item.href" :class="[item.current ? 'text-ring' : 'text-ring/50 hover:text-ring', 'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6']">
                      <component :is="item.icon" :class="[item.current ? 'text-ring' : 'text-ring group-hover:text-ring/50', 'h-6 w-6 shrink-0']" aria-hidden="true" />
                      {{ item.name }}
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <div class="text-xs font-semibold leading-6 text-foreground">Your teams</div>
                <ul role="list" class="-mx-2 mt-2 space-y-1">
                  <li v-for="team in teams" :key="team.name">
                    <a :href="team.href" :class="[team.current ? 'bg-indigo-700 text-foreground' : 'text-foreground hover:text-foreground/50', 'group flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6']">
                      <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border border-indigo-400 bg-indigo-500 text-[0.625rem] font-medium text-white">{{ team.initial }}</span>
                      <span class="truncate">{{ team.name }}</span>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="mt-auto">
                <a href="#" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-foreground hover:text-foreground/50">
                  <Cog6ToothIcon class="h-6 w-6 shrink-0 text-foreground group-hover:text-foreground/50" aria-hidden="true" />
                  Settings
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>

      <div class="lg:pl-72">
        <div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-ring bg-background px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
          <button type="button" class="-m-2.5 p-2.5 text-foreground lg:hidden" @click="sidebarOpen = true">
            <span class="sr-only">Open sidebar</span>
            <Bars3Icon class="h-6 w-6" aria-hidden="true" />
          </button>

          <div class="h-6 w-px bg-ring lg:hidden" aria-hidden="true" />

          <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
            <form class="relative flex flex-1" action="#" method="GET">
              <label for="search-field" class="sr-only">Search</label>
              <MagnifyingGlassIcon class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400" aria-hidden="true" />
              <input id="search-field" class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm" placeholder="Search..." type="search" name="search" />
            </form>
            <div class="flex items-center gap-x-4 lg:gap-x-6">
              <UserMenu />
            </div>
          </div>
        </div>

        <main class="py-10">
          <slot />
        </main>
      </div>
    </div>
  </Layout>
</template>
