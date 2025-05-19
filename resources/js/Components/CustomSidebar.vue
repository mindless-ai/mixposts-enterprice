<template>
  <div class="sidebar-workspace">
    <!-- Copy the entire original template but modify the specific part we want to change -->
    <div class="w-full h-full flex flex-col py-2xl bg-white border-r border-gray-200">
      <div :class="{'mb-12': isWorkspaceEditorRole}" class="relative px-xl">
        <Link :href="route('mixpost.dashboard', {workspace: workspaceCtx.id})">
          <Logo/>
        </Link>
      </div>

      <div v-if="isWorkspaceEditorRole" class="flex px-xl">
        <DarkButtonLink :href="route('mixpost.posts.create', {workspace: workspaceCtx.id})" class="w-full">
          <template #icon>
            <PlusIcon/>
          </template>
          {{ $t("media.create_post") }}
        </DarkButtonLink>
      </div>

      <div class="flex-1 overflow-y-auto mt-6">
        <MenuGroupBody>
          <MenuItem :url="route('mixpost.dashboard', {workspace: workspaceCtx.id})"
                   :active="$page.component === 'Dashboard/Index'">
            <template #icon>
              <DashboardIcon/>
            </template>
            {{ $t('dashboard.dashboard') }}
          </MenuItem>

          <template v-if="isWorkspaceEditorRole">
            <MenuItem :url="route('mixpost.posts.index', {workspace: workspaceCtx.id})"
                     :active="$page.component.startsWith('Posts/')">
              <template #icon>
                <GridIcon/>
              </template>
              {{ $t('post.posts') }}
            </MenuItem>

            <MenuItem :url="route('mixpost.calendar.index', {workspace: workspaceCtx.id})"
                     :active="$page.component === 'Calendar/Index'">
              <template #icon>
                <CalendarIcon/>
              </template>
              {{ $t('calendar.calendar') }}
            </MenuItem>


            <MenuItem :url="route('mixpost.media.index', {workspace: workspaceCtx.id})"
                     :active="$page.component === 'Media/Index'">
              <template #icon>
                <PhotoIcon/>
              </template>
              {{ $t('media.media_library') }}
            </MenuItem>

            <!-- Modified section - Changed from $t('template.content') to 'Content' -->
            <MenuItem :url="route('mixpost.templates.index', {workspace: workspaceCtx.id})"
                     :active="$page.component === 'Workspace/Templates/Index'">
              <template #icon>
                <RectangleGroup/>
              </template>
              Content
            </MenuItem>
            <!-- End of modified section -->

            <MenuDelimiter/>

            <MenuGroupHeader>
              {{ $t('publish.accounts') }}
            </MenuGroupHeader>

            <template v-for="account in accounts" :key="account.id">
              <MenuItem :url="route('mixpost.accounts.edit', {account: account.id, workspace: workspaceCtx.id})"
                       :active="$page.url.includes(`/accounts/${account.id}`)"
                       :class="accountCssColor(account)">
                <template #icon>
                  <component :is="accountIcon(account)" :class="accountIconColor(account)"/>
                </template>
                {{ account.name }}
                <span v-if="!account.isReady()" class="text-xs text-gray-500 ml-1">({{ $t('post.needs_attention') }})</span>
              </MenuItem>
            </template>


            <MenuDelimiter/>

            <MenuGroupHeader>
              {{ $t('settings.settings') }}
            </MenuGroupHeader>

            <MenuItem :url="route('mixpost.users.index', {workspace: workspaceCtx.id})"
                     :active="$page.component === 'Settings/Users/Index'">
              <template #icon>
                <UserGroupIcon/>
              </template>
              {{ $t('user.users') }}
            </MenuItem>


            <MenuItem v-if="isWorkspaceOwner" :url="route('mixpost.workspaces.edit', {workspace: workspaceCtx.id})"
                     :active="$page.component === 'Settings/Workspace/Edit'">
              <template #icon>
                <Cog6ToothIcon/>
              </template>
              {{ $t('workspace.workspace') }}
            </MenuItem>


            <MenuDelimiter/>
            <MenuItem :url="route('mixpost.account.edit', {workspace: workspaceCtx.id})"
                     :active="$page.component === 'Settings/Account/Edit'">
              <template #icon>
                <UserCircleIcon/>
              </template>
              {{ $t('user.account') }}
            </MenuItem>
          </template>
        </MenuGroupBody>
      </div>
    </div>
  </div>
</template>

<script setup>
import { inject } from 'vue';
import { Link } from '@inertiajs/vue3';
import { MenuItem, MenuDelimiter, MenuGroupHeader, MenuGroupBody } from '@inertiajs/vue3';
import RectangleGroup from '@/Components/Icons/RectangleGroup.vue';
import Logo from '@/Components/DataDisplay/Logo.vue';
import DarkButtonLink from '@/Components/Button/DarkButtonLink.vue';
import PlusIcon from '@/Icons/Plus.vue';
import GridIcon from '@/Icons/Grid.vue';
import CalendarIcon from '@/Icons/Calendar.vue';
import PhotoIcon from '@/Icons/Photo.vue';
import UserGroupIcon from '@/Icons/UserGroup.vue';
import Cog6ToothIcon from '@/Icons/Cog6Tooth.vue';
import UserCircleIcon from '@/Icons/UserCircle.vue';

const workspaceCtx = inject('workspaceCtx');
const { isWorkspaceEditorRole, isWorkspaceOwner, accounts, accountCssColor, accountIcon, accountIconColor } = useWorkspace();
</script>

<script>
import useWorkspace from '../../Composables/useWorkspace';

export default {
  name: 'CustomSidebar',
  components: {
    MenuItem,
    MenuDelimiter,
    MenuGroupHeader,
    MenuGroupBody,
    Link,
    RectangleGroup,
    Logo,
    DarkButtonLink,
    PlusIcon,
    GridIcon,
    CalendarIcon,
    PhotoIcon,
    UserGroupIcon,
    Cog6ToothIcon,
    UserCircleIcon
  },
  setup() {
    return {
      ...useWorkspace()
    };
  }
};
</script>
