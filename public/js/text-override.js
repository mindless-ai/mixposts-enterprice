// This script will override specific text elements in the UI and handle redirects
document.addEventListener('DOMContentLoaded', function() {
    // Configuration for additional sidebar items
    const additionalSidebarItems = [
        {
            name: 'Brand Management',
            icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25" /></svg>',
            url: 'https://redalien-mixposts-frontend-production.up.railway.app/brand-management',
            section: 'Content'
        },
        {
            name: 'Products & Events',
            icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" /></svg>',
            url: 'https://redalien-mixposts-frontend-production.up.railway.app/products',
            section: 'Content'
        },
        {
            name: 'Content Generation',
            icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" /></svg>',
            url: 'https://redalien-mixposts-frontend-production.up.railway.app/content-generation',
            section: 'Content'
        },
        {
            name: 'Content Approval',
            icon: '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>',
            url: 'https://redalien-mixposts-frontend-production.up.railway.app/content-approval',
            section: 'Content'
        }
    ];

    function replaceTemplatesText() {
        // Method 1: Find by specific class in the HTML snippet you provided
        document.querySelectorAll('div.font-medium.tracking-tight').forEach(function(element) {
            if (element.textContent.trim() === 'Templates') {
                element.textContent = 'Content Creation Setup';
                console.log('Replaced Templates text in div.font-medium');
            }
        });
        
        // Method 2: Find by looking at all divs that contain only the Templates text
        document.querySelectorAll('div').forEach(function(element) {
            if (element.textContent.trim() === 'Templates' && element.children.length === 0) {
                element.textContent = 'Content Creation Setup';
                console.log('Replaced Templates text in plain div');
            }
        });
        
        // Method 3: Check all elements that may contain text
        ['span', 'a', 'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'button', 'label'].forEach(function(tagName) {
            document.querySelectorAll(tagName).forEach(function(element) {
                if (element.textContent.trim() === 'Templates') {
                    element.textContent = 'Content Creation Setup';
                    console.log('Replaced Templates text in ' + tagName);
                }
                
                // Also look for child text nodes that might contain 'Templates'
                element.childNodes.forEach(function(node) {
                    if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() === 'Templates') {
                        node.textContent = 'Content Creation Setup';
                        console.log('Replaced Templates text in text node');
                    }
                });
            });
        });
    }
    
    // Run immediately
    replaceTemplatesText();
    
    // Also run on any DOM changes
    const observer = new MutationObserver(function(mutations) {
        replaceTemplatesText();
    });
    
    // Observe all changes to the DOM
    observer.observe(document.body, { 
        childList: true, 
        subtree: true,
        characterData: true,
        characterDataOldValue: true
    });
    
    // Also run after slight delay to catch any late-loading components
    setTimeout(replaceTemplatesText, 1000);
    setTimeout(replaceTemplatesText, 2000);
    
    // Handle clicks on the Templates/Content Creation Setup links
    function handleTemplateLinks() {
        // Look for links and clickable elements that might be related to Templates
        document.addEventListener('click', function(event) {
            // Check if the clicked element or its parent is a link or clickable element
            let targetElement = event.target;
            
            // Navigate up to 3 levels to check if we're clicking within a template link
            for (let i = 0; i < 3; i++) {
                if (!targetElement) break;
                
                // Check if this element has the text or is a link with a recognizable href
                if (targetElement.textContent && targetElement.textContent.trim() === 'Content Creation Setup') {
                    // This is likely our target element
                    event.preventDefault();
                    event.stopPropagation();
                    
                    // Get the current workspace ID from the URL or any available source
                    let workspaceId = getCurrentWorkspaceId();
                    
                    // Redirect to the external URL
                    window.location.href = `https://redalien-mixposts-frontend-production.up.railway.app/brand-management?workspace=${workspaceId}`;
                    console.log('Redirecting to external Templates URL with workspace ID:', workspaceId);
                    return;
                }
                
                // Check if it's an anchor tag pointing to a templates or brand management page
                if (targetElement.tagName === 'A') {
                    const href = targetElement.getAttribute('href');
                    if (href && (href.includes('/templates') || href.includes('/brand-management'))) {
                        event.preventDefault();
                        event.stopPropagation();
                        
                        // Get the current workspace ID
                        let workspaceId = getCurrentWorkspaceId();
                        
                        // Redirect to the external URL
                        window.location.href = `https://redalien-mixposts-frontend-production.up.railway.app/brand-management?workspace=${workspaceId}`;
                        console.log('Redirecting to external Templates URL with workspace ID:', workspaceId);
                        return;
                    }
                }
                
                // Move up to the parent for the next iteration
                targetElement = targetElement.parentElement;
            }
        }, true); // Use capturing to catch the event early
    }
    
    // Function to get the current workspace ID from the URL or any available source
    function getCurrentWorkspaceId() {
        let workspaceId;
        
        // Extract from URL path: /mixpost/{workspaceId}/...
        const currentPath = window.location.pathname;
        const mixpostRegex = /\/mixpost\/([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})/i;
        const matches = currentPath.match(mixpostRegex);
        
        if (matches && matches[1]) {
            workspaceId = matches[1];
            console.log('Found workspace ID in URL path:', workspaceId);
            return workspaceId;
        }
        
        // Fallback check for URL params
        const urlParams = new URLSearchParams(window.location.search);
        workspaceId = urlParams.get('workspace');
        if (workspaceId) {
            return workspaceId;
        }
        
        // If not in URL, check localStorage
        workspaceId = localStorage.getItem('mixposts-workspace-id');
        if (workspaceId) {
            return workspaceId;
        }
        
        // Check for data attributes
        const workspaceElement = document.querySelector('[data-workspace-id]');
        if (workspaceElement) {
            workspaceId = workspaceElement.getAttribute('data-workspace-id');
            if (workspaceId) {
                return workspaceId;
            }
        }
        
        // Log the issue to help with debugging
        console.warn('Could not find workspace ID in current URL path, params, localStorage, or data attributes');
        
        // Return a default workspace ID if one is known or null
        return '322057a1-61d5-4e7c-b03c-d87e37ed318a'; // Using example ID as default
    }
    
    // Initialize the link handler
    handleTemplateLinks();
    
    // Function to hide specific sidebar items
    function hideSidebarItems() {
        // Find and hide Media Library and Content Creation Setup items
        const allSidebarItems = document.querySelectorAll('.font-medium.tracking-tight');
        
        allSidebarItems.forEach(item => {
            const text = item.textContent.trim();
            if (text === 'Media Library' || text === 'Content Creation Setup') {
                // Find the parent anchor element to hide the entire menu item
                let parent = item;
                while (parent && parent.tagName !== 'A') {
                    parent = parent.parentElement;
                }
                
                if (parent) {
                    // Hide the entire menu item
                    parent.style.display = 'none';
                    console.log(`Hidden sidebar item: ${text}`);
                }
            }
        });
    }
    
    // Function to inject additional sidebar items
    function injectSidebarItems() {
        // Wait for the sidebar to be fully loaded
        setTimeout(() => {
            // Process each configured sidebar item
            additionalSidebarItems.forEach(item => {
                // Find the content section
                const sectionHeaders = document.querySelectorAll('.font-semibold.text-black');
                let targetSection = null;
                
                // Find the correct section header
                sectionHeaders.forEach(header => {
                    if (header.textContent.trim() === item.section) {
                        targetSection = header;
                    }
                });
                
                if (!targetSection) return; // Section not found
                
                // Find the navigation group after this section header
                const sectionContainer = targetSection.parentElement;
                const navGroup = sectionContainer.nextElementSibling;
                
                if (!navGroup || !navGroup.classList.contains('flex-col')) return;
                
                // Check if the item already exists to avoid duplicates
                const existingItems = navGroup.querySelectorAll('.font-medium.tracking-tight');
                let alreadyExists = false;
                
                existingItems.forEach(existing => {
                    if (existing.textContent.trim() === item.name) {
                        alreadyExists = true;
                    }
                });
                
                if (alreadyExists) return;
                
                // Create the new nav item with the same structure as existing items
                const navItem = document.createElement('a');
                navItem.className = 'py-xs flex flex-row items-center space-x-md rtl:space-x-reverse transition ease-in-out duration-200 text-gray-400 hover:text-gray-700';
                
                // Extract workspaceId from URL for the correct path
                const workspaceId = getCurrentWorkspaceId();
                
                // Use the hardcoded workspace ID as specified in requirements
                navItem.href = `${item.url}?workspace=${workspaceId}`;
                
                // Create icon container
                const iconContainer = document.createElement('div');
                iconContainer.innerHTML = item.icon;
                
                // Create text container
                const textContainer = document.createElement('div');
                textContainer.className = 'font-medium tracking-tight rtl:tracking-normal';
                textContainer.textContent = ` ${item.name}`;
                
                // Assemble the nav item
                navItem.appendChild(iconContainer);
                navItem.appendChild(textContainer);
                
                // Add the new item to the navigation group
                navGroup.appendChild(navItem);
                
                console.log(`Added new sidebar item: ${item.name}`);
            });
        }, 1000); // Wait 1 second for the sidebar to be fully loaded
    }
    
    // Run the sidebar item injection and hiding
    injectSidebarItems();
    hideSidebarItems();
    
    // Also observe DOM changes to re-inject items when the sidebar is updated
    const sidebarObserver = new MutationObserver(function(mutations) {
        // Check if any of the mutations involve the sidebar structure
        const shouldReinject = mutations.some(mutation => {
            // Check if the mutation target or its parents might be the sidebar
            let node = mutation.target;
            for (let i = 0; i < 5; i++) { // Check up to 5 levels up
                if (!node) break;
                
                // Check for classes that might indicate it's the sidebar
                if (node.classList && 
                    (node.classList.contains('overflow-y-auto') || 
                     node.classList.contains('flex-col') || 
                     node.querySelector('.font-semibold.text-black'))) {
                    return true;
                }
                
                node = node.parentElement;
            }
            return false;
        });
        
        if (shouldReinject) {
            injectSidebarItems();
            hideSidebarItems();
        }
    });
    
    // Start observing the document for sidebar changes
    sidebarObserver.observe(document.body, { 
        childList: true, 
        subtree: true
    });
});
