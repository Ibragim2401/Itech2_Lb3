<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work</title>
    <style>
        header 
        {
            background-color:antiquewhite ;
            padding: 1rem;
            text-align: center;
            color: black;
        }

        .container
        {
            display: flex;
            justify-content: space-between;
            border: 3px solid #ccc;
            padding: 20px;
            margin-top: 30px;
        }

        .tasks
        {
            width: 500px;
            height: 300px;
            background-color: antiquewhite;
            margin: 10px;
            font-size: 20px;
            text-align: center;
        }

        .button {
            padding: 10px 20px;
            background-color: chocolate;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <h1>Лабораторна робота №3</h1>
    </header>
    <div class="container">
        <div class="tasks" id="workersTask">
            <p style="padding-top: 20px;">The number of subordinates of each chief</p>
            <label for="name">Chief name: </label>
            <select id="workersChiefName" name="chief_name">
                <option value="Jobs">Jobs</option>
                <option value="Wozniak">Wozniak</option>
                <option value="Gates">Gates</option>
                <option value="Stark">Stark</option>
                <option value="Brown">Brown</option>
            </select>
            <button class="button" onclick="getWorkersData()">Enter</button>
            <div id="workersResult"></div>
        </div>
        <div class="tasks" id="totalTimeTask">
            <p style="padding-top: 20px;">Total time spent on the selected project (in days)</p>
            <label for="project">Project name: </label>
            <select id="totalTimeProjectName" name="project_name">
                <option value="Project_1, Hospital">Project_1, Hospital</option>
                <option value="Project_2, Bank">Project_2, Bank</option>
                <option value="Project_3, Police">Project_3, Police</option>
                <option value="Project_4, Government">Project_4, Government</option>
                <option value="Project_5, App">Project_5, App</option>
                <option value="Project_6">Project_6</option>
                <option value="Project_7">Project_7</option>
            </select>
            <button class="button" onclick="getTotalTimeData()">Enter</button>
            <div id="totalTimeResult"></div>
        </div>
        <div class="tasks" id="informationTask">
            <p style="padding: 20px 10px;">Infos on completed tasks for the specified project 
                on the selected date</p>
            <label for="project">Project name:</label>
            <select id="informationProjectName" name="project_name">
                <option value="Project_1, Hospital">Project_1, Hospital</option>
                <option value="Project_2, Bank">Project_2, Bank</option>
                <option value="Project_3, Police">Project_3, Police</option>
                <option value="Project_4, Government">Project_4, Government</option>
                <option value="Project_5, App">Project_5, App</option>
                <option value="Project_6">Project_6</option>
                <option value="Project_7">Project_7</option>
            </select><br>
            <label for="dateInput">Enter date:</label>
            <input type="date" id="informationDateInput" name="selected_date"><br><br>
            <button class="button" onclick="getInformationData()">Enter</button>
            <div id="informationResult"></div>
        </div>
    </div>

    <script>
        function getWorkersData() {
    var chiefName = document.getElementById("workersChiefName").value;
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var response = JSON.parse(xhr.responseText);
            var formattedText = formatWorkersData(response);
            document.getElementById("workersResult").innerHTML = formattedText;
        }
    };
    xhr.open("GET", "workers.php?chief_name=" + chiefName, true);
    xhr.send();
}

function formatWorkersData(data) {
    var formattedText = "";
    for (var i = 0; i < data.length; i++) {
        formattedText += "Name: " + data[i].name + "<br>";
    }
    return formattedText;
}


        function getTotalTimeData() {
            var projectName = document.getElementById("totalTimeProjectName").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var xmlDoc = xhr.responseXML;
                    var dayNodes = xmlDoc.getElementsByTagName("day");
                    var totalTime = 0;
                    for (var i = 0; i < dayNodes.length; i++) {
                        var difference = parseInt(dayNodes[i].getElementsByTagName("difference")[0].childNodes[0].nodeValue);
                        totalTime += difference;
                    }
                    document.getElementById("totalTimeResult").innerHTML = "Total time spent: " + totalTime + " days";
                }
            };
            xhr.open("GET", "totaltime.php?project_name=" + projectName, true);
            xhr.send();
        }

        function getInformationData() {
            var projectName = document.getElementById("informationProjectName").value;
            var selectedDate = document.getElementById("informationDateInput").value;
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("informationResult").innerText = xhr.responseText;
                }
            };
            xhr.open("GET", "information.php?project_name=" + projectName + "&selected_date=" + selectedDate, true);
            xhr.send();
        }
    </script>
</body>

</html>
