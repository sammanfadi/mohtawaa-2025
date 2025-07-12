document.addEventListener('DOMContentLoaded',function(){
    const header = document.querySelector('.site-header');
    let lastScroll = window.scrollY;
    if(!header) return;
    window.addEventListener('scroll',function(){
        const currentScroll = window.scrollY;
        if(currentScroll > lastScroll && currentScroll > 100){
            header.classList.add('hidden');
        }else{
            header.classList.remove('hidden');
        }
        lastScroll = currentScroll;
    });
});
