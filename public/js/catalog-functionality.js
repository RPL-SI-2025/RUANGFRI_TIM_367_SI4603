/**
 * Catalog Functionality
 * Khusus untuk Katalog Ruangan & Inventaris
 */

document.addEventListener('DOMContentLoaded', function() {
    initializeCatalogSearch();
    initializeCatalogFilters();
    initializeCatalogAlerts();
    initializeCatalogButtons();
    initializeCatalogImages();
});

/**
 * Search functionality
 */
function initializeCatalogSearch() {
    const searchInput = document.getElementById('catalogSearchInput');
    const statusFilter = document.getElementById('catalogStatusFilter');
    const catalogGrid = document.getElementById('catalogGrid');
    const resultsCount = document.getElementById('resultsCount');
    
    if (!searchInput || !catalogGrid) return;
    
    const cards = catalogGrid.querySelectorAll('.catalog-card');
    
    function filterCards() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const statusValue = statusFilter ? statusFilter.value : '';
        let visibleCount = 0;
        
        cards.forEach((card, index) => {
            const name = card.dataset.name || '';
            const description = card.dataset.description || '';
            const status = card.dataset.status || '';
            
            const matchesSearch = !searchTerm || 
                                name.includes(searchTerm) || 
                                description.includes(searchTerm);
            const matchesStatus = !statusValue || status === statusValue;
            
            if (matchesSearch && matchesStatus) {
                showCard(card, index);
                visibleCount++;
            } else {
                hideCard(card);
            }
        });
        if (resultsCount) {
            resultsCount.textContent = visibleCount;
        }
        showEmptyStateIfNeeded(visibleCount);
    }
    
    function showCard(card, index) {
        card.style.display = 'block';
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 50);
    }
    
    function hideCard(card) {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.display = 'none';
        }, 300);
    }
    
    function showEmptyStateIfNeeded(visibleCount) {
        let emptyMessage = document.getElementById('catalogEmptyMessage');
        
        if (visibleCount === 0 && (searchInput.value || (statusFilter && statusFilter.value))) {
            if (!emptyMessage) {
                emptyMessage = createEmptyMessage();
                catalogGrid.parentNode.appendChild(emptyMessage);
            }
            emptyMessage.style.display = 'block';
            catalogGrid.style.display = 'none';
        } else {
            if (emptyMessage) {
                emptyMessage.style.display = 'none';
            }
            catalogGrid.style.display = 'grid';
        }
    }
    
    function createEmptyMessage() {
        const emptyDiv = document.createElement('div');
        emptyDiv.id = 'catalogEmptyMessage';
        emptyDiv.className = 'catalog-empty-state';
        emptyDiv.innerHTML = `
            <div class="catalog-empty-icon">
                <i class="fa fa-search"></i>
            </div>
            <h3 class="catalog-empty-title">Tidak Ada Hasil</h3>
            <p class="catalog-empty-description">
                Tidak ditemukan item yang sesuai dengan pencarian atau filter yang dipilih.
            </p>
        `;
        return emptyDiv;
    }
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(filterCards, 300);
    });
    
    if (statusFilter) {
        statusFilter.addEventListener('change', filterCards);
    }
}

/**
 * Filter functionality
 */
function initializeCatalogFilters() {
    const filterSelects = document.querySelectorAll('.catalog-filter-select');
    
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            this.style.borderColor = 'var(--catalog-primary)';
            setTimeout(() => {
                this.style.borderColor = 'var(--catalog-border)';
            }, 1000);
        });
    });
}

/**
 * Alert management
 */
function initializeCatalogAlerts() {
    const alerts = document.querySelectorAll('.catalog-alert');
    
    alerts.forEach(alert => {
        if (alert.classList.contains('catalog-alert-success')) {
            setTimeout(() => {
                fadeOutAlert(alert);
            }, 3000);
        }
        if (alert.classList.contains('catalog-alert-error')) {
            setTimeout(() => {
                fadeOutAlert(alert);
            }, 5000);
        }
    });
    
    function fadeOutAlert(alert) {
        alert.style.opacity = '0';
        alert.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            if (alert.parentNode) {
                alert.parentNode.removeChild(alert);
            }
        }, 300);
    }
}

/**
 * Button interactions
 */
function initializeCatalogButtons() {
    const addToCartButtons = document.querySelectorAll('.catalog-btn-primary:not(:disabled)');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.classList.contains('loading')) {
                e.preventDefault();
                return;
            }
            const originalContent = this.innerHTML;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Menambahkan...';
            this.classList.add('loading');
            this.disabled = true;
            setTimeout(() => {
                if (this.classList.contains('loading')) {
                    this.innerHTML = originalContent;
                    this.classList.remove('loading');
                    this.disabled = false;
                }
            }, 5000);
        });
    });
    const detailButtons = document.querySelectorAll('.catalog-btn-detail');
    
    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });
}

/**
 * Image lazy loading and error handling
 */
function initializeCatalogImages() {
    const images = document.querySelectorAll('.catalog-card-image');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                    this.parentElement.classList.add('loaded');
                });
                
                img.addEventListener('error', function() {
                    this.style.display = 'none';
                    const placeholder = this.parentElement.querySelector('.catalog-card-image-placeholder');
                    if (!placeholder) {
                        const newPlaceholder = document.createElement('div');
                        newPlaceholder.className = 'catalog-card-image-placeholder';
                        newPlaceholder.innerHTML = '<i class="fa fa-image"></i>';
                        this.parentElement.appendChild(newPlaceholder);
                    }
                });
                
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => {
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.3s ease';
        imageObserver.observe(img);
    });
}

/**
 * Utility functions
 */
function showCatalogLoading() {
    const catalogGrid = document.getElementById('catalogGrid');
    if (!catalogGrid) return;
    
    const loadingDiv = document.createElement('div');
    loadingDiv.id = 'catalogLoading';
    loadingDiv.className = 'catalog-loading';
    loadingDiv.innerHTML = `
        <div class="catalog-loading-spinner"></div>
        <div class="catalog-loading-text">Memuat katalog...</div>
    `;
    
    catalogGrid.parentNode.insertBefore(loadingDiv, catalogGrid);
    catalogGrid.style.display = 'none';
}

function hideCatalogLoading() {
    const loadingDiv = document.getElementById('catalogLoading');
    const catalogGrid = document.getElementById('catalogGrid');
    
    if (loadingDiv) {
        loadingDiv.parentNode.removeChild(loadingDiv);
    }
    
    if (catalogGrid) {
        catalogGrid.style.display = 'grid';
    }
}
window.CatalogUtils = {
    showLoading: showCatalogLoading,
    hideLoading: hideCatalogLoading
};