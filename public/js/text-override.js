// This script will override specific text elements in the UI
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
});
