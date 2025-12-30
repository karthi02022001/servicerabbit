/*
|--------------------------------------------------------------------------
| Service Rabbit - Admin Panel JavaScript
| File: public/assets/admin/js/admin.js
|--------------------------------------------------------------------------
*/

document.addEventListener('DOMContentLoaded', function() {
    
    // ============================================
    // Sidebar Toggle (Mobile)
    // ============================================
    const sidebarToggle = document.getElementById('sidebarToggle');
    const adminSidebar = document.getElementById('adminSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    
    if (sidebarToggle && adminSidebar && sidebarOverlay) {
        sidebarToggle.addEventListener('click', function() {
            adminSidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        });
        
        sidebarOverlay.addEventListener('click', function() {
            adminSidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }
    
    // ============================================
    // Auto-hide Alerts
    // ============================================
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // ============================================
    // Confirm Delete
    // ============================================
    const deleteForms = document.querySelectorAll('form[data-confirm]');
    deleteForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const message = this.getAttribute('data-confirm') || 'Are you sure you want to delete this item?';
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });
    
    // ============================================
    // Select All Checkboxes
    // ============================================
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.item-checkbox');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
            });
            updateBulkActions();
        });
        
        // Update select all when individual checkboxes change
        const itemCheckboxes = document.querySelectorAll('.item-checkbox');
        itemCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const allChecked = document.querySelectorAll('.item-checkbox:checked').length === itemCheckboxes.length;
                selectAllCheckbox.checked = allChecked;
                updateBulkActions();
            });
        });
    }
    
    function updateBulkActions() {
        const checkedCount = document.querySelectorAll('.item-checkbox:checked').length;
        const bulkActions = document.getElementById('bulkActions');
        if (bulkActions) {
            bulkActions.style.display = checkedCount > 0 ? 'flex' : 'none';
            const countBadge = bulkActions.querySelector('.selected-count');
            if (countBadge) {
                countBadge.textContent = checkedCount;
            }
        }
    }
    
    // ============================================
    // Password Toggle
    // ============================================
    const passwordToggles = document.querySelectorAll('.password-toggle .toggle-btn');
    passwordToggles.forEach(function(toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            const input = this.closest('.password-toggle').querySelector('input');
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');
            }
        });
    });
    
    // ============================================
    // File Upload Preview
    // ============================================
    const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
    fileInputs.forEach(function(input) {
        input.addEventListener('change', function() {
            const previewId = this.getAttribute('data-preview');
            const preview = document.getElementById(previewId);
            
            if (preview && this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    
    // ============================================
    // Character Counter
    // ============================================
    const textareas = document.querySelectorAll('textarea[data-max-length]');
    textareas.forEach(function(textarea) {
        const maxLength = parseInt(textarea.getAttribute('data-max-length'));
        const counterId = textarea.getAttribute('data-counter');
        const counter = document.getElementById(counterId);
        
        if (counter) {
            function updateCounter() {
                const remaining = maxLength - textarea.value.length;
                counter.textContent = remaining + ' characters remaining';
                counter.classList.remove('warning', 'danger');
                if (remaining <= 20) {
                    counter.classList.add('danger');
                } else if (remaining <= 50) {
                    counter.classList.add('warning');
                }
            }
            
            textarea.addEventListener('input', updateCounter);
            updateCounter();
        }
    });
    
    // ============================================
    // Tooltip Initialization
    // ============================================
    const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    tooltips.forEach(function(tooltip) {
        new bootstrap.Tooltip(tooltip);
    });
    
    // ============================================
    // Popover Initialization
    // ============================================
    const popovers = document.querySelectorAll('[data-bs-toggle="popover"]');
    popovers.forEach(function(popover) {
        new bootstrap.Popover(popover);
    });
    
    // ============================================
    // Form Validation Styling
    // ============================================
    const forms = document.querySelectorAll('.needs-validation');
    forms.forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
    
    // ============================================
    // Slug Generator
    // ============================================
    const slugSource = document.querySelector('[data-slug-source]');
    const slugTarget = document.querySelector('[data-slug-target]');
    
    if (slugSource && slugTarget) {
        slugSource.addEventListener('input', function() {
            if (!slugTarget.getAttribute('data-slug-edited')) {
                slugTarget.value = generateSlug(this.value);
            }
        });
        
        slugTarget.addEventListener('input', function() {
            this.setAttribute('data-slug-edited', 'true');
        });
    }
    
    function generateSlug(text) {
        return text
            .toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
    
    // ============================================
    // Table Row Click
    // ============================================
    const clickableRows = document.querySelectorAll('tr[data-href]');
    clickableRows.forEach(function(row) {
        row.style.cursor = 'pointer';
        row.addEventListener('click', function(e) {
            // Don't navigate if clicking on buttons, links, or checkboxes
            if (e.target.closest('a, button, input, .btn')) {
                return;
            }
            window.location.href = this.getAttribute('data-href');
        });
    });
    
    // ============================================
    // Async Form Submit
    // ============================================
    const asyncForms = document.querySelectorAll('form[data-async]');
    asyncForms.forEach(function(form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = form.querySelector('[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
            submitBtn.disabled = true;
            
            try {
                const formData = new FormData(form);
                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotification('success', data.message || 'Operation completed successfully!');
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    }
                } else {
                    showNotification('error', data.message || 'An error occurred.');
                }
            } catch (error) {
                showNotification('error', 'An error occurred. Please try again.');
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    });
    
    // ============================================
    // Show Notification
    // ============================================
    window.showNotification = function(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <i class="bi ${iconClass} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        const container = document.querySelector('.admin-content');
        container.insertAdjacentHTML('afterbegin', alertHtml);
        
        // Auto-hide after 5 seconds
        setTimeout(function() {
            const alert = container.querySelector('.alert');
            if (alert) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            }
        }, 5000);
    };
    
    // ============================================
    // Sortable Tables
    // ============================================
    const sortableHeaders = document.querySelectorAll('th[data-sort]');
    sortableHeaders.forEach(function(header) {
        header.style.cursor = 'pointer';
        header.addEventListener('click', function() {
            const column = this.getAttribute('data-sort');
            const currentUrl = new URL(window.location.href);
            const currentSort = currentUrl.searchParams.get('sort');
            const currentDirection = currentUrl.searchParams.get('direction');
            
            let newDirection = 'asc';
            if (currentSort === column && currentDirection === 'asc') {
                newDirection = 'desc';
            }
            
            currentUrl.searchParams.set('sort', column);
            currentUrl.searchParams.set('direction', newDirection);
            window.location.href = currentUrl.toString();
        });
    });
    
    // ============================================
    // Print Function
    // ============================================
    window.printPage = function() {
        window.print();
    };
    
    // ============================================
    // Copy to Clipboard
    // ============================================
    window.copyToClipboard = function(text, button) {
        navigator.clipboard.writeText(text).then(function() {
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="bi bi-check"></i> Copied!';
            setTimeout(function() {
                button.innerHTML = originalText;
            }, 2000);
        });
    };
    
});

// ============================================
// Permission Toggle Functions (for RBAC)
// ============================================
function selectAll() {
    document.querySelectorAll('.permission-checkbox').forEach(function(cb) {
        cb.checked = true;
    });
}

function deselectAll() {
    document.querySelectorAll('.permission-checkbox').forEach(function(cb) {
        cb.checked = false;
    });
}

function toggleGroup(groupSlug) {
    const checkboxes = document.querySelectorAll('.group-' + groupSlug);
    const allChecked = Array.from(checkboxes).every(function(cb) {
        return cb.checked;
    });
    checkboxes.forEach(function(cb) {
        cb.checked = !allChecked;
    });
}