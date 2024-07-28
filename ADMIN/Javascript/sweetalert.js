function confirmUpdate(policeId, policeEmail, name, rank, policeIdNumber) {
    Swal.fire({
        title: 'Update Confirmation',
        text: "Do you want to update the details?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            showUpdateForm(policeId, policeEmail, name, rank, policeIdNumber);
        }
    });
}

function showUpdateForm(policeId, policeEmail, name, rank, policeIdNumber) {
    document.getElementById('updatePoliceId').value = policeId;
    document.getElementById('updatePoliceEmail').value = policeEmail;
    document.getElementById('updateName').value = name;
    document.getElementById('updateRank').value = rank;
    document.getElementById('updatePoliceIdNumber').value = policeIdNumber;
    document.getElementById('updateFormContainer').style.display = 'block';
    document.getElementById('updateFormContainer').scrollIntoView({ behavior: 'smooth' });
}

function showDeleteAlert(event, policeId) {
    event.preventDefault(); // Prevent the form from submitting immediately

    Swal.fire({
        title: 'Delete Confirmation',
        text: "Are you sure you want to delete this record?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteForm_' + policeId).submit();
        }
    });

    return false; // Prevent the form from submitting the traditional way
}

function closeUpdateForm() {
    document.getElementById('updateFormContainer').style.display = "none";
}

function showEndScheduleAlert(policeId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to end the schedule for this police officer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, end it!'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'End Schedule',
                html: '<input type="datetime-local" id="endDateTime" class="swal2-input" placeholder="End Date and Time">',
                confirmButtonText: 'Submit',
                showCancelButton: true,
                preConfirm: () => {
                    const endDateTime = Swal.getPopup().querySelector('#endDateTime').value;
                    if (!endDateTime) {
                        Swal.showValidationMessage(`Please enter an end date and time`);
                    }
                    return { endDateTime: endDateTime };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const endDateTime = result.value.endDateTime;
                    const form = document.createElement('form');
                    form.method = 'post';
                    form.action = 'end_schedule.php';

                    const policeIdField = document.createElement('input');
                    policeIdField.type = 'hidden';
                    policeIdField.name = 'police_id';
                    policeIdField.value = policeId;

                    const endDateField = document.createElement('input');
                    endDateField.type = 'hidden';
                    endDateField.name = 'end_date';
                    endDateField.value = endDateTime;

                    form.appendChild(policeIdField);
                    form.appendChild(endDateField);

                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    });
}
