<script>
    // Wait for page to be fully loaded and Inertia to finish
    document.addEventListener('DOMContentLoaded', function() {
        // Setup a mutation observer to detect when Inertia finishes rendering
        const observer = new MutationObserver(function(mutations) {
            // Check if we're on the dashboard page
            if (window.location.pathname.includes('/workspace/') && 
                document.title.toLowerCase().includes('dashboard')) {
                injectDashboardLinks();
            }
        });
        
        // Start observing the body for changes
        observer.observe(document.body, { childList: true, subtree: true });
        
        // Also try to inject on initial load
        setTimeout(function() {
            if (window.location.pathname.includes('/workspace/') && 
                document.title.toLowerCase().includes('dashboard')) {
                injectDashboardLinks();
            }
        }, 500);
        
        function injectDashboardLinks() {
            // Don't inject if already there
            if (document.getElementById('custom-dashboard-links')) return;
            
            // Find the main container - usually the first div after Inertia root
            const inertiaRoot = document.getElementById('app');
            if (!inertiaRoot) return;
            
            // Try to find the dashboard container
            const dashboardContainer = inertiaRoot.querySelector('.row-py');
            if (!dashboardContainer) return;
            
            // Find where to insert our custom links
            // First, look for the accounts section or the 'no accounts' message
            const accountsSection = dashboardContainer.querySelector('.row-px');
            if (!accountsSection) return;
            
            // Create our custom links container
            const linksContainer = document.createElement('div');
            linksContainer.id = 'custom-dashboard-links';
            linksContainer.className = 'row-px mb-6';
            linksContainer.innerHTML = `
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
            
            // Insert our links before the accounts section (or 'no accounts' message)
            accountsSection.insertAdjacentElement('beforebegin', linksContainer);
            
            // Add click handlers
            document.getElementById('search-analytics-btn').addEventListener('click', function() {
                window.open('https://www.google.com', '_blank');
            });
            
            document.getElementById('social-analytics-btn').addEventListener('click', function() {
                window.open('https://analytics.twitter.com', '_blank');
            });
            
            console.log('Dashboard links injected successfully!');
        }
    });
</script>
