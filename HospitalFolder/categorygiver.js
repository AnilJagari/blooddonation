const data = {
    bloodgroup: ["All", "O+", "O-", "A+", "A-", "B+", "B-", "AB+", "AB-"],
    category: ["All", "A", "B", "C"],
    age: ["All", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30", "31", "32", "33", "34", "35", "36", "37", "38", "39", "40", "41", "42", "43", "44", "45"],
    gender: ["All", "Male", "Female", "Other"]
};

// Update radio buttons based on selected filter
function updateRadioButtons(selectedItem) {
    const radioGroup = document.getElementById('radio-group');
    radioGroup.innerHTML = ''; // Clear previous radio buttons

    data[selectedItem].forEach(item => {
        const label = document.createElement('label');
        label.classList.add('radio-label');

        const input = document.createElement('input');
        input.type = 'radio';
        input.name = selectedItem;
        input.value = item;
        input.classList.add('radio-input');
        if (item === "All") input.checked = true; // Default selection

        // Add event listener for change event
        input.addEventListener('change', () => fetchDonors(selectedItem, item));

        label.appendChild(input);
        label.appendChild(document.createTextNode(item));
        radioGroup.appendChild(label);
    });
}

// Fetch donors based on selected filter and value
function fetchDonors(filterType, filterValue) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'categorygiver.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById('donor-table').innerHTML = xhr.responseText;
        }
    };

    // Encode the filter value to handle special characters like '+'
    xhr.send(`filterType=${filterType}&filterValue=${encodeURIComponent(filterValue)}`);
}

// Event listener for filter change
document.getElementById('sort').addEventListener('change', event => {
    const selectedItem = event.target.value;
    updateRadioButtons(selectedItem);
    fetchDonors(selectedItem, "All"); // Fetch all data initially
});

// Initialize with default selection (Blood Group)
updateRadioButtons('bloodgroup');
fetchDonors('bloodgroup', 'All');
