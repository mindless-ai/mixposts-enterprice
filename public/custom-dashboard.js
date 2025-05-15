// Custom Dashboard Links Injector
(function() {
    console.log('Custom dashboard script loaded!');
    
    // Create a style element for our custom CSS
    const style = document.createElement('style');
    style.textContent = `
        .custom-dashboard-links {
            padding: 0 1.5rem;
            margin-bottom: 1.5rem;
        }
        .custom-links-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .custom-link-card {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-radius: 0.75rem;
            transition: all 0.2s;
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .card-blue {
            background-color: #EFF6FF;
        }
        .card-blue:hover {
            background-color: #DBEAFE;
        }
        .card-green {
            background-color: #ECFDF5;
        }
        .card-green:hover {
            background-color: #D1FAE5;
        }
        .card-content {
            display: flex;
            flex-direction: column;
        }
        .card-title {
            font-weight: 500;
            font-size: 1.125rem;
        }
        .card-title.blue {
            color: #1E40AF;
        }
        .card-title.green {
            color: #065F46;
        }
        .card-desc {
            font-size: 0.875rem;
        }
        .card-desc.blue {
            color: #2563EB;
        }
        .card-desc.green {
            color: #10B981;
        }
        .card-icon {
            width: 1.5rem;
            height: 1.5rem;
        }
        .card-icon.blue {
            color: #3B82F6;
        }
        .card-icon.green {
            color: #10B981;
        }
    `;
    document.head.appendChild(style);
    
    // Function to inject our links
    function injectLinks() {
        // Check if we're on the dashboard
        if (!window.location.pathname.includes('/workspace/') || 
            !document.title.toLowerCase().includes('dashboard')) {
            return;
        }
        
        console.log('On dashboard page, attempting to inject links...');
        
        // Check if we've already injected
        if (document.querySelector('.custom-dashboard-links')) {
            return;
        }
        
        // Try to find the row-px element (accounts container)
        const container = document.querySelector('.row-px');
        if (!container) {
            console.log('Could not find target container');
            return;
        }
        
        // Create our links element
        const links = document.createElement('div');
        links.className = 'custom-dashboard-links';
        links.innerHTML = `
            <div class="custom-links-container">
                <div class="custom-link-card card-blue" id="search-analytics-btn">
                    <div class="card-content">
                        <span class="card-title blue">Search Analytics</span>
                        <span class="card-desc blue">View your Google search performance</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="card-icon blue" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </div>
                
                <div class="custom-link-card card-green" id="social-analytics-btn">
                    <div class="card-content">
                        <span class="card-title green">Social Analytics</span>
                        <span class="card-desc green">Check your Twitter engagement metrics</span>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="card-icon green" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>
        `;
        
        // Insert before the container
        container.parentNode.insertBefore(links, container);
        
        // Add click handlers
        document.getElementById('search-analytics-btn').addEventListener('click', function() {
            window.open('https://www.google.com', '_blank');
        });
        
        document.getElementById('social-analytics-btn').addEventListener('click', function() {
            window.open('https://analytics.twitter.com', '_blank');
        });
        
        console.log('Dashboard links injected successfully!');
    }
    
    // Function to check and inject periodically
    function checkAndInject() {
        injectLinks();
        setTimeout(checkAndInject, 1000);
    }
    
    // Start the process when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', checkAndInject);
    } else {
        checkAndInject();
    }
})();
