document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('nav ul li a');
    const content = document.getElementById('content');

    links.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            fetch(link.getAttribute('href'))
                .then(response => response.text())
                .then(html => {
                    content.innerHTML = html;
                });
        });
    });
});
