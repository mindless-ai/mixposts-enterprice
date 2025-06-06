<script setup>
import {inject} from "vue";
import {Link} from '@inertiajs/vue3';
import Logo from "@/Components/DataDisplay/Logo.vue"
import MenuItem from "@/Components/Sidebar/MenuItem.vue"
import MenuDelimiter from "@/Components/Sidebar/MenuDelimiter.vue"
import MenuGroupHeader from "@/Components/Sidebar/MenuGroupHeader.vue"
import MenuGroupBody from "@/Components/Sidebar/MenuGroupBody.vue"
import DarkButtonLink from "@/Components/Button/DarkButtonLink.vue"
import PlusIcon from "@/Icons/Plus.vue"
import GridIcon from "@/Icons/Grid.vue"
import CalendarIcon from "@/Icons/Calendar.vue"
import PhotoIcon from "@/Icons/Photo.vue"
import ShareIcon from "@/Icons/Share.vue"
import UserMenu from "@/Components/Navigation/UserMenu.vue";
import DashboardIcon from "@/Icons/Dashboard.vue";
import WebhooksIcon from "@/Icons/Webhooks.vue";
import RectangleGroup from "@/Icons/RectangleGroup.vue";
import Forward from "@/Icons/Forward.vue";
import useWorkspace from "@/Composables/useWorkspace";
import TagIcon from "@/Icons/Tag.vue";

const workspaceCtx = inject('workspaceCtx');

const {isWorkspaceAdminRole, isWorkspaceEditorRole} = useWorkspace();

const handleTemplatesClick = () => {
    window.location.href = 'https://www.google.com';
};
</script>

<template>
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

        <div class="flex flex-col space-y-lg overflow-y-auto px-xl mt-2xl h-full">
            <MenuGroupBody>
                <MenuItem :url="route('mixpost.dashboard', {workspace: workspaceCtx.id})"
                          :active="$page.component === 'Workspace/Dashboard'">
                    <template #icon>
                        <DashboardIcon/>
                    </template>
                    {{ $t("dashboard.dashboard") }}
                </MenuItem>
            </MenuGroupBody>
            <MenuDelimiter/>
            <MenuGroupHeader :create-url="!isWorkspaceEditorRole ? null : route('mixpost.posts.create', {workspace: workspaceCtx.id})">
                {{ $t('post.content') }}
                <template #icon>
                    <PlusIcon/>
                </template>
            </MenuGroupHeader>
            <MenuGroupBody>
                <MenuItem :url="route('mixpost.posts.index', {workspace: workspaceCtx.id})"
                          :active="$page.component === 'Workspace/Posts/Index'">
                    <template #icon>
                        <GridIcon/>
                    </template>
                    {{ $t('post.posts') }}
                </MenuItem>
                <MenuItem :url="route('mixpost.calendar', {workspace: workspaceCtx.id})"
                          :active="$page.component === 'Workspace/Calendar'">
                    <template #icon>
                        <CalendarIcon/>
                    </template>
                    {{ $t('calendar.calendar') }}
                </MenuItem>
                <MenuItem :url="route('mixpost.media.index', {workspace: workspaceCtx.id})"
                          :active="$page.component === 'Workspace/Media'">
                    <template #icon>
                        <PhotoIcon/>
                    </template>
                    {{ $t('media.media_library') }}
                </MenuItem>
                <template v-if="isWorkspaceEditorRole">
                    <a :href="`https://postc.redalien.ai/brand-management?workspace=${workspaceCtx.id}`" target="_blank" data-turbo="false" class="flex items-center text-sm text-gray-700 hover:text-primary-600 py-xs px-sm rounded-lg hover:bg-gray-50">
                        <RectangleGroup class="w-lg h-lg" />
                        <span class="ml-sm">Mariano</span>
                    </a>

                    <MenuItem :url="route('mixpost.brand-management', {workspace: workspaceCtx.id})"
                              :active="$page.component === 'Workspace/BrandManagement'">
                        <template #icon>
                            <TagIcon/>
                        </template>
                        {{ $t('brand.management') }}
                    </MenuItem>
                </template>
            </MenuGroupBody>

            <template v-if="isWorkspaceAdminRole">
                <MenuDelimiter/>
                <MenuGroupHeader :create-url="route('mixpost.posts.create', {workspace: workspaceCtx.id})">
                    {{ $t('post.configuration') }}
                </MenuGroupHeader>
                <MenuGroupBody>
                    <MenuItem :url="route('mixpost.accounts.index', {workspace: workspaceCtx.id})"
                              :active="$page.component === 'Workspace/Accounts/Accounts'">
                        <template #icon>
                            <ShareIcon/>
                        </template>
                        {{ $t('account.accounts') }}
                    </MenuItem>
                    <MenuItem :url="route('mixpost.postingSchedule.index', {workspace: workspaceCtx.id})"
                              :active="$page.component === 'Workspace/PostingSchedule'">
                        <template #icon>
                            <Forward/>
                        </template>
                        {{ $t('posting_schedule.posting_schedule') }}
                    </MenuItem>
                    <MenuItem :url="route('mixpost.webhooks.index', {workspace: workspaceCtx.id})"
                              :active="$page.component === 'Workspace/Webhooks/Index'">
                        <template #icon>
                            <WebhooksIcon/>
                        </template>
                        {{ $t('webhook.webhooks') }}
                    </MenuItem>
                    <a :href="`https://postc.redalien.ai/brand-management?workspace=${workspaceCtx.id}`" target="_blank" data-turbo="false" class="flex items-center text-sm text-gray-700 hover:text-primary-600 py-xs px-sm rounded-lg hover:bg-gray-50">
                        <RectangleGroup class="w-lg h-lg" />
                        <span class="ml-sm">Mariano</span>
                    </a>
                    
                </MenuGroupBody>
            </template>
        </div>

        <div class="px-xl pt-xl">
            <UserMenu/>
        </div>
    </div>
</template>
