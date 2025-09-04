// いいねボタンの機能
document.addEventListener('DOMContentLoaded', function() {
    const likeButtons = document.querySelectorAll('.like-btn');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const isLiked = this.getAttribute('data-liked') === 'true';
            const countElement = this.parentElement.querySelector('.like-count');
            const imgElement = this.querySelector('img');
            let currentCount = parseInt(this.getAttribute('data-count'));
            
            if (isLiked) {
                // いいね解除
                this.setAttribute('data-liked', 'false');
                currentCount--;
                imgElement.src = '/images/heart_white.png';
            } else {
                // いいね追加
                this.setAttribute('data-liked', 'true');
                currentCount++;
                imgElement.src = '/images/heart_red.png';
            }
            
            // カウントを更新
            this.setAttribute('data-count', currentCount);
            countElement.textContent = currentCount;
        });
    });
});
