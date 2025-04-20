document.addEventListener('DOMContentLoaded', function() {
    const cosmicBg = document.querySelector('.cosmic-bg');
    const starCount = 100;
    const shootingStarCount = 5;
    
    // Create the stars
    for (let i = 0; i < starCount; i++) {
        const star = document.createElement('div');
        star.classList.add('star');
        
        // Star sizes
        const size = Math.random() * 3 + 0.5;
        star.style.width = size + 'px';
        star.style.height = size + 'px';
        
        star.style.left = Math.random() * 100 + '%';
        star.style.top = Math.random() * 100 + '%';
        
        // Animation timing
        star.style.animationDelay = Math.random() * 6 + 's';
        star.style.animationDuration = Math.random() * 4 + 2 + 's';
        
        cosmicBg.appendChild(star);
    }


    // shooting stars!!!
    for (let i = 0; i < shootingStarCount; i++) {
        const shootingStar = document.createElement('div');
        shootingStar.classList.add('shooting-star');
        
        // Star sizes
        const size = Math.random() * 10 + 5;
        shootingStar.style.width = size + 'px';
        shootingStar.style.height = size / 2 + 'px';
    
        shootingStar.style.left = Math.random() * 100 + '%';
        shootingStar.style.top = Math.random() * 100 + '%';

        // Animation timing
        shootingStar.style.animationDelay = (Math.random() * 20) + 's';

        shootingStar.style.animationDuration = (Math.random() * 5 + 5) + 's';

        cosmicBg.appendChild(shootingStar);
    }
    
    // Hover effect to table rows (love it)
    const tableRows = document.querySelectorAll('.t-row');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            const cell = row.querySelector('.color');
            if (cell) {
                if (cell.classList.contains('good')) {
                    cell.style.boxShadow = '0 0 15px rgba(46, 204, 113, 0.9)';
                } else if (cell.classList.contains('medium')) {
                    cell.style.boxShadow = '0 0 15px rgba(243, 156, 18, 0.9)';
                } else if (cell.classList.contains('bad')) {
                    cell.style.boxShadow = '0 0 15px rgba(231, 76, 60, 0.9)';
                }
            }
        });
        
        row.addEventListener('mouseleave', function() {
            const cell = row.querySelector('.color');
            if (cell) {
                if (cell.classList.contains('good')) {
                    cell.style.boxShadow = '0 0 8px rgba(46, 204, 113, 0.6)';
                } else if (cell.classList.contains('medium')) {
                    cell.style.boxShadow = '0 0 8px rgba(243, 156, 18, 0.6)';
                } else if (cell.classList.contains('bad')) {
                    cell.style.boxShadow = '0 0 8px rgba(231, 76, 60, 0.6)';
                }
            }
        });
    });
});
