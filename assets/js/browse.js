$(document).ready(function () {
    loadEverything();
    window.frames["viewer"].contentDocument.oncontextmenu = function(){
        alert(1)
        return false; 
    };
});

var student_id = null;
var is_completed = 0;

function loadEverything() {
    loadStudentID();
    loadProfile();
    loadResearches();
}

function loadStudentID() {
    $.ajax({
        url: "../routes/auth.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadProfile",
        },
        beforeSend: function () {
            console.log("loading ID...");
        },
        success: function (response) {
            console.log(response);
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function loadProfile() {
    $.ajax({
        url: "../routes/profile.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadProfile",
        },
        beforeSend: function () {
            console.log("loading profile...");
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "PROFILE_LOADED") {
                response.PROFILE.forEach((element) => {
                    is_completed = element.is_completed;
                });
            } else {
                console.log("sus! how did u get in?");
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function loadResearches() {
    $.ajax({
        url: "../routes/researches.route.php",
        type: "POST",
        dataType: "JSON",
        data: {
            action: "LoadResearches",
        },
        beforeSend: function () {
            console.log("loading researches...");
        },
        success: function (response) {
            console.log(response);
            if (response.MESSAGE == "RESEARCHES_LOADED") {
                $("#allresearches").empty();
                response.RESEARCHES.forEach((element) => {
                    const divhead = (is_completed != 0) ? `<div class="col-lg-3 col-sm-6" <?php ($_SESSION['isCompleted'] == 1) ? (echo 'role="button" onclick="viewResearch(\'`+ element.research_id +`\', \'` + element.title + `\')"') : '' ?> >` : `<div class="col-lg-3 col-sm-6">`;;
                    $("#allresearches").append(
                        ``+ divhead +`
                        
                            <div class="item">
                            <div class="thumb">
                                <img src="../assets/uploaded/images/`+ ((element.image != "") ? element.image : 'no-image.svg') +`" alt="" width="171px" height="171px">
                                <div class="hover-effect">
                                <div class="content">
                                    <div class="live">
                                    <a href="#">` +
                            element.research_id +
                            `</a>
                                    </div>
                                    <ul>
                                    <li><a href="#"><i class="fa fa-research"></i>ID ` +
                            element.id +
                            `</a></li>
                                    <li><a href="#"><i class="fa fa-calendar"></i> ` +
                            element.inserted_at +
                            `</a></li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                            <div class="down-content">
                                <div class="avatar">
                                <img src="../assets/images/avatar-01.jpg" alt="" style="max-width: 46px; border-radius: 50%; float: left;">
                                </div>
                                <span><i class="fa fa-check"></i> ` +
                            element.author +
                            `</span>
                                <h4>` +
                            (element.title).slice(0, 15) +
                            `... </h4>
                            </div>
                            </div>
                        </div>
                    `
                    );
                });
            } else {
                $("#allresearches")
                    .empty()
                    .append(
                        `
                        <div class="col-lg-3 col-sm-6 text-center">
                            Nothing to show in here!
                        </div>
                    `
                    );
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

// TRIGGERED FUNCCTIONS
function viewResearch(research_id, title) {
    $.ajax({
        url: "../routes/researches.route.php",
        type: "POST",
        data: {
            action: "LoadResearch",
            research_id: research_id,
        },
        dataType: "JSON",
        beforeSend: function () {
            console.log("fetching research...");
        },
        success: function (response) {
            response.RESEARCH.forEach((element) => {
                viewSoftCopyBtn(element.copy, element.title);
            });
        },
        error: function (err) {
            console.log(err);
        },
    });
}

function viewSoftCopyBtn(file, title) {
    // window.open('../assets/uploaded/copies/'+ file +'', '_blank');
    $("#updateResearchModal").modal("hide");
    $('#viewResearchModal').modal('show');
    $('#viewResearchModal').find('#modalResearchTitle').empty().text(title);
    $('#viewResearchModal').find('iframe').attr('src','../assets/uploaded/copies/'+ file +'#toolbar=0');
}

document.oncontextmenu = function() { 
    return false; 
};
