{/* <script> */}
$(document).ready(function () {
    // Initialize Select2
    $(".select2").select2({tags : true});

    // Add Row for Education
    $("#addEducationRow").click(function () {
        $('#educationTable tbody').append(`
            <tr>
                <td><input type="text" name="qualification[]" class="form-control" required></td>
                <td><input type="text" name="institution[]" class="form-control" required></td>
                <td><input type="number" name="gradYear[]" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
            </tr>
        `);
    });

    // Add Row for Work Experience
    $('#addExperienceRow').click(function () {
        $('#experienceTable tbody').append(`
            <tr>
                <td><input type="text" name="jobTitle[]" class="form-control" required></td>
                <td><input type="text" name="companyName[]" class="form-control" required></td>
                <td><input type="text" name="duration[]" class="form-control" required></td>
                <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
            </tr>
        `);
    });

    // Remove Row
    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
    });

    // Fetch Division Data
    $.ajax({
        url: 'https://www.bdapis.com/api/v1.2/divisions',
        method: 'GET',
        success: function (data) {
            data.data.forEach(function (division) {
                $('#division').append(new Option(division.division, division.division));
            });
        }
    });

    // Fetch District Data Based on Division
    $('#division').change(function () {
        const divisionName = $(this).val();
        if (divisionName) {
            $.ajax({
                url: `https://www.bdapis.com/api/v1.2/division/${divisionName}`,
                method: 'GET',
                success: function (data) {
                    $('#district').empty().append('<option value="">Select District</option>');
                    data.data.forEach(function (district) {
                        $('#district').append(new Option(district.district, district.district));
                    });
                }
            });
        } else {
            $('#district').empty().append('<option value="">Select District</option>');
        }
    });
});
{/* </script> */}