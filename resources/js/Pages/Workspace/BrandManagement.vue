&lt;script setup&gt;
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    workspace: Object
});
&lt;/script&gt;

&lt;template&gt;
    &lt;AppLayout&gt;
        &lt;Head title="Brand Management" /&gt;
        
        &lt;div class="p-2xl"&gt;
            &lt;h1 class="text-2xl font-bold mb-4"&gt;{{ $t('brand.management') }}&lt;/h1&gt;
            &lt;!-- Add your brand management content here --&gt;
        &lt;/div&gt;
    &lt;/AppLayout&gt;
&lt;/template&gt;
