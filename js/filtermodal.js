document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('#filter-modal .btn-outline-dark');
    const propertyCards = document.querySelectorAll('.property-card');
    const sortButtons = document.querySelectorAll('.filter-bar .col-auto');
    const filterModal = new bootstrap.Modal(document.getElementById('filter-modal'), { backdrop: 'static', keyboard: false });

    // Filter by gender
    filterButtons.forEach(button => {
        button.addEventListener('click', function () {
            filterButtons.forEach(btn => btn.classList.remove('btn-active'));
            button.classList.add('btn-active');

            const filter = button.textContent.trim().toLowerCase();

            propertyCards.forEach(card => {
                const genderIcon = card.querySelector('.property-gender img').src;

                // Show or hide property cards based on the selected filter
                if (filter === 'no filter') {
                    card.style.display = 'flex';
                } else if (filter === 'male' && genderIcon.includes('male.png')) {
                    card.style.display = 'flex';
                } else if (filter === 'female' && genderIcon.includes('female.png')) {
                    card.style.display = 'flex';
                } else if (filter === 'unisex' && genderIcon.includes('unisex.png')) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });

            filterModal.show(); // Ensure the modal stays open
        });
    });

    // Sort by rent
    sortButtons.forEach(button => {
        button.addEventListener('click', function () {
            const sortType = button.textContent.trim().toLowerCase();

            const sortedCards = Array.from(propertyCards).sort((a, b) => {
                const rentA = parseInt(a.querySelector('.rent').textContent.replace(/[^0-9]/g, ''));
                const rentB = parseInt(b.querySelector('.rent').textContent.replace(/[^0-9]/g, ''));
                
                if (sortType.includes('highest rent')) {
                    return rentB - rentA; // Descending order
                } else if (sortType.includes('lowest rent')) {
                    return rentA - rentB; // Ascending order
                }
            });

            const container = document.querySelector('.page-container');
            container.innerHTML = ''; // Clear the container
            sortedCards.forEach(card => {
                container.appendChild(card); // Append sorted cards
            });

            filterModal.show(); // Ensure the modal stays open
        });
    });

    // Prevent modal from closing
    document.getElementById('filter-modal').addEventListener('hidden.bs.modal', function (event) {
        event.preventDefault();
        filterModal.show();
    });
});
