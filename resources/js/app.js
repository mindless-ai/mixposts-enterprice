import './bootstrap';
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';

// Import custom components and overrides
import { registerCustomComponents } from './register-custom-components';
import './translation-override';

// Import custom dashboard enhancements
import './dashboard-customizer';

// Register custom components when the app is created
createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin);
            
        // Register our custom components
        registerCustomComponents(app);
        
        app.mount(el);
    },
});
