document.addEventListener('DOMContentLoaded', function() {
    const cosmicBg = document.querySelector('.cosmic-bg');
    const starCount = 50;
    
    for (let i = 0; i < starCount; i++) {
        const star = document.createElement('div');
        star.classList.add('star');
        
        const size = Math.random() * 2 + 1;
        star.style.width = size + 'px';
        star.style.height = size + 'px';
        
        star.style.left = Math.random() * 100 + '%';
        star.style.top = Math.random() * 100 + '%';
        
        star.style.animationDelay = Math.random() * 4 + 's';
        
        cosmicBg.appendChild(star);
    }
});