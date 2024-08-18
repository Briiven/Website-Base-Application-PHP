<script>
    function updateLabel(inputId) {
        const input = document.getElementById(inputId);
        const label = input.nextElementSibling;
        const fileName = input.files[0].name;
        label.innerText = fileName;
    }

    // Add event listeners to file inputs to update labels
    document.getElementById("signatureInput").addEventListener("change", function() {
        updateLabel("signatureInput");
    });
    document.getElementById("pictureInput").addEventListener("change", function() {
        updateLabel("pictureInput");
    });
    document.getElementById("cocInput").addEventListener("change", function() {
        updateLabel("cocInput");
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize current section index
        var currentSectionIndex = 0;
        var sections = document.querySelectorAll('section'); // Get all sections

        // Function to show current section
        function showSection(index) {
            // Hide all sections
            sections.forEach(function(section) {
                section.style.display = 'none';
            });
            // Show current section
            sections[index].style.display = 'block';
        }

        // Function to handle next button click
        function handleNextButtonClick() {
            if (currentSectionIndex < sections.length - 1) {
                currentSectionIndex++;
                showSection(currentSectionIndex);
            }
        }

        // Function to handle previous button click
        function handlePreviousButtonClick() {
            if (currentSectionIndex > 0) {
                currentSectionIndex--;
                showSection(currentSectionIndex);
            }
        }

        function handlePreviousButtonClick1() {
            if (currentSectionIndex >= 6) {
                currentSectionIndex -= 6; // Move back six sections
                showSection(currentSectionIndex);
            } else {
                currentSectionIndex = 0; // If there are less than six sections, go to the first one
                showSection(currentSectionIndex);
            }
        }

        // Add event listeners to next and previous buttons
        document.getElementById('personal_info_next').addEventListener('click', handleNextButtonClick);
        document.getElementById('educational_background_prev').addEventListener('click', handlePreviousButtonClick);
        document.getElementById('educational_background_next').addEventListener('click', handleNextButtonClick);
        document.getElementById('admission_dates_prev').addEventListener('click', handlePreviousButtonClick);
        document.getElementById('admission_dates_next').addEventListener('click', handleNextButtonClick);
        document.getElementById('subjects_prev').addEventListener('click', handlePreviousButtonClick);
        document.getElementById('subjects_next').addEventListener('click', handleNextButtonClick);
        document.getElementById('latin_honors_prev').addEventListener('click', handlePreviousButtonClick);
        document.getElementById('latin_honors_next').addEventListener('click', handleNextButtonClick);
        document.getElementById('upload_files_prev').addEventListener('click', handlePreviousButtonClick);
        document.getElementById('upload_files_next').addEventListener('click', handleNextButtonClick);
        document.getElementById('submission_prev').addEventListener('click', handlePreviousButtonClick1);

        // Show initial section
        showSection(currentSectionIndex);

        // Disable personal_info_next button initially
        // document.getElementById('personal_info_next').disabled = true;
        // document.getElementById('educational_background_next').disabled = true;
        // document.getElementById('admission_dates_next').disabled = true;
        // document.getElementById('latin_honors_next').disabled = true;
        // document.getElementById('upload_files_next').disabled = true;

        // Validation for Personal Information
        var birthplaceInput = document.querySelector('input[name="birthplace"]');
        birthplaceInput.addEventListener('input', function() {
            validateBirthplace(this);
        });

        function validateBirthplace(input) {
            var birthplace = input.value.trim();
            var birthplaceRegex = /^[a-zA-Z0-9,\s.]+$/;
            if (birthplace === '') {
                showError(input, 'Birthplace is required');
                enableDisableNextButton(false);
                return false;
            } else if (!birthplaceRegex.test(birthplace)) {
                showError(input, 'Invalid birthplace');
                enableDisableNextButton(false);
                return false;
            } else {
                showSuccess(input);
                enableDisableNextButton(true);
                return true;
            }
        }

        // Validation for Educational Background
        var shsInput = document.querySelector('input[name="shs"]');
        var shsAddressInput = document.querySelector('input[name="shsaddress"]');
        var oscInput = document.querySelector('input[name="osc"]');
        var oscAddressInput = document.querySelector('input[name="oscaddress"]');
        var shsYearInput = document.querySelector('input[name="shsyear"]');
        var oscYearInput = document.querySelector('input[name="oscyear"]');

        shsInput.addEventListener('input', function() {
            validateInput(this, /^[a-zA-Z0-9,\s.]+$/, 'Senior Highschool is required');
        });

        shsAddressInput.addEventListener('input', function() {
            validateInput(this, /^[a-zA-Z0-9,\s.]+$/, 'Senior Highschool Address is required');
        });

        shsYearInput.addEventListener('input', function() {
            validateYearInput(this, /^[0-9]{4}-[0-9]{4}$/, 'Year is required');
        });

        oscInput.addEventListener('input', function() {
            validateOptionalInput(this, /^[a-zA-Z0-9,\s.]+$/, 'Invalid Input');
        });

        oscAddressInput.addEventListener('input', function() {
            validateOptionalInput(this, /^[a-zA-Z0-9,\s.]+$/, 'Invalid Input');
        });

        oscYearInput.addEventListener('input', function() {
            validateOptionalYearInput(this, /^[0-9]{4}-[0-9]{4}$/, 'Year is required');
        });

        function validateInput(input, regex, errorMessage) {
            var value = input.value.trim();

            if (value === '') {
                showError(input, errorMessage);
                enableDisableNextButton1(false);
                return false;
            } else if (!regex.test(value)) {
                showError(input, 'Invalid Input');
                enableDisableNextButton1(false);
                return false;
            } else {
                showSuccess(input);
                checkAllRequiredFields();
                return true;
            }
        }

        function validateYearInput(input, regex, errorMessage) {
            var value = input.value.trim();

            if (value === '') {
                showError(input, errorMessage);
                enableDisableNextButton1(false);
                return false;
            } else if (!regex.test(value)) {
                showError(input, 'Invalid Year Format');
                enableDisableNextButton1(false);
                return false;
            } else {
                var years = value.split('-').map(Number);
                if (years[1] <= years[0]) {
                    showError(input, 'Invalid Year Range');
                    enableDisableNextButton1(false);
                    return false;
                }
                showSuccess(input);
                checkAllRequiredFields();
                return true;
            }
        }

        function validateOptionalInput(input, regex, errorMessage) {
            var value = input.value.trim();

            if (value === '') {
                clearMessages(input);
                checkAllRequiredFields(); // Update button status
            } else if (!regex.test(value)) {
                showError(input, errorMessage);
                enableDisableNextButton1(false);
                return false;
            } else {
                showSuccess(input);
                checkAllRequiredFields();
                return true;
            }
        }

        function validateOptionalYearInput(input, regex, errorMessage) {
            var value = input.value.trim();

            if (value === '') {
                clearMessages(input);
                checkAllRequiredFields(); // Update button status
            } else if (!regex.test(value)) {
                showError(input, errorMessage);
                enableDisableNextButton1(false);
                return false;
            } else {
                var years = value.split('-').map(Number);
                if (years[1] <= years[0]) {
                    showError(input, 'Invalid Year Range');
                    enableDisableNextButton1(false);
                    return false;
                }
                showSuccess(input);
                checkAllRequiredFields();
                return true;
            }
        }

        function checkAllRequiredFields() {
            // Check if all required fields are valid
            if (shsInput.value.trim() !== '' && shsAddressInput.value.trim() !== '' &&
                /^[a-zA-Z0-9,\s.]+$/.test(shsInput.value.trim()) &&
                /^[a-zA-Z0-9,\s.]+$/.test(shsAddressInput.value.trim()) &&
                (shsYearInput.value.trim() !== '' && /^[0-9]{4}-[0-9]{4}$/.test(shsYearInput.value.trim()))) {
                enableDisableNextButton1(true);
            }
        }


        // Validation for Admission Dates
        var admissiondateInput = document.querySelector('input[name="admissiondate"]');
        var onefirstInput = document.querySelector('input[name="onefirst"]');
        var onesecondInput = document.querySelector('input[name="onesecond"]');
        var twofirstInput = document.querySelector('input[name="twofirst"]');
        var twosecondInput = document.querySelector('input[name="twosecond"]');
        var threefirstInput = document.querySelector('input[name="threefirst"]');
        var threesecondInput = document.querySelector('input[name="threesecond"]');
        var fourfirstInput = document.querySelector('input[name="fourfirst"]');
        var foursecondInput = document.querySelector('input[name="foursecond"]');
        var onesummerInput = document.querySelector('input[name="onesummer"]');
        var twosummerInput = document.querySelector('input[name="twosummer"]');
        var threesummerInput = document.querySelector('input[name="threesummer"]');
        var foursummerInput = document.querySelector('input[name="foursummer"]');
        var fivefirstInput = document.querySelector('input[name="fivefirst"]');
        var fivesecondInput = document.querySelector('input[name="fivesecond"]');
        var fivesummerInput = document.querySelector('input[name="fivesummer"]');
        var sixfirstInput = document.querySelector('input[name="sixfirst"]');
        var sixsecondInput = document.querySelector('input[name="sixsecond"]');
        var sixsummerInput = document.querySelector('input[name="sixsummer"]');

        admissiondateInput.addEventListener('input', function() {
            validateInput2(this, /^[a-zA-Z0-9,\s]+$/, 'Admission Date is required');
        });

        onefirstInput.addEventListener('input', function() {
            validateYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Year is required');
        });

        onesecondInput.addEventListener('input', function() {
            validateYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Year is required');
        });

        twofirstInput.addEventListener('input', function() {
            validateYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Year is required');
        });

        twosecondInput.addEventListener('input', function() {
            validateYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Year is required');
        });

        threefirstInput.addEventListener('input', function() {
            validateYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Year is required');
        });

        threesecondInput.addEventListener('input', function() {
            validateYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Year is required');
        });

        fourfirstInput.addEventListener('input', function() {
            validateYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Year is required');
        });

        foursecondInput.addEventListener('input', function() {
            validateYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Year is required');
        });

        onesummerInput.addEventListener('input', function() {
            validateOptionalYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Invalid Year Format');
        });

        twosummerInput.addEventListener('input', function() {
            validateOptionalYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Invalid Year Format');
        });

        threesummerInput.addEventListener('input', function() {
            validateOptionalYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Invalid Year Format');
        });

        foursummerInput.addEventListener('input', function() {
            validateOptionalYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Invalid Year Format');
        });

        fivefirstInput.addEventListener('input', function() {
            validateOptionalYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Invalid Year Format');
        });

        fivesecondInput.addEventListener('input', function() {
            validateOptionalYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Invalid Year Format');
        });

        fivesummerInput.addEventListener('input', function() {
            validateOptionalYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Invalid Year Format');
        });

        sixfirstInput.addEventListener('input', function() {
            validateOptionalYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Invalid Year Format');
        });

        sixsecondInput.addEventListener('input', function() {
            validateOptionalYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Invalid Year Format');
        });

        sixsummerInput.addEventListener('input', function() {
            validateOptionalYearInput2(this, /^[0-9]{4}-[0-9]{4}$/, 'Invalid Year Format');
        });


        function validateInput2(input, regex, errorMessage) {
            var value = input.value.trim();

            if (value === '') {
                showError(input, errorMessage);
                enableDisableNextButton2(false);
                return false;
            } else if (!regex.test(value)) {
                showError(input, 'Invalid Input');
                enableDisableNextButton2(false);
                return false;
            } else {
                showSuccess(input);
                checkAllRequiredFields2();
                return true;
            }
        }

        function validateYearInput2(input, regex, errorMessage) {
            var value = input.value.trim();

            if (value === '') {
                showError(input, errorMessage);
                enableDisableNextButton2(false);
                return false;
            } else if (!/^\d{4}-\d{4}$/.test(value)) {
                showError(input, 'Invalid Year Format');
                enableDisableNextButton2(false);
                return false;
            } else {
                var years = value.split('-').map(Number);
                if (years[1] <= years[0]) {
                    showError(input, 'Invalid Year Range');
                    enableDisableNextButton2(false);
                    return false;
                }
                showSuccess(input);
                checkAllRequiredFields2();
                return true;
            }
        }

        function validateOptionalYearInput2(input, regex, errorMessage) {
            var value = input.value.trim();

            if (value === '') {
                clearMessages(input);
                checkAllRequiredFields2(); // Update button status
            } else if (!regex.test(value)) {
                showError(input, errorMessage);
                enableDisableNextButton2(false);
                return false;
            } else {
                var years = value.split('-').map(Number);
                if (years[1] <= years[0]) {
                    showError(input, 'Invalid Year Range');
                    enableDisableNextButton2(false);
                    return false;
                }
                showSuccess(input);
                checkAllRequiredFields2();
                return true;
            }
        }

        function checkAllRequiredFields2() {
            // Check if all required fields are valid
            if (admissiondateInput.value.trim() !== '' &&
                /^[a-zA-Z0-9,\s]+$/.test(admissiondateInput.value.trim()) &&
                (onefirstInput.value.trim() !== '' && /^[0-9]{4}-[0-9]{4}$/.test(onefirstInput.value.trim())) &&
                (onesecondInput.value.trim() !== '' && /^[0-9]{4}-[0-9]{4}$/.test(onesecondInput.value.trim())) &&
                (twofirstInput.value.trim() !== '' && /^[0-9]{4}-[0-9]{4}$/.test(twofirstInput.value.trim())) &&
                (twosecondInput.value.trim() !== '' && /^[0-9]{4}-[0-9]{4}$/.test(twosecondInput.value.trim())) &&
                (threefirstInput.value.trim() !== '' && /^[0-9]{4}-[0-9]{4}$/.test(threefirstInput.value.trim())) &&
                (threesecondInput.value.trim() !== '' && /^[0-9]{4}-[0-9]{4}$/.test(threesecondInput.value.trim())) &&
                (fourfirstInput.value.trim() !== '' && /^[0-9]{4}-[0-9]{4}$/.test(fourfirstInput.value.trim())) &&
                (foursecondInput.value.trim() !== '' && /^[0-9]{4}-[0-9]{4}$/.test(foursecondInput.value.trim()))) {
                enableDisableNextButton2(true);
            }
        }

        // Validation for Enrolled Subjects
        var suboneInput = document.querySelector('input[name="subone"]');
        var subtwoInput = document.querySelector('input[name="subtwo"]');
        var subthreeInput = document.querySelector('input[name="subthree"]');
        var subfourInput = document.querySelector('input[name="subfour"]');

        suboneInput.addEventListener('input', function() {
            if (this.value.trim() === '') {
                clearMessages(this);
            } else {
                validateInputSubjects(this);
            }
        });

        subtwoInput.addEventListener('input', function() {
            if (this.value.trim() === '') {
                clearMessages(this);
            } else {
                validateInputSubjects(this);
            }
        });

        subthreeInput.addEventListener('input', function() {
            if (this.value.trim() === '') {
                clearMessages(this);
            } else {
                validateInputSubjects(this);
            }
        });

        subfourInput.addEventListener('input', function() {
            if (this.value.trim() === '') {
                clearMessages(this);
            } else {
                validateInputSubjects(this);
            }
        });

        function validateInputSubjects(input, regex, errorMessage) {
            var value = input.value.trim();

            if (value === '') {
                showError(input, errorMessage);
                enableDisableNextButton3(false);
                return false;
            } else if (!/^[a-zA-Z0-9\- ]+$/.test(value)) {
                showError(input, 'Invalid Subject Input');
                enableDisableNextButton3(false);
                return false;
            } else {
                showSuccess(input);
                checkAllSubjects();
                return true;
            }
        }

        function checkAllSubjects() {
            if ((suboneInput.value.trim() === '' || /^[a-zA-Z0-9\- ]+$/.test(suboneInput.value.trim())) ||
                (subtwoInput.value.trim() === '' || /^[a-zA-Z0-9\- ]+$/.test(subtwoInput.value.trim())) ||
                (subthreeInput.value.trim() === '' || /^[a-zA-Z0-9\- ]+$/.test(subthreeInput.value.trim())) ||
                (subfourInput.value.trim() === '' || /^[a-zA-Z0-9\- ]+$/.test(subfourInput.value.trim()))) {
                enableDisableNextButton3(true);
            }
        }

        // Validation for Subject Units
        var unitoneInput = document.querySelector('select[name="unitone"]');
        var unittwoInput = document.querySelector('select[name="unittwo"]');
        var unitthreeInput = document.querySelector('select[name="unitthree"]');
        var unitfourInput = document.querySelector('select[name="unitfour"]');


        unitoneInput.addEventListener('change', function() {
            if (this.value.trim() === '') {
                clearMessage(this);
            } else {
                validateUnit(this);
            }
        });

        unittwoInput.addEventListener('change', function() {
            if (this.value.trim() === '') {
                clearMessage(this);
            } else {
                validateUnit(this);
            }
        });

        unitthreeInput.addEventListener('change', function() {
            if (this.value.trim() === '') {
                clearMessage(this);
            } else {
                validateUnit(this);
            }
        });

        unitfourInput.addEventListener('change', function() {
            if (this.value.trim() === '') {
                clearMessage(this);
            } else {
                validateUnit(this);
            }
        });

        function validateUnit(input, errorMessage) {
            var value = input.value.trim();

            if (value === '') {
                showError(input, errorMessage);
                enableDisableNextButton3(false);
                return false;
            } else {
                showSuccess(input);
                return true;
            }
        }

        // Validation for Latin Honors
        var appType = document.querySelector('select[name="apptype"]');
        var lowestGrade = document.querySelector('select[name="lowestgrade"]');
        var transfereeLowest = document.querySelector('select[name="transfereelowest"]');

        appType.addEventListener('change', function() {
            validateSelect(this, 'Selection is required');
        });

        lowestGrade.addEventListener('change', function() {
            if (this.value.trim() === '') {
                clearMessages(this);
            } else {
                validateSelect(this);
            }
        });

        transfereeLowest.addEventListener('change', function() {
            if (this.value.trim() === '') {
                clearMessages(this);
            } else {
                validateSelect(this);
            }
        });

        function validateSelect(input, errorMessage) {
            var value = input.value.trim();

            if (value === '') {
                showError(input, errorMessage);
                enableDisableNextButton4(false);
                return false;
            } else {
                showSuccess(input);
                checkRequiredFields();
                return true;
            }
        }

        function checkRequiredFields() {
            // Check if all required fields are valid
            if (appType.value.trim() !== '') {
                enableDisableNextButton4(true);
            }
        }

        // Validation for File Upload
        var signatureInput = document.querySelector('input[name="signature"]');
        var pictureInput = document.querySelector('input[name="picture"]');
        var cocInput = document.querySelector('input[name="coc"]');

        signatureInput.addEventListener('change', function() {
            validateUpload(this, 'Signature is required');
        });

        pictureInput.addEventListener('change', function() {
            validateUpload(this, '2x2 Picture is required');
        });

        cocInput.addEventListener('change', function() {
            validateUpload(this, 'Checklist of Courses is required');
        });

        function validateUpload(input, errorMessage) {
            var value = input.value.trim();

            if (value === '') {
                showError1(input, errorMessage);
                enableDisableNextButton5(false);
                return false;
            } else {
                showSuccess1(input);
                checkUploadFields();
                return true;
            }
        }

        function checkUploadFields() {
            // Check if all required fields are valid
            if (signatureInput.classList.contains('is-valid') && pictureInput.classList.contains('is-valid') && cocInput.classList.contains('is-valid')) {
                enableDisableNextButton5(true);
            }
        }


        function clearMessage(input) {
            // Clear error or success messages
            input.classList.remove('showError');
            input.classList.remove('showSuccess');
            input.classList.remove('is-invalid'); // Also removing 'is-invalid' class
            input.classList.remove('is-valid'); // Also removing 'is-valid' class
        }

        // Function to clear error or success messages
        function clearMessages(input) {
            // Clear error or success messages
            input.classList.remove('showError');
            input.classList.remove('showSuccess');
            input.classList.remove('is-invalid'); // Also removing 'is-invalid' class
            input.classList.remove('is-valid'); // Also removing 'is-valid' class
            input.nextElementSibling.textContent = '';
        }

        // Function to display error message
        function showError(input, message) {
            input.classList.add('is-invalid');
            var errorElement = input.parentElement.querySelector('.invalid-feedback');
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.classList.add('invalid-feedback');
                input.parentElement.appendChild(errorElement);
            }
            errorElement.innerText = message;
        }

        // Function to remove error message
        function showSuccess(input) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            var errorElement = input.parentElement.querySelector('.invalid-feedback');
            if (errorElement) {
                errorElement.innerText = '';
            }
        }

        // Function to display error message
        function showError1(input, message) {
            input.classList.add('is-invalid');
            let errorElement = input.parentElement.querySelector('.invalid-feedback');
            if (!errorElement) {
                errorElement = document.createElement('div');
                errorElement.classList.add('invalid-feedback');
                input.parentElement.appendChild(errorElement);
            }
            errorElement.innerText = message;
        }

        // Function to remove error message
        function showSuccess1(input) {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
            const label = input.parentElement.querySelector('.custom-file-label');
            const fileName = input.files[0].name;
            label.innerHTML = '<span class="file-name">' + fileName + '</span><span class="fa fa-check text-success icon-right"></span>';
        }


        // Function to enable or disable personal_info_next button
        function enableDisableNextButton(enabled) {
            document.getElementById('personal_info_next').disabled = !enabled;
        }

        function enableDisableNextButton1(enabled) {
            document.getElementById('educational_background_next').disabled = !enabled;
        }

        function enableDisableNextButton2(enabled) {
            document.getElementById('admission_dates_next').disabled = !enabled;
        }

        function enableDisableNextButton3(enabled) {
            document.getElementById('subjects_next').disabled = !enabled;
        }

        function enableDisableNextButton4(enabled) {
            document.getElementById('latin_honors_next').disabled = !enabled;
        }

        function enableDisableNextButton5(enabled) {
            document.getElementById('upload_files_next').disabled = !enabled;
        }
    });
</script>