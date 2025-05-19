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
import ShareIcon from '@/Icons/Share.vue';
import UserMenu from '@/Components/Navigation/UserMenu.vue';
import DashboardIcon from '@/Icons/Dashboard.vue';
import WebhooksIcon from '@/Icons/Webhooks.vue';
import Forward from '@/Icons/Forward.vue';

// Import the original component
import { defineAsyncComponent } from 'vue';

const workspaceCtx = inject('workspaceCtx');

// Use the original component's logic but override the template
const OriginalSidebarWorkspace = defineAsyncComponent(() =>
  import('@inovector/mixpost-pro-team/src/Components/Sidebar/SidebarWorkspace.vue')
);

// Override the template to change the Templates text to Content
const template = `
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

          <MenuItem :url="route('mixpost.templates.index', {workspace: workspaceCtx.id})"
                   :active="$page.component === 'Workspace/Templates/Index'">
            <template #icon>
              <RectangleGroup/>
            </template>
            Content
          </MenuItem>
        </template>
      </MenuGroupBody>
    </div>
  </div>
`;

// Export the component with the overridden template
export default {
  components: {
    Logo,
    MenuItem,
    MenuDelimiter,
    MenuGroupHeader,
    MenuGroupBody,
    DarkButtonLink,
    PlusIcon,
    GridIcon,
    CalendarIcon,
    PhotoIcon,
    ShareIcon,
    UserMenu,
    DashboardIcon,
    WebhooksIcon,
    RectangleGroup,
    Forward,
    Link
  },
  template,
  setup() {
    const { isWorkspaceAdminRole, isWorkspaceEditorRole } = useWorkspace();
    
    return {
      isWorkspaceAdminRole,
      isWorkspaceEditorRole,
      workspaceCtx,
      route
    };
  }
};
</script>

<script>
import useWorkspace from '../../Composables/useWorkspace';

export default {
  name: 'CustomSidebarWorkspace',
  setup() {
    const { isWorkspaceAdminRole, isWorkspaceEditorRole } = useWorkspace();
    
    return {
      isWorkspaceAdminRole,
      isWorkspaceEditorRole
    };
  }
};
</script>
