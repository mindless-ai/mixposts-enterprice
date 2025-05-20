// This script will override specific text elements in the UI and handle redirects
document.addEventListener('DOMContentLoaded', function() {
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
        // Try to extract from URL if present
        const urlParams = new URLSearchParams(window.location.search);
        let workspaceId = urlParams.get('workspace');
        
        // If not in URL, check if it's stored elsewhere (localStorage, etc.)
        if (!workspaceId) {
            // Check if workspace ID might be in local storage
            workspaceId = localStorage.getItem('mixposts-workspace-id');
        }
        
        // If still not found, check if it's available in a data attribute on any workspace-related elements
        if (!workspaceId) {
            const workspaceElement = document.querySelector('[data-workspace-id]');
            if (workspaceElement) {
                workspaceId = workspaceElement.getAttribute('data-workspace-id');
            }
        }
        
        // If we couldn't find the ID anywhere, use a placeholder that the backend might handle
        return workspaceId || ':mixposts-workspace-id';
    }
    
    // Initialize the link handler
    handleTemplateLinks();
});
