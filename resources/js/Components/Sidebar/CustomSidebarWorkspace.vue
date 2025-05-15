&lt;script setup&gt;
import { inject } from "vue";
import MenuItem from "@/Components/Sidebar/MenuItem.vue"
import TagIcon from "@/Icons/Tag.vue";

const workspaceCtx = inject('workspaceCtx');

&lt;/script&gt;

&lt;template&gt;
    &lt;MenuItem 
        :url="route('mixpost.brand-management', {workspace: workspaceCtx.id})"
        :active="$page.component === 'Workspace/BrandManagement'"&gt;
        &lt;template #icon&gt;
            &lt;TagIcon/&gt;
        &lt;/template&gt;
        {{ $t('brand.management') }}
    &lt;/MenuItem&gt;
&lt;/template&gt;
