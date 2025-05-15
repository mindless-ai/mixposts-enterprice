/**
 * Dashboard Customizer for Mixpost
 * 
 * This script injects custom external links into the Mixpost dashboard.
 */

// Execute after DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Function to check if we're on the dashboard page
    function isDashboardPage() {
        return window.location.href.includes('/workspace/') && 
               document.querySelector('.row-py') !== null &&
               document.title.toLowerCase().includes('dashboard');
    }

    // Inject custom links if we're on the dashboard
    function injectCustomLinks() {
        if (!isDashboardPage()) return;
        
        // Find the target container - row-py div
        const container = document.querySelector('.row-py');
        if (!container) return;
        
        // Find the position where to insert our custom links
        // We want to insert after the PageHeader but before the accounts section
        const pageHeader = container.querySelector('[class*="page-header"]') || 
                          container.firstElementChild;
        
        if (!pageHeader) return;
        
        // Create our custom links section
        const customLinksSection = document.createElement('div');
        customLinksSection.className = 'row-px mb-xl';
        customLinksSection.innerHTML = `
            <div class="flex flex-wrap gap-4">
                <button 
                    id="search-analytics-btn"
                    class="flex-1 bg-blue-50 hover:bg-blue-100 rounded-xl p-4 flex items-center justify-between shadow-sm transition-all">
                    <div class="flex flex-col">
                        <span class="font-medium text-blue-800 text-lg">Search Analytics</span>
                        <span class="text-blue-600 text-sm">View your Google search performance</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </button>
                
                <button 
                    id="social-analytics-btn"
                    class="flex-1 bg-emerald-50 hover:bg-emerald-100 rounded-xl p-4 flex items-center justify-between shadow-sm transition-all">
                    <div class="flex flex-col">
                        <span class="font-medium text-emerald-800 text-lg">Social Analytics</span>
                        <span class="text-emerald-600 text-sm">Check your Twitter engagement metrics</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </button>
            </div>
        `;
        
        // Insert after page header
        pageHeader.insertAdjacentElement('afterend', customLinksSection);
        
        // Add event listeners to the buttons
        document.getElementById('search-analytics-btn').addEventListener('click', function() {
            window.open('https://www.google.com', '_blank');
        });
        
        document.getElementById('social-analytics-btn').addEventListener('click', function() {
            window.open('https://analytics.twitter.com', '_blank');
        });
    }
    
    // Initial injection
    injectCustomLinks();
    
    // For SPA navigation, we need to watch for page changes
    // This uses a simple interval check, but you can use more sophisticated methods
    // like MutationObserver if needed
    let lastUrl = window.location.href;
    const urlWatcher = setInterval(function() {
        if (lastUrl !== window.location.href) {
            lastUrl = window.location.href;
            setTimeout(injectCustomLinks, 300); // Give a small delay for DOM to update
        }
    }, 1000);
});
