export default (elem) => {
    let startAnimation = null;
    const step = timestamp => {
        if (!startAnimation) startAnimation = timestamp;
        let progress = timestamp - startAnimation;
        elem.style.opacity = progress/500;
        if (progress < 500) {
            window.requestAnimationFrame(step);
        }
    }
    window.requestAnimationFrame(step);
}
