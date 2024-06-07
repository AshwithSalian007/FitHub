<div class="ad-sidebar-main-container">
    <h3><a href="index.php">Dashboard</a></h3>
    <ul>
        <div class="dropdown">
            <div class="dropdown-btn">Manage Muscle Group</div>
            <ul class="dropdown-content">
                <li><a href="addMuscleGroup.php">Add Muscle Group</a></li>
                <li><a href="viewMuscleGroups.php">Existing Muscle Group</a></li>
            </ul>
        </div>

        <div class="dropdown">
            <div class="dropdown-btn">Manage Exercise</div>
            <ul id="dd" class="dropdown-content">
                <li><a href="addExercise.php">Add Exercise</a></li>
                <li><a href="viewExercises.php">Existing Exercise</a></li>
            </ul>
        </div>
        <div class="navigation-navigate">
            <a href="manageUser.php">Manage User</a>
        </div>
        <div class="navigation-navigate">
            <a href="viewContactUs.php">Contact Messages</a>
        </div>
        <div class="navigation-navigate">
            <a href="logout.php">Logout</a>
        </div>
    </ul>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelector(".ad-main-content-container").style =
            "margin-left: " +
            document.querySelector(".ad-sidebar-main-container").offsetWidth +
            "px";
        var dropdowns = document.getElementsByClassName("dropdown-btn");
        for (var i = 0; i < dropdowns.length; i++) {
            dropdowns[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var dropdownContent = this.nextElementSibling;
                // var computedStyle = window.getComputedStyle(dropdownContent);
                // console.log(computedStyle);
                if (this.classList.contains("active")) {
                    var maxHeight = dropdownContent.scrollHeight;
                    dropdownContent.style = "max-height:" + maxHeight + "px;";
                } else {
                    dropdownContent.style = "max-height: 0px;";
                }
            });
        }
    });
</script>