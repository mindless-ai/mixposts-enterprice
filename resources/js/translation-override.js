/**
 * Custom Translation Override
 * 
 * This script overrides specific translations in the application.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Check if Inertia app is loaded and has a translations property
    const waitForInertia = setInterval(function() {
        if (window.Inertia && window.Inertia.page && window.Inertia.page.props && window.Inertia.page.props.translations) {
            clearInterval(waitForInertia);
            
            // Override the "Templates" translation to "Content"
            if (window.Inertia.page.props.translations['template.content'] === 'Templates') {
                window.Inertia.page.props.translations['template.content'] = 'Content';
            }
            
            // Force a refresh of components that might use this translation
            if (window.Inertia.app && typeof window.Inertia.app.$forceUpdate === 'function') {
                window.Inertia.app.$forceUpdate();
            }
        }
    }, 100);
});
