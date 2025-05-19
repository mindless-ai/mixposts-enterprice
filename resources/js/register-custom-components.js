import { createApp } from 'vue';
import CustomSidebar from './Components/CustomSidebar.vue';

// This function will be called when the app is being initialized
export function registerCustomComponents(app) {
    // Register our custom sidebar component globally
    app.component('CustomSidebar', CustomSidebar);
    
    // Override the original SidebarWorkspace component with our custom one
    app.component('SidebarWorkspace', CustomSidebar);
    
    console.log('Custom components registered successfully');
}

// Export the components in case they need to be imported elsewhere
export { CustomSidebar };
