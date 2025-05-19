/**
 * Custom Translation Override
 * 
 * This script overrides specific translations in the application.
 */

// Function to override translations
function overrideTranslations() {
    // Check if translations are available in the global Inertia object
    if (window.Inertia && window.Inertia.page && window.Inertia.page.props) {
        // Ensure translations object exists
        if (!window.Inertia.page.props.translations) {
            window.Inertia.page.props.translations = {};
        }
        
        // Directly override the template.content translation
        window.Inertia.page.props.translations['template.content'] = 'Content';
        
        // Also try with the full path if needed
        if (window.Inertia.page.props.translations.template) {
            window.Inertia.page.props.translations.template.content = 'Content';
        }
        
        console.log('Translation overrides applied');
    }
}

// Run when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Run immediately
    overrideTranslations();
    
    // Also run after Inertia navigation
    if (window.Inertia) {
        const originalVisit = window.Inertia.visit;
        window.Inertia.visit = function() {
            return originalVisit.apply(this, arguments).then(() => {
                setTimeout(overrideTranslations, 100);
            });
        };
    }
});
