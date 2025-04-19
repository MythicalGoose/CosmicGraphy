document.addEventListener('DOMContentLoaded', function() {
    const cosmicBg = document.querySelector('.cosmic-bg');
    const starCount = 100; //increased from 50 to 100 cuz 50 wasn't enough
    const shootingStarCount = 5;
    
    // Create stars
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

    /* work in progress
    // Create shooting stars \0/
    for (let i = 0; i < shootingStarCount; i++) {
        const shootingStar = document.createElement('div');
        shootingStar.classList.add('shooting-star');
        
        const size = Math.random() * 60 + 40;
        shootingStar.style.width = size + 'px';
        shootingStar.style.height = '2px';
        
        shootingStar.style.left = Math.random() * 100 + '%';
        shootingStar.style.top = Math.random() * 100 + '%';
        
        // Random delays for shooting stars :O
        shootingStar.style.animationDelay = (Math.random() * 15) + 's';
        
        cosmicBg.appendChild(shootingStar);
    }
    */

    /* work in progress
    // Add subtle parallax effect to background
    document.addEventListener('mousemove', function(e) {
        const mouseX = e.clientX / window.innerWidth;
        const mouseY = e.clientY / window.innerHeight;
        
        const stars = document.querySelectorAll('.star');
        stars.forEach(star => {
            const speed = parseFloat(star.style.width) * 0.5;
            const offsetX = (mouseX - 0.5) * speed;
            const offsetY = (mouseY - 0.5) * speed;
            
            star.style.transform = `translate(${offsetX}px, ${offsetY}px)`;
        });
    });
    
    */
    

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