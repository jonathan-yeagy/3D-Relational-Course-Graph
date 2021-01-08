<?php
include("includes/dbConnect.php");
?>

<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Course Form</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
</head>
<body>
<?php
//Set Default Variables
$username = "";
$major = "";
$courses = "";

//Execute function by clicking the submit button
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    //Get Variables From Form
    $username = $_REQUEST['txtUsername'];
    $major = $_REQUEST['txtMajorID'];
    $courses = $_REQUEST['courses'];

    //Insert Student into Student Table
    $insertStudent = "INSERT INTO Student (studentUser, idMajor) VALUES ('" . $username . "', '" . $major . "')";
    mysqli_query($link, $insertStudent);

    //Get Student ID From Insert Statement
    $studentID = mysqli_insert_id($link);

    //Execute Foreach statment to get multiple courses into the DB
    foreach ($courses as $course) {
        //Insert Student's Courses into Student_Course Table
        $insertStudent_Course = "INSERT INTO Student_Course (idStudent, idCourse) VALUES ('" . $studentID . "', '" . $course . "')";
        mysqli_query($link, $insertStudent_Course);
    }
} else {
    //Error Statement
    echo "Error";
}
?>
<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <fieldset>
        <legend>Add Major/Courses</legend>
        <p>
            <label>Username
                <input type="text" name="txtUsername">
            </label>
        </p>
        <p>
            <label>Major
                <input type="text" name="txtMajor" id="txtMajor"><br/>
                <input type="hidden" name="txtMajorID" id="txtMajorID">
            </label>
        </p>
        <p>
            <label>Courses
                <input type="text" name="txtCourse" id="txtCourse">
            </label>
        </p>
        <ul id="courseList"></ul>
        <p><input type="submit" name="btnSubmit" value="Submit"></p>
    </fieldset>
</form>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
<script>
    $(function () {
        majorID = "";
        courseID = "";

        $("#txtMajor").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: 'json/major.php',
                    data: request,
                    success: function (data) {
                        var ParsedObject = $.parseJSON(data);
                        response($.map(ParsedObject, function (item) {
                            return {
                                value: item[0],
                                majorID: item[1]
                            };
                        }))
                    }
                });
            },
            select: function (event, ui) {
                if (ui.item) {
                    $("#txtMajor").val(ui.item.value);
                    $("#txtMajorID").val(ui.item.majorID);
                }
                $("#txtMajor").prop("disabled", "true");
            }
        });

        $("#txtCourse").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: 'json/course.php',
                    data: request,
                    success: function (data) {
                        var ParsedObject = $.parseJSON(data);
                        response($.map(ParsedObject, function (item) {
                            return {
                                value: item[0],
                                courseID: item[1]
                            };
                        }))
                    }
                });
            },
            select: function (event, ui) {
                if (ui.item) {
                    $("#txtCourse").val(ui.item.value);
                    courseID = ui.item.courseID;
                    $("#courseList").append("<li><input type='checkbox' name='courses[]' value='" + courseID + "' checked> " + $("#txtCourse").val() + "</li>");

                }
            }
        });

        $("#txtCourse").click(function () {
            $(this).val("");
        });

    });

</script>
</body>
</html>