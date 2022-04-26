$(document).ready(function () {

    const

        // Identifies DOM elements
        input = document.getElementById("myInput"),
        noResults = document.getElementById("no-results"),
        listItems = Array.from(document.querySelectorAll("#myUL li")),

        // Defines a function to get uppercased li text
        getLiUpperText = (li) => {
            const
                a = li.getElementsByTagName("a")[0],
                text = a.textContent || a.innerText
            liUpperText = text.toUpperCase();
            return liUpperText;
        },

        // Defines a function to hide all list items
        hideListItems = () =>
            listItems.forEach((li) => li.classList.add("hidden"));


    // Hides everything initially (using CSS instead of manual styling)
    noResults.classList.add("hidden");
    hideListItems();

    // Calls inputListener on keyup
    input.addEventListener("keyup", inputListener);


    // Defines inputListener
    function inputListener(event) {

        hideListItems(); // Tentatively hides all names
        const inputUpperText = event.target.value.toUpperCase();
        if (inputUpperText === "") {
            return; // Quits early if input is empty
        }
        noResults.classList.remove("hidden"); // Tentatively shows 'no results'

        for (let li of listItems) {
            if (getLiUpperText(li).includes(inputUpperText)) {
                li.classList.remove("hidden"); // Shows item
                noResults.classList.add("hidden"); // Hides 'no results'
            }
        }
    }

});