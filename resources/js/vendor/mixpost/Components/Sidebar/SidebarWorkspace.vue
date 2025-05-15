&lt;script setup&gt;
import {inject, ref, onMounted, onUnmounted} from "vue";
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
import RectangleGroup from "../../Icons/RectangleGroup.vue";
import Forward from "../../Icons/Forward.vue";
import useWorkspace from "../../Composables/useWorkspace";
import TagIcon from "@/Icons/Tag.vue";
import ArrowLeft from "../../Icons/ArrowLeft.vue";
import Cog from "../../Icons/Cog.vue";
import Users from "../../Icons/Users.vue";
import CreditCard from "../../Icons/CreditCard.vue";
import Document from "../../Icons/Document.vue";
import ShieldCheck from "../../Icons/ShieldCheck.vue";
import ServerStack from "../../Icons/ServerStack.vue";

const routePrefix = inject('routePrefix');
const workspaceCtx = inject('workspaceCtx');
const {activeWorkspace, isWorkspaceOwner, isWorkspaceAdminRole, isWorkspaceEditorRole} = useWorkspace();

const templatesMenuOpen = ref(false);

// Function to handle clicks outside the dropdown
const handleClickOutside = (event) => {
  const dropdown = document.getElementById('templates-dropdown');
  if (dropdown && !dropdown.contains(event.target)) {
    templatesMenuOpen.value = false;
  }
};

// Add and remove event listeners
onMounted(() => {
  document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside);
});
&lt;/script&gt;

&lt;template&gt;
    &lt;div class="w-full h-full flex flex-col py-2xl bg-white border-r border-gray-200"&gt;
        &lt;div :class="{'mb-12': isWorkspaceEditorRole}" class="relative px-xl"&gt;
            &lt;Link :href="route('mixpost.dashboard', {workspace: workspaceCtx.id})"&gt;
                &lt;Logo/&gt;
            &lt;/Link&gt;
        &lt;/div&gt;

        &lt;div v-if="isWorkspaceEditorRole" class="flex px-xl"&gt;
            &lt;DarkButtonLink :href="route('mixpost.posts.create', {workspace: workspaceCtx.id})" class="w-full"&gt;
                &lt;template #icon&gt;
                    &lt;PlusIcon/&gt;
                &lt;/template&gt;
                {{ $t("media.create_post") }}
            &lt;/DarkButtonLink&gt;
        &lt;/div&gt;

        &lt;div class="flex flex-col space-y-lg overflow-y-auto px-xl mt-2xl h-full"&gt;
            &lt;MenuGroupBody&gt;
                &lt;MenuItem :url="route('mixpost.dashboard', {workspace: workspaceCtx.id})"
                          :active="$page.component === 'Workspace/Dashboard'"&gt;
                    &lt;template #icon&gt;
                        &lt;DashboardIcon/&gt;
                    &lt;/template&gt;
                    {{ $t("dashboard.dashboard") }}
                &lt;/MenuItem&gt;
            &lt;/MenuGroupBody&gt;
            &lt;MenuDelimiter/&gt;
            &lt;MenuGroupHeader :create-url="!isWorkspaceEditorRole ? null : route('mixpost.posts.create', {workspace: workspaceCtx.id})"&gt;
                {{ $t('post.content') }}
                &lt;template #icon&gt;
                    &lt;PlusIcon/&gt;
                &lt;/template&gt;
            &lt;/MenuGroupHeader&gt;
            &lt;MenuGroupBody&gt;
                &lt;MenuItem :url="route('mixpost.posts.index', {workspace: workspaceCtx.id})"
                          :active="$page.component === 'Workspace/Posts/Index'"&gt;
                    &lt;template #icon&gt;
                        &lt;GridIcon/&gt;
                    &lt;/template&gt;
                    {{ $t('post.posts') }}
                &lt;/MenuItem&gt;
                &lt;MenuItem :url="route('mixpost.calendar', {workspace: workspaceCtx.id})"
                          :active="$page.component === 'Workspace/Calendar'"&gt;
                    &lt;template #icon&gt;
                        &lt;CalendarIcon/&gt;
                    &lt;/template&gt;
                    {{ $t('calendar.calendar') }}
                &lt;/MenuItem&gt;
                &lt;MenuItem :url="route('mixpost.media.index', {workspace: workspaceCtx.id})"
                          :active="$page.component === 'Workspace/Media'"&gt;
                    &lt;template #icon&gt;
                        &lt;PhotoIcon/&gt;
                    &lt;/template&gt;
                    {{ $t('media.media_library') }}
                &lt;/MenuItem&gt;
                &lt;template v-if="isWorkspaceEditorRole"&gt;
                    &lt;div id="templates-dropdown" class="relative"&gt;
                        &lt;div @click="templatesMenuOpen = !templatesMenuOpen" class="flex items-center justify-between space-x-sm text-sm text-gray-700 hover:text-primary-600 py-xs px-sm rounded-lg hover:bg-gray-50 cursor-pointer"&gt;
                            &lt;div class="flex items-center"&gt;
                                &lt;RectangleGroup class="w-lg h-lg" /&gt;
                                &lt;span class="ml-sm"&gt;{{ $t('template.templates') }}&lt;/span&gt;
                            &lt;/div&gt;
                            &lt;svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" :class="{'rotate-180': templatesMenuOpen}" viewBox="0 0 20 20" fill="currentColor"&gt;
                                &lt;path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /&gt;
                            &lt;/svg&gt;
                        &lt;/div&gt;
                        &lt;div v-if="templatesMenuOpen" class="absolute left-0 mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg z-10"&gt;
                            &lt;Link :href="route('external.redirect', {target: 'google'})" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"&gt;Google&lt;/Link&gt;
                            &lt;Link :href="route('external.redirect', {target: 'twitter'})" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"&gt;Twitter&lt;/Link&gt;
                            &lt;Link :href="route('external.redirect', {target: 'facebook'})" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"&gt;Facebook&lt;/Link&gt;
                        &lt;/div&gt;
                    &lt;/div&gt;
                    &lt;MenuItem :url="route('mixpost.brand-management', {workspace: workspaceCtx.id})"
                              :active="$page.component === 'Workspace/BrandManagement'"&gt;
                        &lt;template #icon&gt;
                            &lt;TagIcon/&gt;
                        &lt;/template&gt;
                        {{ $t('brand.management') }}
                    &lt;/MenuItem&gt;
                &lt;/template&gt;
            &lt;/MenuGroupBody&gt;

            &lt;template v-if="isWorkspaceAdminRole"&gt;
                &lt;MenuDelimiter/&gt;
                &lt;MenuGroupHeader :create-url="route('mixpost.posts.create', {workspace: workspaceCtx.id})"&gt;
                    {{ $t('post.configuration') }}
                &lt;/MenuGroupHeader&gt;
                &lt;MenuGroupBody&gt;
                    &lt;MenuItem :url="route('mixpost.accounts.index', {workspace: workspaceCtx.id})"
                              :active="$page.component === 'Workspace/Accounts/Accounts'"&gt;
                        &lt;template #icon&gt;
                            &lt;ShareIcon/&gt;
                        &lt;/template&gt;
                        {{ $t('account.accounts') }}
                    &lt;/MenuItem&gt;
                    &lt;MenuItem :url="route('mixpost.postingSchedule.index', {workspace: workspaceCtx.id})"
                              :active="$page.component === 'Workspace/PostingSchedule'"&gt;
                        &lt;template #icon&gt;
                            &lt;Forward/&gt;
                        &lt;/template&gt;
                        {{ $t('posting_schedule.posting_schedule') }}
                    &lt;/MenuItem&gt;
                    &lt;MenuItem :url="route('mixpost.webhooks.index', {workspace: workspaceCtx.id})"
                              :active="$page.component === 'Workspace/Webhooks/Index'"&gt;
                        &lt;template #icon&gt;
                            &lt;WebhooksIcon/&gt;
                        &lt;/template&gt;
                        {{ $t('webhook.webhooks') }}
                    &lt;/MenuItem&gt;
                &lt;/MenuGroupBody&gt;
            &lt;/template&gt;
        &lt;/div&gt;

        &lt;div class="px-xl pt-xl"&gt;
            &lt;UserMenu/&gt;
        &lt;/div&gt;
    &lt;/div&gt;
&lt;/template&gt;
