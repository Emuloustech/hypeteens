
// HYPETEENS BLOG SEARCH

const searchInput = document.getElementById("blogSearch");

if (searchInput) {

    const articleCards = document.querySelectorAll(".article-card");
    const noResults = document.getElementById("noResults");

    searchInput.addEventListener("input", function () {

        const searchText = searchInput.value.toLowerCase();
        let visibleArticles = 0;

        articleCards.forEach(function (card) {

            const articleText = card.textContent.toLowerCase();

            if (articleText.includes(searchText)) {

                card.style.display = "block";
                visibleArticles++;

            } else {

                card.style.display = "none";

            }

        });

        noResults.hidden = visibleArticles !== 0;

    });

}


/* HYPETEENS CONTACT FORM */

const contactForm = document.getElementById("contactForm");

if (contactForm) {

    contactForm.addEventListener("submit", function(event) {

        event.preventDefault();

        const formMessage = document.getElementById("formMessage");

        formMessage.textContent =
            "Thank you for contacting HYPETEENS! The form is ready for email or database integration.";

        formMessage.style.color = "#237A3B";

        contactForm.reset();

    });

}
